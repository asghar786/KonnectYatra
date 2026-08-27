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

    /** "$3,150" — whole dollars, the way every price reads on the sheet. */
    public static function money($amount): string
    {
        return '$' . number_format((float) $amount);
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
