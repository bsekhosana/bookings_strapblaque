<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthedUser;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(AuthedUser $authed_user): bool
    {
        return $authed_user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(AuthedUser $authed_user, Admin $admin): bool
    {
        return $authed_user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(AuthedUser $authed_user): bool
    {
        return $authed_user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthedUser $authed_user, Admin $admin): bool
    {
        return $authed_user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthedUser $authed_user, Admin $admin): bool
    {
        return $authed_user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(AuthedUser $authed_user, Admin $admin): bool
    {
        return $authed_user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(AuthedUser $authed_user, Admin $admin): bool
    {
        return $authed_user->isSuperAdmin();
    }
}
