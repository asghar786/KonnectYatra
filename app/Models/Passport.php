<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;
    protected $table = 'passport';
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'city',
        'address',
        'apt',
        'email',
        'phonenumber',
        'zipcode',
        'dob',
        'state',
        'gender',
        'notes',
        'passportnumber',
        'pdoi',
        'pdoe',
        'issuedate',
        'expiredate',
        'nicpnumber',
        'nicopnumber',
    ];
}
