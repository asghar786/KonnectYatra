<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $table = 'hero_slides';

    protected $fillable = [
        'eyebrow', 'title', 'description', 'image',
        'btn1_text', 'btn1_link', 'btn2_text', 'btn2_link',
        'sort_order', 'is_active',
    ];
}
