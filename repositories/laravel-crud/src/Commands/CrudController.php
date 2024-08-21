<?php

namespace Emotality\CRUD\Commands;

use Emotality\CRUD\Helpers\CrudHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\warning;

class CrudController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:controller {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create controller for a Model';

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
        $has_request = File::exists(sprintf('%s/%sRequest.php', CrudHelper::$paths['requests'], self::$model));
        $has_policy = File::exists(sprintf('%s/%sPolicy.php', CrudHelper::$paths['policies'], self::$model));

        $stub = CrudHelper::stub($has_request ? 'ControllerRequest.stub' : 'Controller.stub');

        $vars = CrudHelper::$vars;
        $vars['policy'] = $has_policy ? '' : '//';

        foreach ($vars as $key => $value) {
            $stub = str_replace(sprintf('{{%s}}', $key), $value, $stub);
        }

        if (! $has_request) {
            $rules = CrudHelper::modelRules(self::$model);
            $stub = str_replace('{{rules}}', CrudHelper::rulesString($rules), $stub);
        }

        File::put(
            sprintf('%s/%sController.php', CrudHelper::$paths['controllers'], self::$model),
            $stub
        );

        self::insertRoute();
        self::insertSidebarLink();
    }

    private static function insertRoute()
    {
        $route = File::get(base_path('routes/admin.php'));

        if (Str::contains($route, sprintf("Route::resource('%s'", CrudHelper::$vars[CrudHelper::ROUTE_AND_VIEW]))) {
            return;
        }

        $route .= PHP_EOL.PHP_EOL.sprintf("Route::resource('%s', \App\Http\Controllers\Admin\%sController::class);", CrudHelper::$vars[CrudHelper::ROUTE_AND_VIEW], self::$model);

        File::put(
            base_path('routes/admin.php'),
            $route
        );
    }

    private static function insertSidebarLink()
    {
        $sidebar = File::get(resource_path('views/partials/admin/sidebar.blade.php'));
        $sidebar_lines = explode(PHP_EOL, $sidebar);

        if (Str::contains($sidebar, sprintf("route('admin.%s.index')", CrudHelper::$vars[CrudHelper::ROUTE_AND_VIEW]))) {
            return;
        }

        $tabs = '                ';
        $insert = $tabs.sprintf("<a class=\"nav-link {{ \Ekko::isActiveRoute('admin.%s.*') }}\" href=\"{{ route('admin.%s.index') }}\">", CrudHelper::$vars[CrudHelper::ROUTE_AND_VIEW], CrudHelper::$vars[CrudHelper::ROUTE_AND_VIEW]);
        $insert .= PHP_EOL.$tabs.'    <div class="nav-link-icon"><i class="fas fa-fw fa-question"></i></div>';
        $insert .= PHP_EOL.$tabs.'    '.CrudHelper::$vars[CrudHelper::PLURAL_WORD_CAP];
        $insert .= PHP_EOL.$tabs.'</a>';

        if (($index = Arr::containIndex($sidebar_lines, '<div class="sidenav-menu-heading">Content</div>')) !== false) {
            array_splice($sidebar_lines, $index + 1, 0, $insert);
        } elseif (($index = Arr::containIndex($sidebar_lines, '<div class="sidenav-menu-heading">Home</div>')) !== false) {
            array_splice($sidebar_lines, $index + 1, 0, $insert);
        } else {
            warning('Failed to insert to Providers/EventServiceProvider.php :'.$insert);
        }

        File::put(
            resource_path('views/partials/admin/sidebar.blade.php'),
            implode(PHP_EOL, $sidebar_lines)
        );
    }
}
