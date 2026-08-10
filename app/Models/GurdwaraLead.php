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
        'middle_name',
        'last_name',
        'father_name',
        'phone',
        'email',
        'city',
        'state',
        'zip_code',
        'yatri_count',
        'near_gurdwara',
        'heard_from',
    ];

    /**
     * First / middle / last joined, skipping the parts that are blank.
     */
    public function getFullNameAttribute()
    {
        return implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ]));
    }
}
