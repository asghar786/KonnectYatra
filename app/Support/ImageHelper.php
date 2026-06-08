<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

/**
 * Centralised image uploader: resizes to a desired size and converts to WebP
 * (HD quality) using GD. Falls back to storing the original file unchanged if
 * the image cannot be processed, so uploads never fail.
 *
 * Options:
 *   width   (int|null)  target width  in px
 *   height  (int|null)  target height in px
 *   mode    'cover'|'max'  cover = exact w×h (centre-crop); max = fit within
 *                           w×h keeping aspect ratio, never upscaling.
 *   quality (int)       WebP quality 0-100 (default 90 = HD)
 *
 * Returns the saved file name (e.g. "abc123_photo.webp").
 */
class ImageHelper
{
    public static function save(UploadedFile $file, string $dir, array $opts = []): string
    {
        $width   = $opts['width']   ?? null;
        $height  = $opts['height']  ?? null;
        $mode    = $opts['mode']    ?? 'max';
        $quality = $opts['quality'] ?? 90;

        $destDir = public_path($dir);
        if (!is_dir($destDir)) {
            @mkdir($destDir, 0775, true);
        }

        $base = uniqid() . '_' . preg_replace(
            '/[^A-Za-z0-9_-]+/', '-',
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        );

        try {
            if (!function_exists('imagewebp')) {
                throw new \RuntimeException('WebP not supported');
            }
            $src = self::createFromFile($file->getPathname());
            if (!$src) {
                throw new \RuntimeException('Unsupported image');
            }
            $dst = self::resize($src, $width, $height, $mode);
            imagedestroy($src);

            $fileName = $base . '.webp';
            imagewebp($dst, $destDir . DIRECTORY_SEPARATOR . $fileName, (int) $quality);
            imagedestroy($dst);

            return $fileName;
        } catch (\Throwable $e) {
            // Fallback: keep the original file as-is.
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $fileName = $base . '.' . $ext;
            $file->move($destDir, $fileName);
            return $fileName;
        }
    }

    private static function createFromFile(string $path)
    {
        $info = @getimagesize($path);
        if (!$info) {
            return null;
        }
        switch ($info[2]) {
            case IMAGETYPE_JPEG: $img = @imagecreatefromjpeg($path); break;
            case IMAGETYPE_PNG:  $img = @imagecreatefrompng($path); break;
            case IMAGETYPE_GIF:  $img = @imagecreatefromgif($path); break;
            case IMAGETYPE_WEBP: $img = @imagecreatefromwebp($path); break;
            case IMAGETYPE_BMP:  $img = function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($path) : null; break;
            default: return null;
        }
        return $img ?: null;
    }

    private static function resize($src, ?int $width, ?int $height, string $mode)
    {
        $sw = imagesx($src);
        $sh = imagesy($src);

        if ($mode === 'cover' && $width && $height) {
            $scale = max($width / $sw, $height / $sh);
            $nw = (int) ceil($sw * $scale);
            $nh = (int) ceil($sh * $scale);
            $scaled = self::blank($nw, $nh);
            imagecopyresampled($scaled, $src, 0, 0, 0, 0, $nw, $nh, $sw, $sh);

            $dst = self::blank($width, $height);
            $x = (int) (($nw - $width) / 2);
            $y = (int) (($nh - $height) / 2);
            imagecopy($dst, $scaled, 0, 0, $x, $y, $width, $height);
            imagedestroy($scaled);
            return $dst;
        }

        // 'max' — fit within the box, keep aspect, never upscale.
        $maxW = $width ?: $sw;
        $maxH = $height ?: $sh;
        $scale = min($maxW / $sw, $maxH / $sh, 1);
        $nw = max(1, (int) round($sw * $scale));
        $nh = max(1, (int) round($sh * $scale));
        $dst = self::blank($nw, $nh);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $sw, $sh);
        return $dst;
    }

    private static function blank(int $w, int $h)
    {
        $img = imagecreatetruecolor($w, $h);
        imagealphablending($img, false);
        imagesavealpha($img, true);
        $transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefilledrectangle($img, 0, 0, $w, $h, $transparent);
        imagealphablending($img, true);
        return $img;
    }
}
