<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatariPackage extends Model
{
    use HasFactory;
    protected $table = 'yatari_packages';
    protected $guarded = [];
}
