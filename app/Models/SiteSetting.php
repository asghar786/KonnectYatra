<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        try {
            $all = Cache::remember('site_settings_all', 3600, function () {
                return self::pluck('value', 'key')->all();
            });
            return $all[$key] ?? $default;
        } catch (\Throwable $e) {
            return $default; // table not migrated yet
        }
    }

    public static function put(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings_all');
    }
}
