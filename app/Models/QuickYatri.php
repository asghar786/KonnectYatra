<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A Quick Yatri application — one row per printed Konnect.US application sheet.
 *
 * Its own table (`quick_yatris`), deliberately separate from `yatri_visas`: the
 * columns here mirror the paper form one for one, so the sheet that is printed,
 * the screen that is typed into, and the record that is stored cannot drift.
 */
class QuickYatri extends Model
{
    use HasFactory;

    protected $table = 'quick_yatris';

    protected $guarded = ['id'];

    protected $casts = [
        'custom_price'         => 'boolean',
        'wheelchair_airport'   => 'boolean',
        'wheelchair_full_trip' => 'boolean',
        'meal_vegetarian'      => 'boolean',
        'pay_cash'             => 'boolean',
        'pay_zelle'            => 'boolean',
        'pay_check'            => 'boolean',
        'upload_passport'      => 'boolean',
        'upload_green_card'    => 'boolean',
        'upload_id_license'    => 'boolean',
        'date_of_birth'        => 'date',
        'date_of_issue'        => 'date',
        'date_of_expiry'       => 'date',
        'previous_visit_date'  => 'date',
        'signature_date'       => 'date',
    ];

    /**
     * The price grid on the sheet: Trip x (5-Star | Land).
     *
     * The amounts here are the *fallback* defaults only — the live price of
     * each row is edited in the admin (Quick Yatri → Update prices) and kept in
     * `site_settings`, so a fare change needs no deploy. Read prices through
     * `tripOptions()` / `amountFor()`, never straight off this constant.
     */
    const TRIP_OPTIONS = [
        'round_trip_5star' => ['label' => 'Round Trip — 5-Star Package',   'amount' => 3150],
        'one_way_5star'    => ['label' => 'One-Way Trip — 5-Star Package', 'amount' => 2650],
        'round_trip_land'  => ['label' => 'Round Trip — Land Package',     'amount' => 1650],
    ];

    /** The one option on the sheet that carries a surcharge. Also editable. */
    const WHEELCHAIR_FULL_TRIP_FEE = 300;

    /** Where each editable price lives in `site_settings`. */
    const PRICE_KEYS = [
        'round_trip_5star' => 'qy_price_round_trip_5star',
        'one_way_5star'    => 'qy_price_one_way_5star',
        'round_trip_land'  => 'qy_price_round_trip_land',
    ];

    /** The wheelchair-throughout surcharge, same treatment. */
    const WHEELCHAIR_FEE_KEY = 'qy_price_wheelchair_full_trip';

    /**
     * The grid as it stands today: the constant's labels, with whatever amount
     * the admin last saved. A setting that was never touched (or was blanked)
     * falls back to the constant, so the sheet always prices something.
     */
    public static function tripOptions(): array
    {
        $out = [];
        foreach (self::TRIP_OPTIONS as $key => $option) {
            $stored = SiteSetting::get(self::PRICE_KEYS[$key]);
            $option['amount'] = is_numeric($stored) ? (float) $stored : (float) $option['amount'];
            $out[$key] = $option;
        }

        return $out;
    }

    /** The wheelchair-throughout surcharge, as currently priced. */
    public static function wheelchairFee(): float
    {
        $stored = SiteSetting::get(self::WHEELCHAIR_FEE_KEY);

        return is_numeric($stored) ? (float) $stored : (float) self::WHEELCHAIR_FULL_TRIP_FEE;
    }

    /**
     * Save the grid. Only the keys handed in are written, and a blank value
     * clears the setting so that row goes back to its constant default rather
     * than being priced at $0.
     */
    public static function putPrices(array $amounts): void
    {
        $keys = self::PRICE_KEYS + ['wheelchair_full_trip' => self::WHEELCHAIR_FEE_KEY];

        foreach ($keys as $field => $key) {
            if (!array_key_exists($field, $amounts)) {
                continue;
            }
            $value = $amounts[$field];
            SiteSetting::put($key, ($value === null || $value === '') ? '' : (string) round((float) $value, 2));
        }
    }

    /**
     * The first condition printed in the sheet's footer box — how long the
     * application is good for, and the late fee after that date.
     *
     * This is dated copy by nature: the deadline moves every season, and the
     * office should not need a deploy to move it. So the sentence is edited in
     * the admin (Quick Yatri → Update prices) and kept in `site_settings`, with
     * this constant as the fallback a blanked field falls back to. Read it
     * through `validityNote()`, never straight off the constant.
     */
    const VALIDITY_NOTE = 'This application is valid through September 15, 2026. Add $100 for applications submitted from September 20 through October 15, 2026.';

