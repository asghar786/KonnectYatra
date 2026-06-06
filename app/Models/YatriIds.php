<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatriIds extends Model
{
    use HasFactory;
    protected $table = 'yatri_ids';
    protected $fillable = [
        'name',
        'father_name',
        'photo',
        'yatri_no',
        'passport_no',
        'passport_country',
        'trip_type',
        'state',
        'type',
        'role',
        'cnic',
        'country',
        'season_id',
    ];
}
