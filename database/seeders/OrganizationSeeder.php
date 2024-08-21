<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrganizationSetting;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [
                'name' => 'Alpha Corp',
                'email' => 'contact@alphacorp.com',
                'organization_id' => 'alpha123',
                'status' => 'Active',
            ],
            [
                'name' => 'Beta LLC',
                'email' => 'info@betallc.com',
                'organization_id' => 'beta456',
                'status' => 'Active',
            ],
            [
                'name' => 'Gamma Group',
                'email' => 'support@gammagroup.com',
                'organization_id' => 'gamma789',
                'status' => 'Active',
            ],
        ];

        foreach ($seeds as $seed) {
            $organization = \App\Models\Organization::create($seed);

            // Seed settings for each organization
            OrganizationSetting::create([
                'organization_id' => $organization->id,
                'primary_color' => '#0000FF', // Example color
                'secondary_color' => '#00FF00', // Example color
                'time_zone' => 'America/New_York',
                'appointment_duration' => 60,
            ]);
        }
    }
}
