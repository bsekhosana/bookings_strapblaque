<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
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
                'name' => 'Trial',
                'max_bookings' => 10,
                'has_sms_notifications' => false,
                'has_email_notifications' => true,
                'price' => 0.00,
                'duration_in_days' => 7,
                'status' => 'Active',
            ],
            [
                'name' => 'Basic',
                'max_bookings' => 100,
                'has_sms_notifications' => false,
                'has_email_notifications' => true,
                'price' => 15.00,
                'duration_in_days' => 30,
                'status' => 'Active',
            ],
            [
                'name' => 'Startup',
                'max_bookings' => 500,
                'has_sms_notifications' => true,
                'has_email_notifications' => true,
                'price' => 35.00,
                'duration_in_days' => 30,
                'status' => 'Active',
            ],
            [
                'name' => 'Premium',
                'max_bookings' => 2000,
                'has_sms_notifications' => true,
                'has_email_notifications' => true,
                'price' => 75.00,
                'duration_in_days' => 30,
                'status' => 'Active',
            ],
            [
                'name' => 'Enterprise',
                'max_bookings' => 0, // 0 can indicate unlimited bookings
                'has_sms_notifications' => true,
                'has_email_notifications' => true,
                'price' => 150.00,
                'duration_in_days' => 30,
                'status' => 'Active',
            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\SubscriptionPlan::create($seed);
        }
    }
}
