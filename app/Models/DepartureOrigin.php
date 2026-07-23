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
     * Build the nested Country -> State/City -> [{name, code}] structure used by
     * the public packages page cascade. Only active rows, in sort order.
     */
    public static function tree()
    {
        $tree = [];
        $rows = self::where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('country')
            ->orderBy('state')
            ->get();

        foreach ($rows as $row) {
            $tree[$row->country][$row->state][] = [
                'name' => $row->airport_name,
                'code' => $row->airport_code,
            ];
        }
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
            ->orderBy('country')
            ->orderBy('state')
            ->get()
            ->groupBy('country');
    }
}