    const VALIDITY_NOTE_KEY = 'qy_validity_note';

    /**
     * How long the sentence may run, in characters. MEASURED, not chosen.
     *
     * Page 1 is a fixed 11in box with no slack, and the footer panel this
     * sentence heads has room for a bullet of **five** lines — measured in
     * headless Chrome, 0.4px to spare, six lines pushes the row 14.6px past the
     * page. Five lines held 220 characters at the worst wrapping tried (17-char
     * words, ~44 chars a line); ordinary prose fits 220 in four. Raising this
     * needs the measurement redone, not an estimate.
     */
    const VALIDITY_NOTE_MAX = 220;

    /** The sentence as it stands today — the office's, or the constant's. */
    public static function validityNote(): string
    {
        $stored = trim((string) SiteSetting::get(self::VALIDITY_NOTE_KEY));

        return $stored !== '' ? $stored : self::VALIDITY_NOTE;
    }

    /**
     * Save it. Blank clears the setting, which puts the sheet back on the
     * constant above rather than printing a bullet with nothing in it.
     */
    public static function putValidityNote(?string $text): void
    {
        SiteSetting::put(self::VALIDITY_NOTE_KEY, trim((string) $text));
    }

    /**
     * "$3,150" — whole dollars, the way every price reads on the sheet.
     *
     * A price is never negative, but a Balance is: an overpayment reads
     * "-$350", not "$-350", so the one figure on the sheet that can go below
     * zero is still a legible amount of money.
     */
    public static function money($amount): string
    {
        $amount = (float) $amount;

        return ($amount < 0 ? '-$' : '$') . number_format(abs($amount));
    }

    const BOOKING_TYPES = [
        'round_trip_phl' => 'Round Trip (ISB/LHE)',
        'land_package'   => 'Land Package',
    ];

    const PORTS_OF_ENTRY  = ['Wagah', 'Islamabad', 'Lahore'];
    const MARITAL_STATUS  = ['Married', 'Single', 'Divorced', 'Widowed'];

    /** Today's price for the chosen row of the grid, or null if nothing is ticked. */
    public static function amountFor(?string $tripOption): ?float
    {
        $options = self::tripOptions();

        return isset($options[$tripOption]) ? (float) $options[$tripOption]['amount'] : null;
    }

    public function tripLabel(): string
    {
        return self::TRIP_OPTIONS[$this->trip_option]['label'] ?? '—';
    }

    /**
     * The per-person price this applicant is actually travelling on: their own
     * agreed price when one was set by hand, otherwise the grid's.
     */
    public function baseAmount(): ?float
    {
        if ($this->custom_price) {
            return $this->package_amount === null ? null : (float) $this->package_amount;
        }

        return self::amountFor($this->trip_option);
    }

    /** Base + the one surcharge the sheet carries, priced as it stands today. */
    public function grandTotal(): ?float
    {
        $base = $this->baseAmount();
        if ($base === null) {
            return null;
        }

        return $base + ($this->wheelchair_full_trip ? self::wheelchairFee() : 0.0);
    }

    /** What has been handed over so far; null when nothing is recorded yet. */
    public function paidAmount(): ?float
    {
        return $this->amount_paid === null ? null : (float) $this->amount_paid;
    }

    /**
     * What is still owed. Derived, never stored: the sheet prints Amount, Paid
     * and Balance side by side, and three stored numbers would eventually
     * disagree with each other.
     */
    public function balanceAmount(): ?float
    {
        $total = $this->grandTotal();

        return $total === null ? null : $total - (float) ($this->amount_paid ?? 0);
    }

    /** Write `package_amount` / `total_amount` from whatever the row now says. */
    public function repriceFromOptions(): void
    {
        $this->package_amount = $this->baseAmount();
        $this->total_amount   = $this->grandTotal();
    }

    /**
     * A date field in the house format — DD-MMM-YYYY with the month upper-cased,
     * e.g. 21-AUG-2026. The same stamp `YatriDate` writes, so every date on
     * screen, on the sheet and in the list reads identically.
     */
    public function stamp(string $field): string
    {
        return $this->{$field}
            ? strtoupper($this->{$field}->format('d-M-Y'))
            : '';
    }

    /** Where the applicant's photograph lives on disk, or null. */
    public function photoPath(): ?string
    {
        if (!$this->photo) {
            return null;
        }
        $path = public_path('quick_yatri_uploads/' . $this->photo);

        return is_file($path) ? $path : null;
    }

    public function photoUrl(): ?string
    {
        return $this->photoPath() ? asset('quick_yatri_uploads/' . $this->photo) : null;
    }
}
