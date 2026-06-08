<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itenary;
use App\Models\Adult;
use App\Models\Child;
use App\Models\Infant;
use App\Services\Analytics\GeoLocator;
use Barryvdh\DomPDF\Facade as PDF;

class ItenariesController extends Controller
{
    public function index()
    {
        $itenary_data = Itenary::orderBy('id', 'desc')->get();
        $this->backfillGeo($itenary_data);
        return view('admin.itenaries', ['itenaries' => $itenary_data]);
    }

    public function iternaries_list()
    {
        $itenary_data = Itenary::orderBy('id', 'desc')->get();
        $this->backfillGeo($itenary_data);
        return view('admin.iternaries-list', ['itenaries' => $itenary_data]);
    }

    public function export_pdf()
    {
        $itenaries = Itenary::orderBy('id', 'desc')->get();
        $this->backfillGeo($itenaries);

        $pdf = PDF::loadView('admin.exports.itenaries_pdf', [
            'itenaries'   => $itenaries,
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('itinerary-requests-' . now()->format('Y-m-d') . '.pdf');
    }

    public function delete($id)
    {
        $itenary = Itenary::where('id', '=', $id);
        if ($itenary) {
            $itenary->delete();
            return redirect('admin/itenaries')->with('success', 'Itinerary request deleted.');
        }
        return back()->with('error', 'Record Not Found');
    }

    /**
     * Resolve city/country for any rows that have an IP but no location yet.
     * GeoLocator caches per-IP and never throws, so this is cheap after the
     * first lookup and degrades gracefully when offline.
     */
    private function backfillGeo($itenaries): void
    {
        foreach ($itenaries as $row) {
            if (!empty($row->ip) && empty($row->country)) {
                $geo = GeoLocator::resolve($row->ip);
                if (!empty($geo['country']) || !empty($geo['city'])) {
                    $row->city = $geo['city'];
                    $row->country = $geo['country'];
                    $row->save();
                }
            }
        }
    }
}
