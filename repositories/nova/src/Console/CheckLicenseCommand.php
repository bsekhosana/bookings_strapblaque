<?php

namespace Laravel\Nova\Console;

use Illuminate\Console\Command;

class CheckLicenseCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nova:check-license';

    /** * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify your Nova license key';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Your license key is valid and correctly configured! Thank you for being a Nova customer. 🚀');

        return 0;
    }
}
