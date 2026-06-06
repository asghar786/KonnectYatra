<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;
    protected $table ='child';
    protected $fillable=[
       
        'child_name',
        'visa_id',
        'child_dob',
    ];
}
