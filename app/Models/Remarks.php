<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remarks extends Model
{
    use HasFactory;
    public $table = "remarks";
    protected $fillable = [
        'user_id',
        'remarks'
    ];
}
