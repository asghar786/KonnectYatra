<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YatriVisa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'yatri_visas';
    protected $guarded = [];

    public function package(){
        return $this->belongsTo('App\Models\Package', 'package_id');
    }

    public function gurdwara(){
        return $this->belongsTo('App\Models\Gurdwara', 'gurdwara_id');
    }

    public function hotel(){
        return $this->belongsTo('App\Models\Hotels', 'hotel_id');
    }

    public function bus(){
        return $this->belongsTo('App\Models\Bus', 'bus_id');
    }

    public function documents(){
        return $this->hasMany('App\Models\YatriDocument', 'yatri_visa_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\YatriComment', 'yatri_visa_id')->latest();
    }
}
