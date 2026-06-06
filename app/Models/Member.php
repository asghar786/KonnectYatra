<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $table ='member';
    protected $fillable=[
        'TM_name',
        'visa_id',
        'TM_dob',
        'TM_passport',
        'TM_address',
    ];
}
