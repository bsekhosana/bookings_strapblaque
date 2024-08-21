<?php

namespace Emotality\CRUD\Commands;

use Emotality\CRUD\Helpers\CrudHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CrudViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:views {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD views for a Model';

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
        File::ensureDirectoryExists(sprintf('%s/%s', CrudHelper::$paths['views'], CrudHelper::$vars[CrudHelper::PLURAL_VAR]));

        $cruds = ['create', 'edit', 'index', 'show'];

        foreach ($cruds as $crud) {
            $stub = CrudHelper::stub(sprintf('view-%s.stub', $crud));

            foreach (CrudHelper::$vars as $key => $value) {
                $stub = str_replace(sprintf('{{%s}}', $key), $value, $stub);
            }

            File::put(
                sprintf('%s/%s/%s.blade.php', CrudHelper::$paths['views'], CrudHelper::$vars[CrudHelper::PLURAL_VAR], $crud),
                $stub
            );
        }
    }
}
