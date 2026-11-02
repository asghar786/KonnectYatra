<?php

namespace App\Support;

use App\Models\QuickYatri;
use App\Models\SiteSetting;

/**
 * The travelling list — "List of Yatris Traveling to Pakistan…" — that the
 * office sends out as PDF or Excel, arranged from the Quick Yatri applications.
 *
 * One JSON value in `site_settings` (`qy_yatri_list`), so it needed no migration:
 *
 *   { "title": "...", "rows": [ { "id": 12, "on": true }, ... ] }
 *
 * `rows` is the printed order and `on` is the tick: an unticked yatri keeps
 * their place on screen but is left out of both downloads, and the Yatri #
 * counts the ticked rows only.
 */
class YatriList
{
    const KEY = 'qy_yatri_list';

    const DEFAULT_TITLE = 'LIST OF YATRIS TRAVELING TO PAKISTAN TO ATTEND GURPURAB 2026';

    /** Longest title the PDF's two-line title box was laid out for. */
    const TITLE_MAX = 120;

    public static function stored(): ?array
    {
        $raw  = SiteSetting::get(self::KEY);
        $data = $raw ? json_decode($raw, true) : null;

        return is_array($data) ? $data : null;
    }

    public static function put(array $data): void
    {
        SiteSetting::put(self::KEY, json_encode($data));
    }

    /**
     * The title and every application, each as ['yatri' => QuickYatri, 'on' => bool],
     * in saved order. Applications keyed in since the last save join at the foot,
     * oldest first and ticked — a new yatri is on the list until someone takes
     * them off. A deleted application simply drops out.
     */
    public static function load(): array
    {
        $data  = self::stored() ?? [];
        $byId  = QuickYatri::orderBy('created_at')->orderBy('id')->get()->keyBy('id');
        $rows  = [];

        foreach ((array) ($data['rows'] ?? []) as $r) {
            $id = (int) ($r['id'] ?? 0);
            if ($byId->has($id)) {
                $rows[] = ['yatri' => $byId->pull($id), 'on' => !empty($r['on']), 'new' => false];
            }
        }
        // `new` flags a late arrival on the page; before the first save every
        // row would be "new", which says nothing.
        foreach ($byId as $yatri) {
            $rows[] = ['yatri' => $yatri, 'on' => true, 'new' => $data !== []];
        }

        $title = trim((string) ($data['title'] ?? ''));

        return [
            'title' => $title !== '' ? $title : self::DEFAULT_TITLE,
            'rows'  => $rows,
            'saved' => $data !== [],
        ];
    }

    /** Only the ticked rows, in order — what the PDF and the spreadsheet print. */
    public static function ticked(array $list): array
    {
        return array_values(array_map(function ($r) {
            return $r['yatri'];
        }, array_filter($list['rows'], function ($r) {
            return $r['on'];
        })));
    }

    /** "American" / "Indian" — the office sheet's wording, not the stored code. */
    public static function nationality(?string $raw): string
    {
        $code = HotelCheckin::nationality($raw);
        $words = ['US' => 'American', 'IND' => 'Indian', 'CAN' => 'Canadian', 'UK' => 'British'];

        return $words[$code] ?? ucwords(strtolower($code));
    }
}
