<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adult extends Model
{
    use HasFactory;
    public $table="itenary_adult";
    protected $fillable = [
        'pass_id',
        'firstnamea',
        'lastnamea',
        'doba',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\YatriVisa','cat_id');
    }
}
