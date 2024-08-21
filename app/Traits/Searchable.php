<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait Searchable
{
    /**
     * Search input fields' keys.
     *
     * @var array<int, string>
     */
    protected static array $searchable = ['search'];

    /**
     * If searching, filter models, else, call callable.
     */
    public static function search(callable $default, string $model = 'models'): array
    {
        $searchable = array_unique(array_merge(['search'], static::$searchable));

        if (request()->hasAny($searchable)) {
            request()->flashOnly($searchable);

            $appends = request()->only($searchable);
            $models = static::filter(request()); // call filter() function on Model
        } else {
            request()->flush();

            $appends = null;
            $models = $default(); // call $default callable if not searching
        }

        $models->loadCrudRoutes();

        return [
            $model    => $models,
            'appends' => $appends,
        ];
    }

    /**
     * Filter search from request queries.
     */
    protected static function filter(Request $request): LengthAwarePaginator|Collection
    {
        // Override this function from Model!
        // Remember to add to Model: protected static array $searchable = ['search'];

        return static::paginate();
    }
}
