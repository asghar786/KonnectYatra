<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatriCompanion extends Model
{
    use HasFactory;

    protected $table = 'yatri_companions';

    protected $fillable = [
        'yatri_visa_id', 'relation', 'full_name',
        'birth_country', 'nationality', 'passport_no', 'passport_file',
    ];

    public function yatriVisa()
    {
        return $this->belongsTo('App\Models\YatriVisa', 'yatri_visa_id');
    }
}
