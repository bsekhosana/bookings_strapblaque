<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Blade::directive('humanDate',
            fn (?string $expression = null): string => "<?php echo ($expression)->format(\Settings::get('date_format')); ?>"
        );

        \Blade::directive('humanDateTime',
            fn (?string $expression = null): string => "<?php echo ($expression)->format(\Settings::get('datetime_format')); ?>"
        );

        \Route::macro('isHomepage',
            fn (): bool => $this->current()->getName() == 'guest.homepage'
        );

        \Arr::macro('contains', function (array $array, string $contains): bool {
            foreach ($array as $value) {
                if (\Str::contains($value, $contains)) {
                    return true;
                }
            }

            return false;
        });

        \Arr::macro('containIndex', function (array $array, string $contains): int|string|false {
            foreach ($array as $key => $value) {
                if (\Str::contains($value, $contains)) {
                    return $key;
                }
            }

            return false;
        });

        Collection::macro('loadCrudRoutes', function (?Model $parent = null) {
            return $this->map(function (Model $value) use ($parent) {
                return method_exists($value, 'withCrudRoutes')
                    ? $value->withCrudRoutes($parent)
                    : $value->routes = null;
            });
        });
    }
}
