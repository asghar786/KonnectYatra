<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itenarychild extends Model
{
    use HasFactory;
    public $table="itenary_child";
    protected $fillable = [
        'pass_id',
        'firstnamec',
        'lastnamec',
        'dobc',
    ];
    public function itenary()
    {
        return $this->belongsTo(Itenary::class);
    }
}
