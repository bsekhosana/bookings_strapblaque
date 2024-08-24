<?php

namespace App\Helpers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationHelper
{
    /**
     * Get the organization associated with the logged-in user.
     *
     * @param Request $request
     * @param string $driver
     * @return Organization|null
     */
    public static function userOrganization(Request $request, string $driver = 'session'): ?Organization
    {
        // Get the authenticated user
        $user = $request->user($driver);

        if ($user) {
            // Check if the user is an admin
            if ($user->isAdmin()) {
                // Admins might be related to organizations through the 'organization_admin' table
                return $user->organizations()->first();
            }

            // Check if the user is a regular user
            if ($user->isUser()) {
                // Regular users might be related to organizations through the 'organization_user' table
                return $user->organizations()->first();
            }
        }

        return null;
    }
}
