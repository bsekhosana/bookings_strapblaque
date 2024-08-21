<?php

namespace App\Helpers;

class Image
{
    /**
     * Get image URL from a disk listed in filesystem config.
     */
    public static function fromDisk(?string $image, string $disk = 'public'): string
    {
        if ($image) {
            if (\Str::startsWith($image, 'http')) {
                return $image;
            } elseif (\Str::startsWith($image, '/')) {
                return asset($image);
            }
        }

        $disk_array = \Config::get('filesystems.disks.'.$disk);

        if (is_array($disk_array)) {
            if ($image) {
                /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
                $storage = \Storage::disk($disk);

                if ($storage->has($image)) {
                    return $storage->url($image);
                }
            }

            if ($placeholder = $disk_array['placeholder'] ?? null) {
                return $placeholder;
            }
        }

        return sprintf('https://via.placeholder.com/400x400.png?text=%s', urlencode(\Config::get('app.name')));
    }

    /**
     * Resize an image.
     * Only pass width OR height to keep ratio.
     */
    public static function resize(?string $filename, string $disk = 'public', ?int $width = null, ?int $height = null): ?string
    {
        if (empty($filename)) {
            return null;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = \Storage::disk($disk);

        if (! $storage->has($filename)) {
            return $filename;
        }

        $path = $storage->path($filename);

        $image = \Intervention\Image\ImageManager::imagick()->read($path);

        if ($width && $height) {
            $image->resize($width, $height);
        } else {
            if ($width && $image->width() > $width) {
                $image->scale(width: $width);
            }
            if ($height && $image->height() > $height) {
                $image->scale(height: $height);
            }
        }

        $image->save($path);

        return $path;
    }

    /**
     * Store a resized image to fit specified size.
     */
    public static function fit(?string $filename, string $disk = 'public', int $width = 512, int $height = 512): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $image_path = \Storage::disk($disk)->path($filename);

        \Intervention\Image\ImageManager::imagick()->read($image_path)->cover($width, $height)->save($image_path);

        return $image_path;
    }

    /**
     * Store a thumbnail and return thumb path.
     */
    public static function createThumbnail(?string $filename, string $disk = 'public', int $width = 512, int $height = 512, string $prefix = 'thumb_'): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $folder = \Storage::disk($disk)->path('');
        $thumb = $prefix.$filename;

        \Intervention\Image\ImageManager::imagick()->read($folder.$filename)->cover($width, $height)->save($folder.$thumb);

        return $thumb;
    }

    /**
     * Get image for specified file extension.
     */
    public static function extension(string $extension, bool $wrap_img_tag = false, ?string $style = null, ?string $class = null): string
    {
        if (\Str::contains($extension, '.')) {
            $extension = \Arr::last(explode('.', $extension));
        }

        $img = sprintf('images/extensions/%s.png', $extension);
        $url = file_exists(public_path($img)) ? asset($img) : asset('images/extensions/unknown.png');
        $tag = '<img src="%s" style="%s" class="%s" alt="%s File" />';

        return $wrap_img_tag ? sprintf($tag, $url, $style, $class, strtoupper($extension)) : $url;
    }
}
