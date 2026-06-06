<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    use HasFactory;

    protected $table = 'page_banners';
    protected $fillable = ['page_key', 'label', 'image'];

    /**
     * Banner URL for a page key, falling back to $default when no image is set.
     * Caches all banners in one query per request.
     */
    public static function url($key, $default = null)
    {
        static $cache = null;
        if ($cache === null) {
            try {
                $cache = self::pluck('image', 'page_key')->all();
            } catch (\Throwable $e) {
                $cache = []; // table not migrated yet — use defaults
            }
        }
        return !empty($cache[$key]) ? asset('banners/' . $cache[$key]) : $default;
    }
}
