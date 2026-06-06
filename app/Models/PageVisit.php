<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    public $timestamps = false; // only created_at, set manually on insert

    protected $table = 'visits';
    protected $guarded = [];

    protected $casts = [
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
    ];
}
