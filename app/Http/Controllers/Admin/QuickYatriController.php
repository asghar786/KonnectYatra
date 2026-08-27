<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuickYatri;
use App\Support\UsAirports;
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

        // Feeds the "Download Blank Form" airport picker — a representative
        // working one region (e.g. a Miami event) can hand out sheets that
        // already show that departure airport instead of a blank line. Same
        // full US list the sheet's own "Travelling from" dropdown offers.
        $airportGroups = UsAirports::grouped();

        // The editable price grid behind the toolbar's OW / RT / LP pills, plus
        // how many saved rows still sit on standard pricing — the "apply to
        // existing applications" tick in the price modal counts those.
        $prices        = QuickYatri::tripOptions();
        $wheelchairFee = QuickYatri::wheelchairFee();
        $standardCount = $rows->where('custom_price', false)->whereNotNull('trip_option')->count();

        // The sheet's first printed condition, pre-filled into the same dialog
        // as the effective sentence (not the raw setting) so a date can be
        // edited in place instead of retyped.
        $validityNote = QuickYatri::validityNote();

        return view('admin.quick-yatri.index', compact(
            'rows', 'airportGroups', 'prices', 'wheelchairFee', 'standardCount', 'validityNote'
        ));
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
        $row = new QuickYatri();

        // Optional ?airport=CODE pre-fills the "Travelling from" line on the
        // printed blank sheet (e.g. "MIA/FL") instead of leaving a line to
        // write on — for a representative handing out sheets at one region's
        // event, where every candidate signing up there departs from the same
        // airport. Never persisted; $row here only ever renders, it is not saved.
        $airport = strtoupper(trim((string) request('airport')));
        if (UsAirports::has($airport)) {
            $row->departure_airport_code = $airport;
        }

        return view('admin.quick-yatri.sheet', [
            'row'       => $row,
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

    /**
     * The grid itself — One-Way / Round Trip / Land Package, and the wheelchair
     * surcharge. Kept in `site_settings` so the office can move a fare without a
     * deploy; a field left blank clears the setting and that row falls back to
     * the constant in the model rather than being priced at $0.
     *
     * The sheet's first printed condition (the validity date and the late fee)
     * is saved here too — same dialog, same reason: it is dated copy the office
     * rewrites each season, and it should not need a developer.
     */
    public function updatePrices(Request $request)
    {
        $rules = ['nullable', 'numeric', 'min:0', 'max:99999'];

        $data = $request->validate([
            'round_trip_5star'     => $rules,
            'one_way_5star'        => $rules,
            'round_trip_land'      => $rules,
            'wheelchair_full_trip' => $rules,
            'validity_note'        => ['nullable', 'string', 'max:' . QuickYatri::VALIDITY_NOTE_MAX],
        ]);

        QuickYatri::putPrices($data);

        // The sheet's first condition rides in the same dialog: it is the other
        // thing printed on that footer that the office moves season to season.
        // A blank field clears the setting, which restores the model default
        // rather than printing an empty bullet. Guarded on the key being present
        // so a caller posting prices alone can never wipe the sentence.
        $noteWas = QuickYatri::validityNote();
        if ($request->has('validity_note')) {
            QuickYatri::putValidityNote($data['validity_note'] ?? null);
        }

        // A saved row stores the price it was quoted at, so moving the grid does
        // not move it on its own. Ticking "apply to existing" re-stamps every
        // row that is still on standard pricing; rows carrying their own agreed
        // price are never touched either way.
        $repriced = 0;
        if ($request->boolean('apply_existing')) {
            foreach (QuickYatri::where('custom_price', false)->whereNotNull('trip_option')->get() as $row) {
                $row->repriceFromOptions();
                if ($row->isDirty()) {
                    $row->save();
                    $repriced++;
                }
            }
        }

        $message = QuickYatri::validityNote() === $noteWas
            ? 'Prices updated.'
            : 'Prices and the sheet\'s first condition updated.';
        if ($repriced) {
            $message .= ' ' . $repriced . ' saved ' . ($repriced === 1 ? 'application was' : 'applications were') . ' re-priced.';
        }

        return redirect()->route('quick-yatri')->with('success', $message);
    }

    /**
     * One applicant's own price. Two yatris on the same trip option are not
     * always quoted the same thing — group size, departure airport, an event
     * rate — so a row can carry its own amount and the reason for it.
     * Submitting the form with "reset" puts the row back on the grid price.
     */
    public function updateRowPrice(Request $request, $id)
    {
        $row = QuickYatri::findOrFail($id);

        $data = $request->validate([
            'package_amount' => ['nullable', 'numeric', 'min:0', 'max:99999'],
            'price_note'     => ['nullable', 'string', 'max:255'],
        ]);

        $clearing = $request->boolean('reset')
            || $data['package_amount'] === null
            || $data['package_amount'] === '';

        if ($clearing) {
            $row->custom_price = false;
            $row->price_note   = null;
        } else {
            $row->custom_price   = true;
            $row->package_amount = (float) $data['package_amount'];
            $row->price_note     = $data['price_note'] ?: null;
        }

        $row->repriceFromOptions();
        $row->save();

        return redirect()->route('quick-yatri')->with('success', $clearing
            ? $row->applicant_name . ' is back on the standard price.'
            : 'Price set for ' . $row->applicant_name . '.');
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
            // booking_type is not listed: the Round Trip / Land Package radios it
            // fed were removed from the sheet's top bar, so nothing posts it any
            // more. Validating it here would write null over the value already
            // stored on older records every time one of them is re-saved.
            //
            // Not Rule::in() against the UsAirports list on purpose — a code
            // saved before that list existed must not block re-saving the record
            // that already picked it, the same reasoning as the package form's
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

        // Email addresses are case-insensitive by convention — store the
        // form the applicant is going to type back at us if they ever log
        // in or reply, not whatever mix of case they happened to type here.
        if (!empty($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }

        // Tick boxes: absent means unticked, so read every one explicitly.
        //
        // upload_passport / upload_green_card / upload_id_license are NOT in
        // this list any more, and that is deliberate — the same reasoning as
        // booking_type above. The Uploads panel they lived in was removed from
        // the sheet on 2026-08-27 (page 2 already lists the documents
        // required), so nothing posts them; reading them here would write false
        // over the value every older record already carries, every time one of
        // them is re-saved. The columns and their data are left alone.
        foreach ([
            'wheelchair_airport', 'wheelchair_full_trip', 'meal_vegetarian',
            // How they are paying, ticked at the foot of page 1. Three boxes
            // rather than one choice: a deposit paid one way and the balance
            // another is ordinary, and the paper sheet allows it.
            'pay_cash', 'pay_zelle', 'pay_check',
        ] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        // Price follows the ticked row of the grid; the full-trip wheelchair is
        // the only option on the sheet that adds to it.
        //
        // Unless this applicant was quoted their own price — a family booking
        // six seats, a cheaper departure airport, a rate agreed at a gurdwara
        // event. That is set from the list's price modal and flagged on the row,
        // and re-saving the sheet must never quietly put the grid price back.
        $custom = $existing && $existing->custom_price;
        $base   = $custom
            ? ($existing->package_amount === null ? null : (float) $existing->package_amount)
            : QuickYatri::amountFor($data['trip_option'] ?? null);

        $data['custom_price']   = (bool) $custom;
        $data['package_amount'] = $base;
        $data['total_amount']   = $base === null
            ? null
            : $base + ($data['wheelchair_full_trip'] ? QuickYatri::wheelchairFee() : 0);

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
