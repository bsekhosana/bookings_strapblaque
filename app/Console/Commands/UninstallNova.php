<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class UninstallNova extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall Laravel Nova from this project';

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
        if (confirm('Are you sure you want to uninstall Laravel Nova?')) {
            intro('Removing Laravel Nova...');

            self::delete('app/Models/ActionEvent.php');
            self::delete('app/Nova');
            self::delete('app/Providers/NovaServiceProvider.php');
            self::delete('config/nova.php');
            self::delete('database/migrations/2014_10_13_000000_create_nova_attachments_table.php');
            self::delete('database/migrations/2018_01_01_000000_create_action_events_table.php');
            self::delete('database/migrations/2021_08_25_193039_create_nova_notifications_table.php');
            self::delete('database/migrations/2022_12_19_000000_create_field_attachments_table.php');
            self::delete('lang/vendor/nova');
            self::delete('public/laravel');
            self::delete('public/vendor/nova');
            self::delete('repositories/nova');
            self::delete('repositories/nova-components');
            self::delete('resources/views/vendor/nova');
            self::delete('stubs/nova');

            self::deleteLinesInFiles();
            self::deleteFromComposer();

            spin(function () {
                self::execCmd('composer update --optimize-autoloader --no-interaction --quiet');
            }, 'Updating Composer...');

            $this->info('Laravel Nova removed successfully!');

            try {
                self::delete('app/Console/Commands/UninstallNova.php');
            } catch (\Exception $exception) {
                // Do nothing
            }

            if (confirm('Would you like to create a GIT commit?')) {
                $message = text(
                    label: 'Commit message?',
                    placeholder: 'Removed Laravel Nova',
                    default: 'Removed Laravel Nova',
                    required: true,
                    validate: fn (string $value) => \Str::contains($value, '"') ? 'Commit message can not contain double quotes!' : null
                );

                self::execCmd('git add --all');
                self::execCmd(sprintf('git commit -m "%s"', $message));
            }
        } else {
            warning('Laravel Nova removal cancelled!');
        }
    }

    private static function deleteLinesInFiles(): void
    {
        \File::replaceInFile('        // Laravel Nova'.PHP_EOL, '', base_path('app/Console/Kernel.php'));
        \File::replaceInFile('        $schedule->call(new \Laravel\Nova\Fields\Attachments\PruneStaleAttachments)->daily();'.PHP_EOL.PHP_EOL, '', base_path('app/Console/Kernel.php'));
        \File::replaceInFile('        App\Providers\NovaServiceProvider::class,'.PHP_EOL, '', app()->configPath('app.php'));
    }

    private static function deleteFromComposer(): false|int
    {
        $composer_json = file_get_contents(base_path('composer.json'));
        $composer_array = json_decode($composer_json, true);

        // Remove Nova packages
        $remove_require = [
            'laravel/nova',
            'laravel/nova-theme',
        ];

        foreach ($remove_require as $package) {
            try {
                unset($composer_array['require'][$package]);
            } catch (\Exception $exception) {
                // Do nothing
            }
        }

        // Remove Nova repositories
        $remove_repos = [
            './repositories/nova',
            './repositories/nova-components/NovaTheme',
        ];

        foreach ($composer_array['repositories'] as $index => $repo) {
            if (in_array($repo['url'], $remove_repos)) {
                try {
                    unset($composer_array['repositories'][$index]);
                } catch (\Exception $exception) {
                    // Do nothing
                }
            }
        }

        // Remove Nova commands
        foreach ($composer_array['scripts']['post-update-cmd'] as $index => $cmd) {
            if ($cmd == '@php artisan nova:publish --quiet') {
                try {
                    unset($composer_array['scripts']['post-update-cmd'][$index]);
                } catch (\Exception $exception) {
                    // Do nothing
                }
            }
        }

        $composer_array['scripts']['post-update-cmd'] = array_values($composer_array['scripts']['post-update-cmd']);

        // Update composer.json file
        return file_put_contents(
            base_path('composer.json'),
            json_encode($composer_array, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
    }

    private static function delete(string $path): void
    {
        self::execCmd(sprintf('rm -rf %s', base_path($path)));
    }

    private static function execCmd(string $cmd): void
    {
        \Process::run("$cmd 2>&1");
    }
}
