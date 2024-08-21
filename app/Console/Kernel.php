<?php

namespace App\Console;

use App\Jobs\SendBookingReminders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Laravel Framework
        $schedule->command('cache:prune-stale-tags')->hourly();

        // Laravel Horizon
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        // Laravel Nova
        $schedule->call(new \Laravel\Nova\Fields\Attachments\PruneStaleAttachments)->daily();

        // Project Cronjobs
        $schedule->command('cronjob:housekeeping')->dailyAt('03:33');
        $schedule->command('cronjob:geoip-update')->weeklyOn(Schedule::SUNDAY, '03:03');

        $schedule->job(new SendBookingReminders)->dailyAt('08:00'); // Adjust the time as needed
        // Custom
        // $schedule->command('example:command')->dailyAt('03:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
