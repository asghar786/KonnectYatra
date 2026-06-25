<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatriComment extends Model
{
    use HasFactory;

    protected $table = 'yatri_comments';
    protected $fillable = ['yatri_visa_id', 'comment', 'author'];

    public function visa()
    {
        return $this->belongsTo('App\Models\YatriVisa', 'yatri_visa_id');
    }
}
