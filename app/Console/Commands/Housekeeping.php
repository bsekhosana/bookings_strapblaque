<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Housekeeping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:housekeeping';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $month_ago = now()->subMonth()->toDateString();

        \DB::table('password_reset_tokens')
            ->whereDate('created_at', '<', $month_ago)
            ->delete();

        \DB::table('failed_jobs')
            ->whereDate('failed_at', '<', $month_ago)
            ->delete();

        // Feel free to add more :)
    }
}
