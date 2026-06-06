<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    use HasFactory;
    protected $table = 'receivables';
    protected $fillable =[
        'amount',
        'account_head_id',
    ];
    public function account_head()
    {
        return $this->belongsTo(AccountHead::class);
    }
}
