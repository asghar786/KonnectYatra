<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    protected $table = 'season';
    protected $fillable = [
        'name',
        'status'
    ];

    // The season the admin works on when none is picked in the season box: the
    // one marked Active, else the newest. It used to be just the newest, so adding
    // next trip's season early (9 "Special Yatra Group in March", 2026-11-07) made
    // every admin list open on that empty season while Gurpurab was still running.
    public static function current()
    {
        return static::where('status', '1')->first() ?: static::orderBy('id', 'DESC')->first();
    }
}
