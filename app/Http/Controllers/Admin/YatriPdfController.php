<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YatriVisa;
use setasign\Fpdi\Fpdi;

class YatriPdfController extends Controller
{
    /** A — download the Yatri form only (pages 1 & 2), no documents. */
    public function downloadForm($id)
    {
        $yatri = $this->loadYatri($id);
        $pdf = \PDF::loadView('pdf.yatri_form', [
            'yatri'    => $yatri,
            'photoSrc' => $this->photoSrc($yatri),
            'chrome'   => true,
        ])->setPaper('a4');
        return $this->pdfResponse($pdf->output(), 'Yatri-Form-' . $yatri->yatri_id . '.pdf');
    }

    /** B — PDF: form + each document on its own page with smart header/footer + page numbers. */
    public function exportPdf($id)
    {
        $yatri    = $this->loadYatri($id);
        $formPath = $this->renderFormPdf($yatri, false);   // no baked chrome; FPDI stamps it
        $bytes    = $this->buildMerged($formPath, $this->collectDocuments($yatri), true, $yatri);
        @unlink($formPath);
        return $this->pdfResponse($bytes, 'Yatri-Form-' . $yatri->yatri_id . '.pdf');
    }

    /** C — PDF: the form followed by all documents appended raw (no header/footer/page numbers on doc pages). */
    public function exportPdfWithDocs($id)
    {
        $yatri    = $this->loadYatri($id);
        $formPath = $this->renderFormPdf($yatri, true);    // designed form with its own header/footer
        $bytes    = $this->buildMerged($formPath, $this->collectDocuments($yatri), false, $yatri);
        @unlink($formPath);
        return $this->pdfResponse($bytes, 'Yatri-Form-with-Documents-' . $yatri->yatri_id . '.pdf');
    }

    /** Form 'C' — Pakistan Foreigners Registration "Temporary Certificate of Registration", populated from the Yatri. */
    public function exportFormC($id)
    {
        $yatri = $this->loadYatri($id);
        $pdf = \PDF::loadView('pdf.form_c', ['yatri' => $yatri])->setPaper('a4');
        return $this->pdfResponse($pdf->output(), 'Form-C-' . $yatri->yatri_id . '.pdf');
    }

    /* ---------------- helpers ---------------- */

    private function loadYatri($id)
    {
        return YatriVisa::with('package', 'gurdwara', 'hotel', 'bus', 'documents', 'companions')->findOrFail($id);
    }

