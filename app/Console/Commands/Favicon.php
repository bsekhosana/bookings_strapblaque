<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class Favicon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'favicon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate favicons from app logo';

    /**
     * Image size to work from.
     *
     * @var int
     */
    private $canvas_size = 512;

    /**
     * Fill icon background color.
     *
     * @var string
     */
    private $canvas_bg = null;

    /**
     * Downsize percentage if logo is against borders.
     *
     * @var int
     */
    private $downsize_perc = 70;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (! $this->hasRequiredExtensions()) {
            return;
        }

        $image = select('Select an image from "public/images" to generate favicon from', self::listImages());
        $logo = ImageManager::imagick()->read(public_path(sprintf('images/%s', $image)));

        if (! $this->meetsRequirements($logo)) {
            return;
        }

        intro(sprintf('Generating a favicon from /public/images/%s', $image));

        if ($downsize = confirm('Is your logo full size, against its borders?', true)) {
            $this->downsize_perc = (int) text('What percentage would you like to downsize to?', strval($this->downsize_perc), strval($this->downsize_perc));
        }

        if (confirm('Fill image background color?')) {
            $this->canvas_bg = str_replace('#', '', text('Color HEX:', '#fb09ac'));

            while (! ctype_xdigit($this->canvas_bg)) {
                error('Invalid hex color code');
                $this->canvas_bg = str_replace('#', '', text('Color HEX:', '#fb09ac'));
            }
        }

        if ($logo->height() > $this->canvas_size || $logo->width() > $this->canvas_size) {
            $logo->scale($this->canvas_size, $this->canvas_size);
        }

        // Save favicons before the down-size
        $this->saveFavIconsFrom(clone $logo);

        if ($downsize) {
            $downsize_px = intval($this->canvas_size / 100 * $this->downsize_perc);

            $logo->scale($downsize_px, $downsize_px);

            $tmp = $this->saveTemp($logo);
            $blank = $this->blankImg($this->canvas_size);
            $logo = $blank->place($tmp, 'center');
        }

        $this->saveAppIconsFrom($logo);
    }

    /**
     * @throws \Exception
     */
    private function saveAppIconsFrom(Image $image): void
    {
        $paths = [
            512 => public_path('android-chrome-512x512.png'),
            192 => public_path('android-chrome-192x192.png'),
            180 => public_path('apple-touch-icon.png'),
        ];

        foreach ($paths as $size => $path) {
            $image->scale($size, $size)->save($path);

            $this->comment(sprintf('Saved logo of size %dx%dpx to %s', $size, $size, $path));
        }
    }

    /**
     * @throws \ImagickException
     */
    private function saveFavIconsFrom(Image $image): void
    {
        $paths = [
            96 => public_path('favicon-96x96.png'),
            48 => public_path('favicon-48x48.png'),
            32 => public_path('favicon-32x32.png'),
            16 => public_path('favicon-16x16.png'),
        ];

        foreach ($paths as $size => $path) {
            $image->scale($size, $size)->save($path);

            $this->comment(sprintf('Saved logo of size %dx%dpx to %s', $size, $size, $path));
        }

        $this->saveFaviconFromPaths($paths);
    }

    /**
     * @throws \ImagickException
     */
    private function saveFaviconFromPaths(array $paths): void
    {
        $ico_set = new \Imagick;

        foreach ($paths as $path) {
            $ico_set->addImage(new \Imagick($path));
        }

        $ico_set->writeImages(public_path('favicon.ico'), true);

        $this->comment(sprintf('Saved favicon.ico to %s', public_path('favicon.ico')));
    }

    private function saveTemp(Image $image): Image
    {
        return $image->save(sprintf('/tmp/laravel_%s.png', \Str::random(8)));
    }

    private function blankImg(int $size): Image
    {
        return ImageManager::imagick()->create($size, $size)->fill($this->canvas_bg);
    }

    private function hasRequiredExtensions(): bool
    {
        $ext_required = ['gd', 'imagick'];
        $ext_loaded = get_loaded_extensions();

        foreach ($ext_required as $ext) {
            if (! in_array($ext, $ext_loaded)) {
                $this->error(sprintf('Missing required extension: %s', $ext));
                $this->alert('Please run:');
                $this->comment('brew install pkg-config imagemagick gd');
                $this->comment('pecl install imagick');

                return false;
            }
        }

        return true;
    }

    private function meetsRequirements(Image $image): bool
    {
        if (! $image->width() >= $this->canvas_size || ! $image->height() >= $this->canvas_size) {
            $this->error(sprintf('Image must be at least %dx%dpx', $this->canvas_size, $this->canvas_size));

            return false;
        }

        return true;
    }

    private static function listImages(): array
    {
        $dir = scandir(public_path('images'));

        $images = [];

        foreach ($dir as $file) {
            if (\Str::endsWith($file, ['.png', '.jpg', '.jpeg'])) {
                $images[] = $file;
            }
        }

        return $images;
    }
}
