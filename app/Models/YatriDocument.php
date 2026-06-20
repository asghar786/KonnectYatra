<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatriDocument extends Model
{
    use HasFactory;
    protected $table = 'yatri_documents';
    protected $guarded = [];

    public function yatri_visa()
    {
        return $this->belongsTo('App\Models\YatriVisa', 'yatri_visa_id');
    }
}
