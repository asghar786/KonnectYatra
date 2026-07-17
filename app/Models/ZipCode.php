<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * US ZIP -> city/state + centroid. Seeded from database/data/us_zip_codes.csv
 * by ZipCodesSeeder; used by the gurdwara ZIP search.
 */
class ZipCode extends Model
{
    protected $table = 'zip_codes';
    protected $primaryKey = 'zip';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];

    /** Miles between two lat/lng pairs (haversine). */
    public static function miles($lat1, $lng1, $lat2, $lng2): float
    {
        $r = 3958.8;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return 2 * $r * asin(min(1, sqrt($a)));
    }
}
