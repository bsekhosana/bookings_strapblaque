<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InteractionDesignFoundation\GeoIP\Services\MaxMindDatabase;

class UpdateGeoIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:geoip-update';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    private MaxMindDatabase $service;

    private string $lock_path;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get and set GeoIP service
        $this->setService();

        // See if update is locked
        if ($this->updateLocked()) {
            return;
        }

        // Create lock file
        $this->createLockFile();

        // Update database
        $this->update();

        // Delete lock file
        $this->deleteLockFile();
    }

    /**
     * @throws \Exception
     */
    private function setService(): void
    {
        $this->service = app('geoip')->getService();
    }

    private function updateLocked(): bool
    {
        $this->lock_path = $this->service->config('lock_file_path');

        if (! $this->lock_path) {
            $this->lock_path = \App::isLocal() ? storage_path('app/geoip_database.lock') : '/var/www/geoip_database.lock';
            $this->warn(sprintf('Lock path in GeoIP config missing, defaulting to "%s".', $this->lock_path));
        }

        if (file_exists($this->lock_path)) {
            $this->error('GeoIP lock file present, update already started by another project, '.file_get_contents($this->lock_path));

            return true;
        }

        return false;
    }

    private function createLockFile(): void
    {
        $this->comment('Locking update...');

        file_put_contents($this->lock_path, sprintf('"%s": %s', config('app.name'), base_path()));
    }

    /**
     * @throws \Exception
     */
    private function update(): void
    {
        $this->comment('Updating...');

        if ($result = $this->service->update()) {
            $this->info($result);
        } else {
            $this->error('Update failed!');
        }
    }

    private function deleteLockFile(): void
    {
        $this->comment('Deleting lock file...');

        unlink($this->lock_path);
    }
}
