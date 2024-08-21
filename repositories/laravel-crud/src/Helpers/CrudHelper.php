<?php

namespace Emotality\CRUD\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;
use function Laravel\Prompts\select;

class CrudHelper
{
    public const string MODEL_NAME = 'model';

    public const string SINGULAR_WORD = 'singular_word';

    public const string SINGULAR_WORD_CAP = 'singular_word_cap';

    public const string SINGULAR_VAR = 'singular_variable';

    public const string PLURAL_WORD = 'plural_word';

    public const string PLURAL_WORD_CAP = 'plural_word_cap';

    public const string PLURAL_VAR = 'plural_variable';

    public const string ROUTE_AND_VIEW = 'route_and_view';

    public const string AN_OR_A = 'an_or_a';

    public static array $vars = [
        //self::MODEL_NAME        => 'ExampleModel',
        //self::SINGULAR_WORD     => 'example model',
        //self::SINGULAR_WORD_CAP => 'Example Model',
        //self::SINGULAR_VAR      => 'example_model',
        //self::PLURAL_WORD       => 'example models',
        //self::PLURAL_WORD_CAP   => 'Example Models',
        //self::PLURAL_VAR        => 'example_models',
        //self::ROUTE_AND_VIEW    => 'example_models',
        //self::AN_OR_A           => 'an',
    ];

    public static array $relative_paths = [
        'views'       => 'resources/views/admin',
        'controllers' => 'app/Http/Controllers/Admin',
        'requests'    => 'app/Http/Requests/Admin',
        'observers'   => 'app/Observers',
        'policies'    => 'app/Policies',
    ];

    public static array $paths = [];

    public static array $cached = [];

    public static function askModel(?string $artisan_model = null): string
    {
        if ($artisan_model) {
            $artisan_model = ucfirst($artisan_model);

            if (! class_exists('\\App\\Models\\'.$artisan_model)) {
                error(sprintf('Model [%s] does not exist!', $artisan_model));
                exit(1);
            }

            $model = $artisan_model;
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

            $model = select(
                label: 'For which models?',
                options: collect($options)->values(),
                scroll: 15,
                required: true,
            );
        }

        return $model;
    }

    public static function setup(string $model, bool $force = false): void
    {
        if (empty(self::$paths)) {
            self::resourcePaths();
        }

        if (empty(self::$cached)) {
            self::cacheAllModels();
        }

        if (empty(self::$vars) || $force) {
            self::$vars = self::modelVars($model);
        }
    }

    private static function cacheAllModels()
    {
        $model_files = File::files(app_path('Models'));

        foreach ($model_files as $model) {
            $model = $model->getFilenameWithoutExtension();
            self::modelVars($model);
            self::modelColumns($model);
            self::modelRules($model);
        }
    }

    public static function resourcePaths(): array
    {
        foreach (self::$relative_paths as $resource => $path) {
            $paths[$resource] = base_path($path);

            File::ensureDirectoryExists($paths[$resource]);
        }

        return self::$paths = $paths ?? [];
    }

    public static function modelVars(string $model): array
    {
        $model = ucfirst($model);

        if (isset(self::$cached[$model]['vars'])) {
            return self::$cached[$model]['vars'];
        }

        $word_parts = Str::ucsplit($model);
        $words = Str::lower(implode(' ', $word_parts));

        $singular_word = Str::singular($words);
        $singular_word_cap = ucwords($singular_word);
        $singular_variable = Str::snake($singular_word);

        $plural_word = Str::plural($words);
        $plural_word_cap = ucwords($plural_word);
        $plural_variable = Str::snake($plural_word);

        $route_and_view = Str::snake($plural_word);
        $an_or_a = self::anOrA($singular_word);

        return self::$cached[$model]['vars'] = [
            self::MODEL_NAME        => $model,
            self::ROUTE_AND_VIEW    => $route_and_view,
            self::SINGULAR_WORD     => $singular_word,
            self::SINGULAR_WORD_CAP => $singular_word_cap,
            self::SINGULAR_VAR      => $singular_variable,
            self::PLURAL_WORD       => $plural_word,
            self::PLURAL_WORD_CAP   => $plural_word_cap,
            self::PLURAL_VAR        => $plural_variable,
            self::AN_OR_A           => $an_or_a,
        ];
    }

    public static function modelColumns(string $model): array
    {
        if (isset(self::$cached[$model]['columns'])) {
            return self::$cached[$model]['columns'];
        }

        return self::$cached[$model]['columns'] = ModelColumns::columnsForModel($model);
    }

    public static function modelRules(string $model): array
    {
        if (isset(self::$cached[$model]['rules'])) {
            return self::$cached[$model]['rules'];
        }

        return self::$cached[$model]['rules'] = ModelRules::rulesForModel($model);
    }

    public static function anOrA(string $word): string
    {
        $vowels = ['a', 'e', 'i', 'o', 'u'];

        if (in_array($word[0], $vowels)) {
            return 'an';
        }

        $word = explode(' ', $word)[0];

        $words = ['hour', 'honor', 'honour', 'honest', 'sms'];

        if (in_array($word, $words)) {
            return 'an';
        }

        return 'a';
    }

    public static function stub(string $filename): string|false
    {
        $path = base_path(sprintf('stubs/crud/%s', $filename));

        return File::get($path);
    }

    public static function rulesString(array $rules): string
    {
        $space = '            ';

        if (empty($rules)) {
            return PHP_EOL.$space."'' => ['required', ''],";
        }

        $rules_str = '';

        foreach ($rules as $property => $request_rules) {
            if (count($request_rules)) {
                $spaces = self::spaces(array_keys($rules), $property);
                $wrapped = [];
                foreach ($request_rules as $rule) {
                    $wrapped[] = Str::startsWith($rule, 'Rule::') ? $rule : Str::wrap($rule, "'");
                }
                $rules_str .= PHP_EOL.$space.sprintf("'%s' %s=> [%s],", $property, $spaces, implode(', ', $wrapped));
            } else {
                $rules_str .= PHP_EOL.$space.sprintf("'%s' %s=> ['required', ''],", $property, $spaces);
            }
        }

        return $rules_str;
    }

    private static function spaces(array $words, string $word): string
    {
        $longest_word = 0;

        foreach ($words as $loop_word) {
            if (($strlen = strlen($loop_word)) > $longest_word) {
                $longest_word = $strlen;
            }
        }

        $spaces = $longest_word - strlen($word);
        $str = '';
        $index = 0;

        while ($index < $spaces) {
            $str .= ' ';
            $index++;
        }

        return $str;
    }
}
