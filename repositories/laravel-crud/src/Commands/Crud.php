<?php

namespace Emotality\CRUD\Commands;

use Emotality\CRUD\Helpers\CrudHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\error;
use function Laravel\Prompts\multiselect;

class Crud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud {models?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD resources for model(s)';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $models = self::askModels(
            $this->argument('models')
        );

        $resources = multiselect(
            label: 'Which resources would you like to generate?',
            options: ['Views', 'Controller', 'Request', 'Observer', 'Policy'],
            default: ['Views', 'Controller', 'Request', 'Observer'],
            scroll: 10,
            required: true,
            hint: 'Use the space bar to select options.'
        );

        foreach ($models as $model) {
            CrudHelper::setup($model, true);

            if (in_array('Views', $resources)) {
                $this->call('crud:views', [
                    'model' => $model,
                ]);
                // TODO: Add input fields
                // <x-inputs.text label="Xxx" key="xxx" :value="old('xxx')"/>
            }

            if (in_array('Policy', $resources)) {
                $this->call('crud:policy', [
                    'model' => $model,
                ]);
            }

            if (in_array('Request', $resources)) {
                $this->call('crud:request', [
                    'model' => $model,
                ]);
            }

            if (in_array('Controller', $resources)) {
                $this->call('crud:controller', [
                    'model' => $model,
                ]);
            }

            if (in_array('Observer', $resources)) {
                $this->call('crud:observer', [
                    'model' => $model,
                ]);
            }
        }
    }

    private static function askModels(?string $artisan_models = null): array
    {
        if ($artisan_models) {
            $models = explode(',', $artisan_models);
        } else {
            $model_files = File::files(app_path('Models'));

            foreach ($model_files as $model) {
                $options[] = $model->getFilenameWithoutExtension();
            }

            if (empty($options ?? [])) {
                error('No models found!');
                exit(1);
            }

            if (($key = array_search('Setting', $options)) !== false) {
                unset($options[$key]);
            }

            $models = multiselect(
                label: 'For which models?',
                options: collect($options)->values(),
                scroll: 15,
                required: true,
                hint: 'Use the space bar to select options.'
            );
        }

        return $models;
    }
}
