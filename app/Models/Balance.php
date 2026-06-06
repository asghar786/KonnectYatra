<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    protected $table = 'balance';
    protected $guarded = [];


    public function visa()
    {
        return $this->belongsTo('App\Models\YatriVisa', 'visa_id');
    }
}
