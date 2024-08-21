<?php

namespace App\Policies;

use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthedUser;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AuthedUser $authed_user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AuthedUser $authed_user, Setting $setting): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AuthedUser $authed_user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthedUser $authed_user, Setting $setting): bool
    {
        return $authed_user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthedUser $authed_user, Setting $setting): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AuthedUser $authed_user, Setting $setting): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AuthedUser $authed_user, Setting $setting): bool
    {
        return false;
    }
}
