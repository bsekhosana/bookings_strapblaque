<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\select;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy {environment? : The environment where you want to deploy to, staging or production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application to a staging/production server';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $envs = ['staging', 'production'];

        $env = $this->argument('environment') ?? select('Please select the environment you want to deploy to:', $envs, $envs[0]);

        if (! in_array(strtolower($env), $envs)) {
            alert(sprintf('Invalid environment "%s". Allowed: %s', $env, implode(', ', $envs)));

            return;
        }

        if (! self::deployedBefore($env)) {
            if (confirm('You haven\'t deployed to this server before, would you like to setup this server for deployment?', true)) {
                $output = system(sprintf('php vendor/bin/envoy run init_%s --env=%s', $env, $env));

                if (! $output || ($output && \Str::contains($output, 'This task did not complete successfully'))) {
                    $this->newLine();
                    alert('Deployment failed.');
                } else {
                    self::setDeployedBefore($env);
                }

                return;
            }

            self::setDeployedBefore($env);
        }

        intro(sprintf('Deploying to %s server(s)...', $env));

        usleep(1500);

        system(sprintf('php vendor/bin/envoy run deploy_%s --env=%s', $env, $env));
    }

    /**
     * Check if you have deployed to this env before.
     */
    private static function deployedBefore(string $env): bool
    {
        if (! file_exists($deployed_file = base_path('.deployed'))) {
            return false;
        }

        $json = file_get_contents($deployed_file);
        $json = json_decode($json, true);

        if (isset($json[$env])) {
            return true;
        }

        return false;
    }

    /**
     * Save that you have deployed to this env before.
     */
    private static function setDeployedBefore(string $env): void
    {
        if (file_exists($deployed_file = base_path('.deployed'))) {
            $json = file_get_contents($deployed_file);
            $json = json_decode($json, true);
            $json[$env] = true;
            file_put_contents($deployed_file, json_encode((object) $json));
        } else {
            exec(sprintf('touch %s', $deployed_file));
            file_put_contents($deployed_file, json_encode((object) [$env => true]));
        }
    }
}
