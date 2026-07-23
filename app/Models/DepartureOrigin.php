<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartureOrigin extends Model
{
    use HasFactory;

    protected $table = 'departure_origins';

    protected $fillable = [
        'country', 'state', 'airport_name', 'airport_code', 'sort_order', 'status',
    ];

    /**
     * Country ordering shared by both selectors: USA pinned to the top, every
     * other country alphabetical.
     *
     * sort_order still orders the airports *within* a country, but it must not
     * decide where a country lands — origins added through the admin default to
     * sort_order 0, which used to push new countries above USA.
     */
    protected static function countryRank($country)
    {
        $country = trim($country);
        return (strcasecmp($country, 'USA') === 0 ? '0' : '1') . mb_strtoupper($country);
    }

    /**
     * Build the nested Country -> State/City -> [{name, code}] structure used by
     * the public packages page cascade. Only active rows, in sort order.
     */
    public static function tree()
    {
        $tree = [];
        $rows = self::where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('state')
            ->get();

        foreach ($rows as $row) {
            $tree[$row->country][$row->state][] = [
                'name' => $row->airport_name,
                'code' => $row->airport_code,
            ];
        }
        uksort($tree, function ($a, $b) {
            return strcmp(self::countryRank($a), self::countryRank($b));
        });
        return $tree;
    }

    /**
     * Active origins grouped by country, for the admin package form dropdowns.
     * Keeps the State / Departure Airport selects in step with this table
     * instead of the hard-coded list they used to carry.
     */
    public static function grouped()
    {
        return self::where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('state')
            ->get()
            ->groupBy('country')
            ->sortBy(function ($rows, $country) {
                return self::countryRank($country);
            });
    }
}
