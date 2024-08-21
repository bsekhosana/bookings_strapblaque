<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Files
{
    /**
     * Save file to storage.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Contracts\Encryption\EncryptException
     */
    public static function save(UploadedFile $file, string $disk, bool $encrypt = false): ?string
    {
        $storage_path = Storage::disk($disk)->path('');

        $filename = sprintf('%s.%s', \Str::random(40), $file->getClientOriginalExtension());

        if (! Storage::exists($storage_path)) {
            Storage::makeDirectory($storage_path);
        }

        if ($encrypt) {
            $saved = Storage::disk($disk)->putFileAs('', \Crypt::encrypt($file->get()), $filename);
        } else {
            $saved = Storage::disk($disk)->putFileAs('', $file->get(), $filename);
        }

        return $saved ? $filename : null;
    }

    /**
     * Get file from storage.
     *
     * @return mixed|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Contracts\Encryption\DecryptException
     */
    public static function get(string $filename, string $disk, bool $decrypt = false): mixed
    {
        $file = Storage::disk($disk)->get($filename);

        if ($decrypt) {
            $file = \Crypt::decrypt($file);
        }

        return $file;
    }
}
