<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuickYatri;
use App\Support\YatriDate;
use Illuminate\Http\Request;

/**
 * Quick Yatri — capture, list and print the Konnect.US Yatri Application.
 *
 * Everything renders from one template (`admin.quick-yatri.sheet`) in three
 * modes: `entry` (inputs), `blank` (empty sheet to print and hand out) and
 * `print` (a saved record laid out on the same sheet). Do not fork it — the
 * whole point is that the paper and the screen ask for the same things in the
 * same order.
 */
class QuickYatriController extends Controller
{
    /** Where applicant photographs are written. Kept out of git. */
    const PHOTO_DIR = 'quick_yatri_uploads';

    public function index()
    {
        $rows = QuickYatri::orderBy('created_at', 'desc')->get();

        return view('admin.quick-yatri.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.quick-yatri.entry', [
            'row'    => new QuickYatri(),
            'action' => route('quick-yatri-store'),
        ]);
    }

    public function store(Request $request)
    {
        $row = QuickYatri::create($this->payload($request));

        return redirect()->route('quick-yatri')
            ->with('success', 'Application saved for ' . $row->applicant_name . '.');
    }

    public function edit($id)
    {
        return view('admin.quick-yatri.entry', [
            'row'    => QuickYatri::findOrFail($id),
            'action' => route('quick-yatri-update', $id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $row = QuickYatri::findOrFail($id);
        $row->update($this->payload($request, $row));

        return redirect()->route('quick-yatri')
            ->with('success', 'Application updated for ' . $row->applicant_name . '.');
    }

    public function destroy($id)
    {
        $row = QuickYatri::findOrFail($id);

        if ($path = $row->photoPath()) {
            @unlink($path);
        }
        $row->delete();

        return redirect()->route('quick-yatri')->with('success', 'Application removed.');
    }

    /**
     * The empty sheet — print it and hand it to a candidate to fill in by pen.
     * Rendered for the browser rather than dompdf: the design is flex/grid
     * throughout, which dompdf cannot lay out, and printing from the browser
     * reproduces it exactly. Ctrl+P -> Save as PDF gives the downloadable file.
     */
    public function blank()
    {
        return view('admin.quick-yatri.sheet', [
            'row'       => new QuickYatri(),
            'mode'      => 'blank',
            'autoPrint' => request()->boolean('print'),
        ]);
    }

    /** A saved record laid out on the same sheet, ready to print or save as PDF. */
    public function printOne($id)
    {
        return view('admin.quick-yatri.sheet', [
            'row'       => QuickYatri::findOrFail($id),
            'mode'      => 'print',
            'autoPrint' => request()->boolean('print'),
        ]);
    }

    /* ---------------- helpers ---------------- */

    /** The date fields on the sheet, in the order they appear, with sheet labels. */
    const DATE_FIELDS = [
        'date_of_birth'       => 'Date of Birth',
        'date_of_issue'       => 'Date of Issue',
        'date_of_expiry'      => 'Date of Expiry',
        'previous_visit_date' => 'Previous Visit Date',
        'signature_date'      => 'Signature Date',
    ];

    /**
     * The form types dates as DD-MMM-YYYY (21-AUG-2026). Canonicalise whatever
     * came in — picker output, that stamp typed by hand, or a pasted 2026-08-21
     * — into Y-m-d before validation, so the `date` rule and the model's date
     * cast both see something unambiguous.
     *
     * Anything unparseable is left exactly as typed and then fails the
     * `date_format:Y-m-d` rule, so the admin is told — rather than this
     * silently storing a guess. Parsing is strict for the same reason:
     * createFromFormat is otherwise happy to read "31-FEB-2026" as 3 March.
     */
    private function normaliseDates(Request $request): void
    {
        foreach (array_keys(self::DATE_FIELDS) as $field) {
            $raw = trim((string) $request->input($field));
            if ($raw === '') {
                continue;
            }

            $stamped = YatriDate::format($raw);           // -> 21-AUG-2026
            $date    = \DateTime::createFromFormat('!d-M-Y', $stamped);
            $errors  = \DateTime::getLastErrors();

            $rolledOver = is_array($errors) && ($errors['warning_count'] > 0 || $errors['error_count'] > 0);

            if ($date && !$rolledOver) {
                $request->merge([$field => $date->format('Y-m-d')]);
            }
        }
    }

    /** "Date of Birth must be a real date, e.g. 21-AUG-2026." for each date field. */
    private function dateMessages(): array
    {
        $messages = [];
        foreach (self::DATE_FIELDS as $field => $label) {
            $messages[$field . '.date_format'] = $label . ' must be a real date written as DD-MMM-YYYY, e.g. 21-AUG-2026.';
        }

        return $messages;
    }

    /**
     * Validate and shape the submitted sheet.
     *
     * $existing is passed on update so an untouched file input can never blank
     * the photograph already stored.
     */
    private function payload(Request $request, QuickYatri $existing = null): array
    {
        $this->normaliseDates($request);

        $data = $request->validate([
            'sr_no'                => ['nullable', 'string', 'max:50'],
            'rt_no'                => ['nullable', 'string', 'max:50'],
            'ow_no'                => ['nullable', 'string', 'max:50'],
            'lp_no'                => ['nullable', 'string', 'max:50'],
            'booking_type'         => ['nullable', 'string', 'in:round_trip_phl,land_package'],
            // Not Rule::in() against the live departure_origins list on purpose — an
            // airport an admin later deactivates must not block re-saving an existing
            // record that already picked it, the same reasoning as the package form's
            // "(current)" option (see the 2026-07-23 decision).
            'departure_airport_code' => ['nullable', 'string', 'max:10'],
            'trip_option'          => ['nullable', 'string', 'in:round_trip_5star,one_way_5star,round_trip_land'],
            'applicant_name'       => ['required', 'string', 'max:255'],
            'gender'               => ['nullable', 'string', 'in:M,F'],
            'date_of_birth'        => ['nullable', 'date_format:Y-m-d'],
            'place_of_birth'       => ['nullable', 'string', 'max:255'],
            'cell_phone'           => ['nullable', 'string', 'max:40'],
            'email'                => ['nullable', 'email', 'max:255'],
            'father_name'          => ['nullable', 'string', 'max:255'],
            'mother_name'          => ['nullable', 'string', 'max:255'],
            'citizenship'          => ['nullable', 'string', 'max:255'],
            'passport_no'          => ['nullable', 'string', 'max:60'],
            'date_of_issue'        => ['nullable', 'date_format:Y-m-d'],
            'date_of_expiry'       => ['nullable', 'date_format:Y-m-d'],
            'first_visit_pakistan' => ['nullable', 'string', 'in:Yes,No'],
            'port_of_entry'        => ['nullable', 'string', 'in:Wagah,Islamabad,Lahore'],
            'previous_visit_date'  => ['nullable', 'date_format:Y-m-d'],
            'profession'           => ['nullable', 'string', 'max:255'],
            'family_traveling'     => ['nullable', 'string', 'in:Yes,No'],
            'family_members_count' => ['nullable', 'string', 'max:10'],
            'family_member_1'      => ['nullable', 'string', 'max:255'],
            'family_member_2'      => ['nullable', 'string', 'max:255'],
            'marital_status'       => ['nullable', 'string', 'in:Married,Single,Divorced,Widowed'],
            'home_address'         => ['nullable', 'string'],
            'city'                 => ['nullable', 'string', 'max:255'],
            'state_zip'            => ['nullable', 'string', 'max:255'],
            'nearest_gurdwara'     => ['nullable', 'string', 'max:255'],
            'gurdwara_city_state'  => ['nullable', 'string', 'max:255'],
            'signature_date'       => ['nullable', 'date_format:Y-m-d'],
            'photo'                => ['nullable', 'image', 'max:4096'],
        ], $this->dateMessages());

        // Tick boxes: absent means unticked, so read every one explicitly.
        foreach ([
            'wheelchair_airport', 'wheelchair_full_trip', 'meal_vegetarian',
            'upload_passport', 'upload_green_card', 'upload_id_license',
        ] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        // Price follows the ticked row of the grid; the full-trip wheelchair is
        // the only option on the sheet that adds to it.
        $base = QuickYatri::amountFor($data['trip_option'] ?? null);
        $data['package_amount'] = $base;
        $data['total_amount']   = $base === null
            ? null
            : $base + ($data['wheelchair_full_trip'] ? QuickYatri::WHEELCHAIR_FULL_TRIP_FEE : 0);

        if ($request->hasFile('photo')) {
            $dir = public_path(self::PHOTO_DIR);
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            $clean = preg_replace('/[^A-Za-z0-9._-]/', '', $request->file('photo')->getClientOriginalName());
            $name  = uniqid() . '_' . $clean;
            $request->file('photo')->move($dir, $name);

            if ($existing && ($old = $existing->photoPath())) {
                @unlink($old);
            }
            $data['photo'] = $name;
        } else {
            // Never let an untouched file input blank a stored filename.
            unset($data['photo']);
        }

        return $data;
    }
}
