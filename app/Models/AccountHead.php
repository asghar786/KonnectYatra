<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    use HasFactory;
    public $table="account_heads";
    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    public function payable()
    {
        $this->hasMany(Payable::class, 'account_head_id', 'id');
    }
}
