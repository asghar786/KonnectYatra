<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GurdwaraLead extends Model
{
    use HasFactory;

    protected $table = 'gurdwara_leads';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'city',
        'state',
        'zip_code',
        'near_gurdwara',
        'heard_from',
    ];
}
