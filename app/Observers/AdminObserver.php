<?php

namespace App\Observers;

use App\Models\Admin;

class AdminObserver
{
    /**
     * Handle the Admin "retrieved" event.
     */
    public function retrieved(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "creating" event.
     */
    public function creating(Admin $admin): void
    {
        $admin->first_name = ucwords($admin->first_name);
        $admin->last_name = ucwords($admin->last_name);
        $admin->email = strtolower($admin->email);
        $admin->avatar ??= $admin->gravatar();
        $admin->api_token = \Str::random(40);

        if (! \Str::startsWith($admin->password, '$2y$1')) {
            $admin->password = \Hash::make($admin->password);
        }
    }

    /**
     * Handle the Admin "created" event.
     */
    public function created(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "replicating" event.
     */
    public function replicating(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "updating" event.
     */
    public function updating(Admin $admin): void
    {
        $admin->first_name = ucwords($admin->first_name);
        $admin->last_name = ucwords($admin->last_name);

        if (! \Str::startsWith($admin->password, '$2y$1')) {
            $admin->password = \Hash::make($admin->password);
        }

        if ($admin->isDirty('email')) {
            $admin->email = strtolower($admin->email);
            $admin->avatar = \Gravatar::isGravatar($admin->avatar) ? $admin->gravatar() : ($admin->avatar ?? $admin->gravatar());
            $admin->forceFill(['email_verified_at' => null]);
            $admin->sendEmailVerificationNotification();
        }
    }

    /**
     * Handle the Admin "updated" event.
     */
    public function updated(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "saving" event.
     */
    public function saving(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "saved" event.
     */
    public function saved(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "deleting" event.
     */
    public function deleting(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(Admin $admin): void
    {
        //
    }
}
