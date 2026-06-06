<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Conversion extends Model
{
    public $timestamps = false;

    protected $table = 'conversions';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Record a conversion event, attributing it to the current visitor/session
     * (via the analytics cookies set by TrackVisit middleware).
     */
    public static function log(string $type, Request $request, $referenceId = null): void
    {
        try {
            self::create([
                'type'         => $type,
                'session_id'   => $request->cookie('kv_sid'),
                'visitor_id'   => $request->cookie('kv_vid'),
                'source_type'  => $request->cookie('kv_src'),
                'url'          => substr($request->fullUrl(), 0, 2048),
                'reference_id' => $referenceId,
                'created_at'   => now(),
            ]);
        } catch (\Throwable $e) {
            // Never let analytics logging break a real conversion flow.
            \Log::warning('Conversion log failed: ' . $e->getMessage());
        }
    }
}
