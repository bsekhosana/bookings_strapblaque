<?php

namespace Emotality\CRUD\Commands;

use Emotality\CRUD\Helpers\CrudHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\warning;

class CrudObserver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:observer {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create observer for a Model';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = false;

    protected static string $model;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        self::$model = CrudHelper::askModel(
            $this->argument('model')
        );

        CrudHelper::setup(self::$model);

        self::populate();
    }

    private static function populate(): void
    {
        $stub = CrudHelper::stub('Observer.stub');

        foreach (CrudHelper::$vars as $key => $value) {
            $stub = str_replace(sprintf('{{%s}}', $key), $value, $stub);
        }

        $saved = File::put(
            sprintf('%s/%sObserver.php', CrudHelper::$paths['observers'], self::$model),
            $stub
        );

        if ($saved) {
            self::addToEventProvider();
        }
    }

    private static function addToEventProvider(): void
    {
        $provider = File::get(app_path('Providers/EventServiceProvider.php'));
        $provider_lines = explode(PHP_EOL, $provider);

        if (Str::contains($provider, sprintf('%sObserver::class', self::$model))) {
            return;
        }

        $insert = sprintf('        \App\Models\%s::observe(\App\Observers\%sObserver::class);', self::$model, self::$model);

        if (($index = Arr::containIndex(array_reverse($provider_lines), '::observe(')) !== false) {
            $reversed = array_reverse($provider_lines);
            array_splice($reversed, $index, 0, $insert);
            $provider_lines = array_reverse($reversed);
        } elseif (($index = Arr::containIndex($provider_lines, '// Observers')) !== false) {
            $provider_lines = array_splice($provider_lines, $index + 1, 0, $insert);
        } elseif (($index = Arr::containIndex($provider_lines, 'public function boot()')) !== false) {
            $provider_lines = array_splice($provider_lines, $index + 2, 0, $insert);
        } else {
            warning('Failed to insert to Providers/EventServiceProvider.php :'.$insert);
        }

        File::put(
            app_path('Providers/EventServiceProvider.php'),
            implode(PHP_EOL, $provider_lines)
        );
    }
}