    private function pdfResponse(string $bytes, string $filename, string $disposition = 'attachment')
    {
        return response($bytes, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"',
        ]);
    }

    /** Render the Yatri form to a temp PDF file, return its path. */
    private function renderFormPdf($yatri, bool $chrome): string
    {
        $pdf = \PDF::loadView('pdf.yatri_form', [
            'yatri'    => $yatri,
            'photoSrc' => $this->photoSrc($yatri),
            'chrome'   => $chrome,
        ])->setPaper('a4');

        $path = tempnam(sys_get_temp_dir(), 'kyform') . '.pdf';
        file_put_contents($path, $pdf->output());
        return $path;
    }

    /** Photo as a dompdf-safe data URI (converts webp/other to PNG). */
    private function photoSrc($yatri)
    {
        if (empty($yatri->photo)) return null;
        $path = public_path('photo_uploads/' . $yatri->photo);
        if (!is_file($path)) return null;

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $mime = $ext === 'png' ? 'image/png' : ($ext === 'gif' ? 'image/gif' : 'image/jpeg');
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
        }
        [$png] = $this->toFpdfImage($path);
        if ($png) {
            $uri = 'data:image/png;base64,' . base64_encode(file_get_contents($png));
            if ($png !== $path) @unlink($png);
            return $uri;
        }
        return null;
    }

    /** Ordered list of documents: built-in uploads + additional documents. */
    private function collectDocuments($yatri): array
    {
        $docs = [];
        $builtin = [
            ['PHOTO', 'photo_uploads', $yatri->photo],
            ['PASSPORT', 'passport_uploads', $yatri->us_passport],
            ['ID / DRIVING LICENSE', 'drivinglicense_uploads', $yatri->driving_license],
            ['GREEN CARD', 'greencard_uploads', $yatri->green_card],
        ];
        foreach ($builtin as [$title, $dir, $file]) {
            if (!empty($file) && is_file(public_path($dir . '/' . $file))) {
                $docs[] = ['title' => $title, 'path' => public_path($dir . '/' . $file), 'ext' => strtolower(pathinfo($file, PATHINFO_EXTENSION))];
            }
        }
        foreach ($yatri->documents as $d) {
            if (!empty($d->file) && is_file(public_path('document_uploads/' . $d->file))) {
                $docs[] = ['title' => strtoupper($d->name), 'path' => public_path('document_uploads/' . $d->file), 'ext' => strtolower(pathinfo($d->file, PATHINFO_EXTENSION))];
            }
        }

        // Travelling companions' passports (spouse first, then family). Title shows
        // the relation, e.g. "SPOUSE PASSPORT (WIFE) - MINKO KAUR".
        $spouseRelations = ['wife', 'husband', 'partner', 'spouse'];
        foreach (($yatri->companions ?? []) as $c) {
            if (empty($c->passport_file) || !is_file(public_path('passport_uploads/' . $c->passport_file))) {
                continue;
            }
            $rel   = trim((string) $c->relation);
            $label = in_array(strtolower($rel), $spouseRelations) ? 'SPOUSE PASSPORT' : 'COMPANION PASSPORT';
            $title = $label . ($rel !== '' ? ' (' . strtoupper($rel) . ')' : '');
            if (!empty($c->full_name)) $title .= ' - ' . strtoupper($c->full_name);
            $docs[] = [
                'title' => $title,
                'path'  => public_path('passport_uploads/' . $c->passport_file),
                'ext'   => strtolower(pathinfo($c->passport_file, PATHINFO_EXTENSION)),
            ];
        }

        return $docs;
    }

    /** FPDF supports JPG/PNG/GIF only — convert anything else (webp) to a temp PNG. Returns [path, TYPE]. */
    private function toFpdfImage($path): array
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg'])) return [$path, 'JPG'];
        if (in_array($ext, ['png', 'gif']))  return [$path, strtoupper($ext)];

        $img = ($ext === 'webp' && function_exists('imagecreatefromwebp'))
            ? @imagecreatefromwebp($path)
            : @imagecreatefromstring(@file_get_contents($path));
        if (!$img) return [null, null];

        $tmp = tempnam(sys_get_temp_dir(), 'kyimg') . '.png';
        imagepng($img, $tmp);
        imagedestroy($img);
        return [$tmp, 'PNG'];
    }

    /** Count total pages so "Page X of Y" is correct in stamped mode. */
    private function countPages(string $formPath, array $docs): int
    {
        $total = 0;
        try { $f = new Fpdi(); $total += $f->setSourceFile($formPath); } catch (\Throwable $e) { $total += 1; }
        foreach ($docs as $d) {
            if ($d['ext'] === 'pdf') {
                // Skip unreadable PDFs to stay consistent with the render pass.
                try { $c = new Fpdi(); $total += $c->setSourceFile($d['path']); } catch (\Throwable $e) { /* skip */ }
            } else {
                $total += 1;
            }
        }
        return $total;
    }

    /**
     * Merge the form PDF with all documents.
     * $stamp = true  -> button B: uniform header/footer, page numbers, titled doc pages.
     * $stamp = false -> button C: form (already designed) + documents appended raw.
     */
    private function buildMerged(string $formPath, array $docs, bool $stamp, $yatri): string
    {
        $pdf    = new Fpdi();
        $total  = $stamp ? $this->countPages($formPath, $docs) : 0;
        $pageNo = 0;

        // ---- form pages ----
        $formCount = $pdf->setSourceFile($formPath);
        for ($i = 1; $i <= $formCount; $i++) {
            $tpl  = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tpl);
            $pageNo++;
            if ($stamp) $this->stampChrome($pdf, $yatri, $pageNo, $total, null, $size);
        }

        // ---- document pages ----
        foreach ($docs as $d) {
            if ($d['ext'] === 'pdf') {
                $dc = 0;
                try { $dc = $pdf->setSourceFile($d['path']); } catch (\Throwable $e) { $dc = 0; }
                for ($i = 1; $i <= $dc; $i++) {
                    $tpl  = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($tpl);
                    if ($stamp) {
                        $pdf->AddPage('P', [210, 297]);
                        $pageNo++;
                        $this->fitTemplate($pdf, $tpl, $size);
                        $this->stampChrome($pdf, $yatri, $pageNo, $total, $i === 1 ? $d['title'] : $d['title'] . ' (cont.)', ['width' => 210, 'height' => 297]);
                    } else {
                        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                        $pdf->useTemplate($tpl);
                    }
                }
            } else {
                [$imgPath, $type] = $this->toFpdfImage($d['path']);
                if (!$imgPath) continue;
                $dim = @getimagesize($imgPath) ?: [1, 1];
                $pw = $dim[0] ?: 1;
                $ph = $dim[1] ?: 1;

                if ($stamp) {
                    $pdf->AddPage('P', [210, 297]);
                    $pageNo++;
                    $this->placeImage($pdf, $imgPath, $type, $pw, $ph, 12, 30, 186, 250);
                    $this->stampChrome($pdf, $yatri, $pageNo, $total, $d['title'], ['width' => 210, 'height' => 297]);
                } else {
                    $pdf->AddPage('P', [210, 297]);
                    $this->placeImage($pdf, $imgPath, $type, $pw, $ph, 8, 8, 194, 281);
                }
                if ($imgPath !== $d['path']) @unlink($imgPath);
            }
        }

        return $pdf->Output('S');
    }

    /** Place an imported PDF page centered/scaled inside the content box (mm). */
    private function fitTemplate($pdf, $tpl, $size, $cx = 12, $cy = 30, $cw = 186, $ch = 250): void
    {
        $scale = min($cw / $size['width'], $ch / $size['height']);
        $w = $size['width'] * $scale;
        $h = $size['height'] * $scale;
        $pdf->useTemplate($tpl, $cx + ($cw - $w) / 2, $cy + ($ch - $h) / 2, $w, $h);
    }

    /** Place an image centered/scaled inside the content box (mm). */
    private function placeImage($pdf, $imgPath, $type, $pw, $ph, $cx, $cy, $cw, $ch): void
    {
        $scale = min($cw / $pw, $ch / $ph);
        $w = $pw * $scale;
        $h = $ph * $scale;
        $pdf->Image($imgPath, $cx + ($cw - $w) / 2, $cy + ($ch - $h) / 2, $w, $h, $type);
    }

    /** Smart header + footer + page number (and optional document title banner). */
    private function stampChrome($pdf, $yatri, $pageNo, $total, $title, $size): void
    {
        $w = $size['width'];

        // Header
        $pdf->SetTextColor(22, 35, 58);
        $pdf->SetFont('Helvetica', 'B', 13);
        $pdf->Text(12, 13, 'YATRI BOOKING FORM');
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetTextColor(245, 78, 24);
        $pdf->Text(12, 17, 'EXPLORE AND DISCOVER THE GLOBE');

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetTextColor(138, 147, 166);
        $pdf->Text($w - 68, 11, 'BOOKING ID');
        $pdf->SetFillColor(245, 78, 24);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->SetXY($w - 68, 13);
        $pdf->Cell(56, 7, (string) $yatri->yatri_id, 0, 0, 'C', true);

        $pdf->SetDrawColor(245, 78, 24);
        $pdf->SetLineWidth(0.6);
        $pdf->Line(12, 23, $w - 12, 23);

        // Document title banner
        if ($title) {
            $pdf->SetFillColor(22, 35, 58);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->SetXY(12, 25.5);
            $pdf->Cell($w - 24, 8, '  ' . $title, 0, 0, 'L', true);
        }

        // Footer
        $pdf->SetDrawColor(227, 160, 127);
        $pdf->SetLineWidth(0.3);
        $pdf->Line(12, 285, $w - 12, 285);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetTextColor(138, 147, 166);
        $pdf->Text(12, 290, 'KONNECT.US INC. - Explore and Discover the Globe   +1 (718) 908-9464   18502 Hillside Avenue, Jamaica, NY 11432');
        $pdf->Text($w - 38, 290, 'Page ' . $pageNo . ' of ' . $total);
    }
}
