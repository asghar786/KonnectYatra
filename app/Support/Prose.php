<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

/**
 * Renders admin-entered prose as structured HTML.
 *
 * Location and Gurdwara descriptions live in a single text column, which meant
 * a whole page of content rendered as one undifferentiated block — no headings
 * for a reader to scan or a crawler to parse. Rather than add columns for every
 * section (and a prod migration with them), the text itself carries a minimal,
 * forgiving convention:
 *
 *   "## Heading"   -> an <h2>
 *   "- item"       -> a list item, consecutive ones grouped into a <ul>
 *   anything else  -> a paragraph
 *
 * Everything is escaped first, so text typed in the admin can never inject
 * markup. This is deliberately not Markdown: no links, emphasis or raw HTML,
 * because the field is edited by non-technical staff and a half-typed tag
 * should show up as text rather than break the page.
 */
class Prose
{
    public static function render(?string $text): HtmlString
    {
        $text = trim((string) $text);

        if ($text === '') {
            return new HtmlString('');
        }

        $blocks = preg_split('/\R{2,}|\R/u', $text) ?: [];
        $html   = '';
        $list   = [];

        $flushList = function () use (&$list, &$html) {
            if ($list) {
                $html .= '<ul class="ld2-list">' . implode('', $list) . '</ul>';
                $list = [];
            }
        };

        foreach ($blocks as $block) {
            $line = trim($block);

            if ($line === '') {
                continue;
            }

            if (str_starts_with($line, '## ')) {
                $flushList();
                $html .= '<h2 class="ld2-h2">' . e(trim(substr($line, 3))) . '</h2>';
                continue;
            }

            if (str_starts_with($line, '- ')) {
                $list[] = '<li>' . e(trim(substr($line, 2))) . '</li>';
                continue;
            }

            $flushList();
            $html .= '<p>' . e($line) . '</p>';
        }

        $flushList();

        return new HtmlString($html);
    }

    /**
     * The prose with its structural markers removed — for meta descriptions and
     * schema, where "## Getting there" would read as noise.
     */
    public static function plain(?string $text): string
    {
        $text = preg_replace('/^(##|-)\s+/mu', '', (string) $text);

        return trim(preg_replace('/\s+/u', ' ', (string) $text));
    }

    /**
     * An opening summary for a meta description, cut on a boundary a reader
     * would recognise.
     *
     * Truncating on a raw character count produced "…in the village then c",
     * which reads as broken software in a search result. Prefer whole sentences
     * up to $max; if even the first sentence is too long, fall back to the last
     * whole word. Aims at the 130–150 character range search results allow,
     * accepting a shorter result when the first sentence ends early — a
     * complete short sentence beats a padded truncated one.
     */
    public static function summary(?string $text, int $max = 152): string
    {
        $plain = self::plain($text);

        if ($plain === '' || mb_strlen($plain) <= $max) {
            return $plain;
        }

        // Sentence ends, in order, while they still fit.
        $out = '';
        foreach (preg_split('/(?<=[.!?])\s+/u', $plain) as $sentence) {
            $candidate = $out === '' ? $sentence : $out . ' ' . $sentence;

            if (mb_strlen($candidate) > $max) {
                break;
            }

            $out = $candidate;
        }

        if ($out !== '') {
            return $out;
        }

        // The first sentence alone overruns — cut back to a whole word.
        $cut = mb_substr($plain, 0, $max);
        $sp  = mb_strrpos($cut, ' ');

        return rtrim($sp === false ? $cut : mb_substr($cut, 0, $sp), " ,;:—-") . '…';
    }
}
