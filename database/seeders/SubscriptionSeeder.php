<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Organization;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example seeding of subscriptions
        $organizations = Organization::all();
        $plans = SubscriptionPlan::all();

        foreach ($organizations as $organization) {
            $plan = $plans->random();

            Subscription::create([
                'organization_id' => $organization->id,
                'subscription_plan_id' => $plan->id,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays($plan->duration_in_days),
                'status' => 'Active',
            ]);
        }
    }
}
