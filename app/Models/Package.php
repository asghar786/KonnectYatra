<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table = 'package';
    protected $fillable = [
        'name',
        'state',
        'month_year',
        'round_single_price',
        'round_double_price',
        'round_triple_price',
        'round_way_description',
        'one_single_price',
        'one_double_price',
        'one_triple_price',
        'image',
        'one_way_description',
        'sdescription',
        'description',
        'five_star_round_price',
        'five_star_single_price',
        'four_star_round_price',
        'four_star_single_price',
        'four_star_land_price',
        'five_star_land_price',
    ];

    public function package_details(){
        return $this->belongsTo('App\Models\PackageDetails', 'id', 'package_id');
    }

    public function price_details(){
        return $this->belongsTo('App\Models\PriceDetails', 'id', 'package_id');
    }
}
