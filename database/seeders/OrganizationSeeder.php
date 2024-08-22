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
                'phone' => '+238 348 5587',
                'address' => '20 Real beverly drive, San Fran',
                'status' => 'Active',
            ],
            [
                'name' => 'Beta LLC',
                'email' => 'info@betallc.com',
                'phone' => '+009 6578 8876',
                'address' => '16 West Street, United States',
                'status' => 'Active',
            ],
            [
                'name' => 'Gamma Group',
                'email' => 'support@gammagroup.com',
                'phone' => '546 78554 332',
                'address' => '101 Rodeo Drive, Miami',
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
