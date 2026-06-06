<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infant extends Model
{
    use HasFactory;
    public $table="itenary_infant";
    protected $fillable = [
        'pass_id',
        'firstnamei',
        'lastnamei',
        'dobi',
    ];
    public function itenary()
    {
        return $this->belongsTo(Itenary::class);
    }
}
