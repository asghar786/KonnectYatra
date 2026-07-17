<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gurdwara;
use App\Support\GurdwaraGeo;
use Illuminate\Http\Request;

/**
 * Address Book — the field tool for gurdwara visits.
 *
 * Rashad opens this on his phone at a gurdwara: it ranks every gurdwara by real
 * distance from his GPS position so he can update the one he's standing in,
 * mark it visited, and see what to drive to next. Ranking happens in the browser
 * because only the browser knows where he is; the server just ships coordinates.
 */
class AddressBookController extends Controller
{
    public function index()
    {
        $gurdwaras = Gurdwara::orderBy('gurdwara_name')->get();
        $coords = GurdwaraGeo::coords($gurdwaras);

        // Only rows we can place on a map can be ranked by distance; the rest are
        // listed separately rather than silently dropped.
        $located = $unlocated = [];
        foreach ($gurdwaras as $g) {
            $row = [
                'id'       => $g->id,
                'name'     => $g->gurdwara_name,
                'address'  => trim(collect([$g->address, $g->city, GurdwaraGeo::canonicalState($g->state), $g->zip])->filter()->implode(', ')),
                'phone'    => $g->phone_no,
                'image'    => $g->gurdwara_image,
                'visited'  => $g->visited_at ? \Carbon\Carbon::parse($g->visited_at)->format('d M Y') : null,
                'edit_url' => route('edit-gurdwara', $g->id),
            ];
            if (isset($coords[$g->id])) {
                $row['lat'] = $coords[$g->id][0];
                $row['lng'] = $coords[$g->id][1];
                $located[] = $row;
            } else {
                $unlocated[] = $row;
            }
        }

        return view('admin.gurdwara.address_book', [
            'located'   => $located,
            'unlocated' => $unlocated,
            'total'     => $gurdwaras->count(),
            'visited'   => $gurdwaras->whereNotNull('visited_at')->count(),
        ]);
    }

    /** Record (or clear) an in-person visit. */
    public function visit(Request $request, $id)
    {
        $request->validate(['visit_notes' => 'nullable|string|max:2000']);
        $gurdwara = Gurdwara::findOrFail($id);

        if ($request->input('action') === 'clear') {
            $gurdwara->visited_at = null;
            $gurdwara->visited_by = null;
            $gurdwara->save();
            return back()->with('success', "Cleared the visit on {$gurdwara->gurdwara_name}.");
        }

        $gurdwara->visited_at = now();
        $gurdwara->visited_by = optional(\Auth::user())->name;
        if ($request->filled('visit_notes')) {
            $gurdwara->visit_notes = $request->visit_notes;
        }
        $gurdwara->save();

        return back()->with('success', "Marked {$gurdwara->gurdwara_name} as visited today.");
    }
}
