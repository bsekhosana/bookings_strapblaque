<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Organization;

class OrganizationAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminOrganizations = [
            'admin@example.com' => 'Alpha Corp', // Admin email => Organization Name
            'admin2@example.com' => 'Beta LLC',
        ];

        foreach ($adminOrganizations as $adminEmail => $organizationName) {
            $admin = Admin::where('email', $adminEmail)->first();
            $organization = Organization::where('name', $organizationName)->first();

            if ($admin && $organization) {
                $admin->organizations()->attach($organization->id);
            }
        }
    }
}
