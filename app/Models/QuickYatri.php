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

    /** The price grid on the sheet: Trip x (5-Star | Land). */
    const TRIP_OPTIONS = [
        'round_trip_5star' => ['label' => 'Round Trip — 5-Star Package',   'amount' => 3150],
        'one_way_5star'    => ['label' => 'One-Way Trip — 5-Star Package', 'amount' => 2650],
        'round_trip_land'  => ['label' => 'Round Trip — Land Package',     'amount' => 1650],
    ];

    /** The one option on the sheet that carries a surcharge. */
    const WHEELCHAIR_FULL_TRIP_FEE = 300;

    const BOOKING_TYPES = [
        'round_trip_phl' => 'Round Trip PHL-ISB/LHE-PHL (PA/DE/NJ-SO)',
        'land_package'   => 'Land Package',
    ];

    const PORTS_OF_ENTRY  = ['Wagah', 'Islamabad', 'Lahore'];
    const MARITAL_STATUS  = ['Married', 'Single', 'Divorced', 'Widowed'];

    /** Base price of the chosen row of the grid, or null if nothing is ticked. */
    public static function amountFor(?string $tripOption): ?float
    {
        return isset(self::TRIP_OPTIONS[$tripOption])
            ? (float) self::TRIP_OPTIONS[$tripOption]['amount']
            : null;
    }

    public function tripLabel(): string
    {
        return self::TRIP_OPTIONS[$this->trip_option]['label'] ?? '—';
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
