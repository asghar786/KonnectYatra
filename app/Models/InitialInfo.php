<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InitialInfo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "initial_info";
    protected $fillable = [
        'total_persons', 'package_type', 'added_days', 'total_price'
    ];
}
