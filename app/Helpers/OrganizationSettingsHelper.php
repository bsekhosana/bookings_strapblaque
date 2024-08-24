<?php

namespace App\Helpers;

use App\Models\OrganizationSetting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class OrganizationSettingsHelper
{
    /**
     * Get organization settings based on the user's role.
     *
     */
    public static function getOrganizationSettings()
    {
        $adminUser = Auth::guard('admin')->user();

        if ($adminUser->isSuperAdmin()) {
            // Return all organization settings for super admin
            return OrganizationSetting::latest('id')->paginate();
        }

        // Return organization settings for specific organization
        return OrganizationSetting::where('organization_id', $adminUser->organization_id)
                                   ->latest('id')
                                   ->paginate();
    }
}
