<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itenary extends Model
{
    use HasFactory;
    public $table="itenary";
    protected $fillable = [
        'category',
        'from',
        'to',
        'depart',
        'return',
        'class',
        'name',
        'email',
        'contact',
        'passengers',
    ];

    public function getitenaryadult()
    {
        $this->hasMany(Adult::class, 'pass_id', 'id');
    }
    public function getitenarychild()
    {
        $this->hasMany(Itenarychild::class, 'pass_id', 'id');
    }
    public function getitenaryinfant()
    {
        return $this->hasMany(Infant::class, 'pass_id', 'id');
    }
}
