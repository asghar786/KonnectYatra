<?php

namespace App\Support;

/**
 * Writes the travelling list as a real .xlsx, laid out like the office's own
 * spreadsheet: the Konnect.US logo, the boxed title, a navy header row with
 * filter arrows, then Yatri # / Yatri Name / Nationality / Passport #.
 *
 * Hand-written Office Open XML zipped with ZipArchive rather than a spreadsheet
 * library: it is one fixed sheet, and a new composer package would be a new
 * thing for every deploy to install. If the sheet ever needs formulas, several
 * tabs or reading uploaded workbooks, that is the point to switch to
 * phpoffice/phpspreadsheet.
 */
class YatriListXlsx
{
    const SHEET = 'Yatri List';

    /** Row of the column headings; data starts on the row below it. */
    const HEAD_ROW = 6;

    /** Logo height on the sheet, in pixels — it sits over rows 1-4. */
    const LOGO_PX = 84;

    /**
     * @param  \App\Models\QuickYatri[]  $yatris  in printed order
     * @return string path of a temporary .xlsx the caller sends and deletes
     */
    public static function build(string $title, array $yatris, ?string $logo): string
    {
        $path = tempnam(sys_get_temp_dir(), 'qyl');
        $zip  = new \ZipArchive();
        $zip->open($path, \ZipArchive::OVERWRITE);

        $hasLogo = $logo && is_file($logo);

        $zip->addFromString('[Content_Types].xml', self::contentTypes($hasLogo));
        $zip->addFromString('_rels/.rels', self::rels([
            ['rId1', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument', 'xl/workbook.xml'],
        ]));
        $zip->addFromString('xl/workbook.xml', self::workbook(count($yatris)));
        $zip->addFromString('xl/_rels/workbook.xml.rels', self::rels([
            ['rId1', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet', 'worksheets/sheet1.xml'],
            ['rId2', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles', 'styles.xml'],
        ]));
        $zip->addFromString('xl/styles.xml', self::styles());
        $zip->addFromString('xl/worksheets/sheet1.xml', self::sheet($title, $yatris, $hasLogo));

        if ($hasLogo) {
            $zip->addFromString('xl/worksheets/_rels/sheet1.xml.rels', self::rels([
                ['rId1', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/drawing', '../drawings/drawing1.xml'],
            ]));
            $zip->addFromString('xl/drawings/drawing1.xml', self::drawing($logo));
            $zip->addFromString('xl/drawings/_rels/drawing1.xml.rels', self::rels([
                ['rId1', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/image', '../media/image1.png'],
            ]));
            $zip->addFile($logo, 'xl/media/image1.png');
        }

        $zip->close();

        return $path;
    }

    private static function contentTypes(bool $hasLogo): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . ($hasLogo ? '<Default Extension="png" ContentType="image/png"/>' : '')
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . ($hasLogo ? '<Override PartName="/xl/drawings/drawing1.xml" ContentType="application/vnd.openxmlformats-officedocument.drawing+xml"/>' : '')
            . '</Types>';
    }

    private static function rels(array $rels): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
        foreach ($rels as [$id, $type, $target]) {
            $xml .= '<Relationship Id="' . $id . '" Type="' . $type . '" Target="' . $target . '"/>';
        }

        return $xml . '</Relationships>';
    }

    private static function workbook(int $count): string
    {
        $last  = self::HEAD_ROW + max($count, 1);
        $sheet = "'" . self::SHEET . "'";

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="' . self::SHEET . '" sheetId="1" r:id="rId1"/></sheets>'
            . '<definedNames>'
            . '<definedName name="_xlnm._FilterDatabase" localSheetId="0" hidden="1">' . $sheet . '!$A$' . self::HEAD_ROW . ':$D$' . $last . '</definedName>'
            // The heading row repeats at the top of every printed page.
            . '<definedName name="_xlnm.Print_Titles" localSheetId="0">' . $sheet . '!$' . self::HEAD_ROW . ':$' . self::HEAD_ROW . '</definedName>'
            . '</definedNames>'
            . '</workbook>';
    }

    /**
     * cellXfs, by index: 0 default, 1 title box, 2 header, 3 data centred, 4 data left.
     * Every cell of the merged title carries style 1 — a merged range only shows
     * the border its member cells have.
     */
    private static function styles(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="3">'
            . '<font><sz val="11"/><color rgb="FF1F2A44"/><name val="Calibri"/><family val="2"/></font>'
            . '<font><b/><sz val="15"/><color rgb="FF1F3864"/><name val="Calibri"/><family val="2"/></font>'
            . '<font><b/><sz val="12"/><color rgb="FFFFFFFF"/><name val="Calibri"/><family val="2"/></font>'
            . '</fonts>'
            . '<fills count="3">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FF1F2A44"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="4">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . self::border('medium', 'FF2F6F62')
            . self::border('thin', 'FF5A6785')
            . self::border('thin', 'FFBFC6D4')
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="5">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf>'
            . '<xf numFmtId="0" fontId="2" fillId="2" borderId="2" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="3" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="3" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="left" vertical="center" indent="1"/></xf>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }

    private static function border(string $style, string $rgb): string
    {
        $side = '<%1$s style="' . $style . '"><color rgb="' . $rgb . '"/></%1$s>';

        return '<border>' . sprintf($side, 'left') . sprintf($side, 'right') . sprintf($side, 'top') . sprintf($side, 'bottom') . '<diagonal/></border>';
    }

    private static function sheet(string $title, array $yatris, bool $hasLogo): string
    {
        $head = self::HEAD_ROW;
        $last = $head + max(count($yatris), 1);

        $rows = '';
        // Rows 1-4 hold the logo; row 5 is the title box.
        for ($r = 1; $r <= 4; $r++) {
            $rows .= '<row r="' . $r . '" ht="18" customHeight="1"/>';
        }
        $rows .= '<row r="5" ht="44" customHeight="1">'
            . self::str('A5', $title, 1) . '<c r="B5" s="1"/><c r="C5" s="1"/><c r="D5" s="1"/>'
            . '</row>';
        $rows .= '<row r="' . $head . '" ht="24" customHeight="1">'
            . self::str('A' . $head, 'Yatri #', 2)
            . self::str('B' . $head, 'Yatri Name', 2)
            . self::str('C' . $head, 'Nationality', 2)
            . self::str('D' . $head, 'Passport #', 2)
            . '</row>';

        foreach ($yatris as $i => $yatri) {
            $r = $head + 1 + $i;
            $rows .= '<row r="' . $r . '" ht="20" customHeight="1">'
                . '<c r="A' . $r . '" s="3"><v>' . ($i + 1) . '</v></c>'
                . self::str('B' . $r, strtoupper(trim((string) $yatri->applicant_name)), 4)
                . self::str('C' . $r, YatriList::nationality($yatri->citizenship), 3)
                // A string, not a number: passport numbers keep their leading zeros.
                . self::str('D' . $r, strtoupper(trim((string) $yatri->passport_no)), 3)
                . '</row>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheetPr><pageSetUpPr fitToPage="1"/></sheetPr>'
            . '<dimension ref="A1:D' . $last . '"/>'
            . '<sheetViews><sheetView workbookViewId="0" showGridLines="0">'
            . '<pane ySplit="' . $head . '" topLeftCell="A' . ($head + 1) . '" activePane="bottomLeft" state="frozen"/>'
            . '<selection pane="bottomLeft" activeCell="A' . ($head + 1) . '" sqref="A' . ($head + 1) . '"/>'
            . '</sheetView></sheetViews>'
            . '<sheetFormatPr defaultRowHeight="15"/>'
            . '<cols>'
            . '<col min="1" max="1" width="10" customWidth="1"/>'
            . '<col min="2" max="2" width="40" customWidth="1"/>'
            . '<col min="3" max="3" width="20" customWidth="1"/>'
            . '<col min="4" max="4" width="22" customWidth="1"/>'
            . '</cols>'
            . '<sheetData>' . $rows . '</sheetData>'
            . '<autoFilter ref="A' . $head . ':D' . $last . '"/>'
            . '<mergeCells count="1"><mergeCell ref="A5:D5"/></mergeCells>'
            . '<pageMargins left="0.5" right="0.5" top="0.6" bottom="0.6" header="0.3" footer="0.3"/>'
            . '<pageSetup paperSize="1" orientation="portrait" fitToWidth="1" fitToHeight="0"/>'
            . ($hasLogo ? '<drawing r:id="rId1"/>' : '')
            . '</worksheet>';
    }

    /** One inline-string cell — no shared-strings part to keep in step. */
    private static function str(string $ref, string $text, int $style): string
    {
        $text = htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        return '<c r="' . $ref . '" s="' . $style . '" t="inlineStr"><is><t xml:space="preserve">' . $text . '</t></is></c>';
    }

    /** The logo, kept to its own proportions, sitting over rows 1-4 from A1. */
    private static function drawing(string $logo): string
    {
        [$w, $h] = getimagesize($logo) ?: [1200, 291];
        $emu = 9525; // per pixel
        $cy  = self::LOGO_PX * $emu;
        $cx  = (int) round(self::LOGO_PX * $w / max($h, 1)) * $emu;

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<xdr:wsDr xmlns:xdr="http://schemas.openxmlformats.org/drawingml/2006/spreadsheetDrawing" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<xdr:oneCellAnchor>'
            . '<xdr:from><xdr:col>0</xdr:col><xdr:colOff>' . (4 * $emu) . '</xdr:colOff><xdr:row>0</xdr:row><xdr:rowOff>' . (2 * $emu) . '</xdr:rowOff></xdr:from>'
            . '<xdr:ext cx="' . $cx . '" cy="' . $cy . '"/>'
            . '<xdr:pic>'
            . '<xdr:nvPicPr><xdr:cNvPr id="2" name="Konnect.US logo"/><xdr:cNvPicPr><a:picLocks noChangeAspect="1"/></xdr:cNvPicPr></xdr:nvPicPr>'
            . '<xdr:blipFill><a:blip r:embed="rId1"/><a:stretch><a:fillRect/></a:stretch></xdr:blipFill>'
            . '<xdr:spPr><a:xfrm><a:off x="0" y="0"/><a:ext cx="' . $cx . '" cy="' . $cy . '"/></a:xfrm><a:prstGeom prst="rect"><a:avLst/></a:prstGeom></xdr:spPr>'
            . '</xdr:pic>'
            . '<xdr:clientData/>'
            . '</xdr:oneCellAnchor>'
            . '</xdr:wsDr>';
    }
}
