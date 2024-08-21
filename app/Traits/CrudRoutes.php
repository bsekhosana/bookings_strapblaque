<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CrudRoutes
{
    /**
     * Parent model if current model is nested.
     */
    protected static ?string $nested_parent = null;

    /**
     * Set all route URLs for this model as a relationship.
     */
    public function withCrudRoutes(?Model $parent = null): self
    {
        $crud_routes = [];

        $cruds = [
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ];

        foreach ($cruds as $crud) {
            $crud_routes[$crud] = self::route($crud, $parent, $this);
        }

        $this->routes = (object) $crud_routes;

        return $this;
    }

    /**
     * Get "index" route URL.
     */
    public static function indexRoute(?Model $parent = null): ?string
    {
        return self::route('index', $parent);
    }

    /**
     * Get "create" route URL.
     */
    public static function createRoute(?Model $parent = null): ?string
    {
        return self::route('create', $parent);
    }

    /**
     * Get "store" route URL.
     */
    public static function storeRoute(?Model $parent = null): ?string
    {
        return self::route('store', $parent);
    }

    /**
     * Get "show" route URL.
     */
    public function showRoute(?Model $parent = null): ?string
    {
        return $this::route('show', $parent, $this);
    }

    /**
     * Get "edit" route URL.
     */
    public function editRoute(?Model $parent = null): ?string
    {
        return $this::route('edit', $parent, $this);
    }

    /**
     * Get "update" route URL.
     */
    public function updateRoute(?Model $parent = null): ?string
    {
        return $this::route('update', $parent, $this);
    }

    /**
     * Get "destroy" route URL.
     */
    public function destroyRoute(?Model $parent = null): ?string
    {
        return $this::route('destroy', $parent, $this);
    }

    /**
     * Generate a route URL with parameters if any.
     */
    private static function route(string $crud, ?Model $parent = null, ?Model $model = null): ?string
    {
        $route_name = self::routeNameForCrud($crud, $model);

        if (\Route::has($route_name)) {
            if ($model && $parent) {
                return route($route_name, [
                    strtolower(class_basename($parent)) => $parent,
                    strtolower(class_basename($model))  => $model,
                ]);
            } elseif ($model) {
                return route($route_name, $model);
            } elseif ($parent) {
                return route($route_name, $parent);
            } else {
                return route($route_name);
            }
        }

        return null;
    }

    /**
     * Build route name for CRUD action.
     */
    private static function routeNameForCrud(string $crud, ?Model $model = null): string
    {
        $plural_model = self::snakePluralModelName($model);

        return static::$nested_parent
            ? sprintf('%s.%s.%s.%s', \Auth::getDefaultDriver(), static::$nested_parent, $plural_model, $crud)
            : sprintf('%s.%s.%s', \Auth::getDefaultDriver(), $plural_model, $crud);
    }

    /**
     * Split the model name and pluralize the last word, in snake case.
     */
    private static function snakePluralModelName(?Model $model = null): string
    {
        $words = \Str::ucsplit(class_basename($model ?? static::class));

        if (count($words) === 1) {
            return strtolower(\Str::plural(array_values($words)[0]));
        }

        $last_word = array_pop($words);

        $words[] = \Str::plural($last_word);

        return strtolower(implode('_', $words));
    }
}
