<?php

namespace App\Observers;

use App\Models\Setting;

class SettingObserver
{
    /**
     * Handle the Setting "retrieved" event.
     *
     * @return void
     */
    public function retrieved(Setting $setting)
    {
        //
    }

    /**
     * Handle the Setting "creating" event.
     */
    public function creating(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        // Cache newly created Setting
        \Settings::cache($setting->key);
    }

    /**
     * Handle the Setting "replicating" event.
     */
    public function replicating(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "updating" event.
     */
    public function updating(Setting $setting): void
    {
        if ($setting->isClean('editable') && ! $setting->editable) {
            abort(403, 'Setting is not editable!');
        }
    }

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        // Cache the updated Setting
        \Settings::cache($setting->key);

        // Flush cached items that depend on setting values
        \Cache::tags(['settings'])->flush();
    }

    /**
     * Handle the Setting "saving" event.
     */
    public function saving(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "saved" event.
     */
    public function saved(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Setting $setting): void
    {
        abort(403, 'Setting cannot be trashed!');
    }

    /**
     * Handle the Setting "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "deleting" event.
     */
    public function deleting(Setting $setting): void
    {
        abort(403, 'Setting cannot be deleted!');
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Setting $setting): void
    {
        abort(403, 'Setting cannot be deleted!');
    }
}
