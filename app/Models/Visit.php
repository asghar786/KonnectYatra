<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $table='visit';
    protected $fillable = [
        'visit_date',
        'visa_id',
        'visit_designation',
        'visited_purpose',
        'visit_duration',
    ];
}
