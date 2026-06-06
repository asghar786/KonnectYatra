<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multicity extends Model
{

    use HasFactory;
    public $table="multicities";
    protected $fillable = [
        'pass_id',
        'from',
        'to',
        'depart',
        
    ];
}
