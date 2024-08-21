<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $started = microtime(true);
        \DB::enableQueryLog();
        /* ---------------------------- */

        $this->call([
            SettingSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,

            SubscriptionPlanSeeder::class,
            OrganizationSeeder::class,
            SubscriptionSeeder::class,
        ]);

        /* ---------------------------- */
        \DB::disableQueryLog();
        $ended = microtime(true);

        $this->command->comment(
            sprintf('This seed ran %d queries in %.3f seconds.', count(\DB::getQueryLog()), ($ended - $started))
        );
    }
}
