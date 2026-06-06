<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'featured_image',
        'author',
        'published_date',
        'status',
    ];

    protected static function booted()
    {
        // Auto-generate a unique slug from the title when one isn't provided.
        static::saving(function (Blog $blog) {
            if (empty($blog->slug) && !empty($blog->title)) {
                $base = Str::slug($blog->title);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $blog->slug = $slug;
            }
        });
    }
}
