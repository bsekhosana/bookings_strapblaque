<?php

namespace Emotality\CRUD\Commands;

use Emotality\CRUD\Helpers\CrudHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CrudPolicy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:policy {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create policy for a Model';

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
        $stub = CrudHelper::stub('Policy.stub');

        foreach (CrudHelper::$vars as $key => $value) {
            $stub = str_replace(sprintf('{{%s}}', $key), $value, $stub);
        }

        File::put(
            sprintf('%s/%sPolicy.php', CrudHelper::$paths['policies'], self::$model),
            $stub
        );
    }
}
