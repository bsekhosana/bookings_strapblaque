<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "retrieved" event.
     */
    public function retrieved(User $user): void
    {
        //
    }

    /**
     * Handle the User "creating" event.
     *
     * @return void
     */
    public function creating(User $user)
    {
        $user->first_name = ucwords($user->first_name);
        $user->last_name = ucwords($user->last_name);
        $user->email = strtolower($user->email);
        $user->avatar ??= $user->gravatar();
        $user->api_token = \Str::random(40);

        if (! \Str::startsWith($user->password, '$2y$1')) {
            $user->password = \Hash::make($user->password);
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "replicating" event.
     */
    public function replicating(User $user): void
    {
        //
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        $user->first_name = ucwords($user->first_name);
        $user->last_name = ucwords($user->last_name);

        if (! \Str::startsWith($user->password, '$2y$1')) {
            $user->password = \Hash::make($user->password);
        }

        if ($user->isDirty('email')) {
            $user->email = strtolower($user->email);
            $user->avatar = \Gravatar::isGravatar($user->avatar) ? $user->gravatar() : ($user->avatar ?? $user->gravatar());
            $user->forceFill(['email_verified_at' => null]);
            $user->sendEmailVerificationNotification();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "saving" event.
     */
    public function saving(User $user): void
    {
        //
    }

    /**
     * Handle the User "saved" event.
     */
    public function saved(User $user): void
    {
        //
    }

    /**
     * Handle the User "trashed" event.
     * Only when SoftDeletes trait is being used.
     */
    public function trashed(User $user): void
    {
        //
    }

    /**
     * Handle the User "restoring" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restoring(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     * Only when SoftDeletes trait is being used.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleting" event.
     */
    public function deleting(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     * Only when SoftDeletes trait is being used.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
