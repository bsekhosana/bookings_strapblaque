<?php

namespace Emotality\CRUD\Commands;

use Emotality\CRUD\Helpers\CrudHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CrudRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:request {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create request for a Model';

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
        $stub = CrudHelper::stub('Request.stub');

        foreach (CrudHelper::$vars as $key => $value) {
            $stub = str_replace(sprintf('{{%s}}', $key), $value, $stub);
        }

        $rules = CrudHelper::modelRules(self::$model);

        $stub = str_replace('{{rules}}', CrudHelper::rulesString($rules), $stub);

        File::put(
            sprintf('%s/%sRequest.php', CrudHelper::$paths['requests'], self::$model),
            $stub
        );
    }
}
