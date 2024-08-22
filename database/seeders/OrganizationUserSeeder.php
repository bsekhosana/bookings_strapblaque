<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;

class OrganizationUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userOrganizations = [
            'user1@example.com' => 'Alpha Corp', // User email => Organization Name
            'user2@example.com' => 'Beta LLC',
        ];

        foreach ($userOrganizations as $userEmail => $organizationName) {
            $user = User::where('email', $userEmail)->first();
            $organization = Organization::where('name', $organizationName)->first();

            if ($user && $organization) {
                $user->organizations()->attach($organization->id);
            }
        }
    }
}
