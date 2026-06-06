<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDetails extends Model
{
    use HasFactory;
    protected $table = 'price_details';
    protected $fillable =[
        'package_id',
        'single_ticket',
        'double_ticket',
        'triple_ticket',
        'single_isb_to_lhr',
        'double_isb_to_lhr',
        'triple_isb_to_lhr',
        'single_tolls',
        'double_tolls',
        'triple_tolls',
        'single_isb_hotel',
        'double_isb_hotel',
        'triple_isb_hotel',
        'single_transport',
        'double_transport',
        'triple_transport',
        'single_lhr_hotel',
        'double_lhr_hotel',
        'triple_lhr_hotel',
        'single_food',
        'double_food',
        'triple_food',
        'single_visa',
        'double_visa',
        'triple_visa',
        'single_misc',
        'double_misc',
        'triple_misc',
        'single_margin',
        'double_margin',
        'triple_margin',
        'single_local_tour',
        'double_local_tour',
        'triple_local_tour',
        'single_crew',
        'double_crew',
        'triple_crew',
        'single_kartarpur',
        'double_kartarpur',
        'triple_kartarpur',
        'single_nanakana',
        'double_nanakana',
        'triple_nanakana'
    ];
}
