<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $table='locations';
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(LocationImage::class, 'location_id');
    }
}
