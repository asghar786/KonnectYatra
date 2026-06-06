<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDetails extends Model
{
    use HasFactory;
    protected $table = 'package_details';
    protected $fillable =[
        'package_id',
        'day_1',
        'plan_1',
        'no_1',
        'day_2',
        'plan_2',
        'no_2',
        'day_3',
        'plan_3',
        'no_3',
        'day_4',
        'plan_4',
        'no_4',
        'day_5',
        'plan_5',
        'no_5',
        'day_6',
        'plan_6',
        'no_6',
        'day_7',
        'plan_7',
        'no_7',
        'day_8',
        'plan_8',
        'no_8'
    ];
}
