<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Setting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Setting::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Options';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'key';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'key',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Boolean::make('Editable')
                ->rules('boolean')
                ->help('NOTE! Removing this will prevent future updates, FOREVER!'),

            Text::make('Key')
                ->rules('required', 'string', 'max:255')
                ->creationRules('unique:settings,key')
                ->updateRules('unique:settings,key,{{resourceId}}')
                ->readonly()
                ->sortable(),

            Select::make('Type')
                ->rules('required', Rule::in(array_keys(\Settings::$types)))
                ->options(\Settings::$types),

            Code::make('Value', function () {
                return \Settings::stringify($this->value, $this->type);
            })->hideWhenUpdating(),

            Code::make('Value')
                ->rules('nullable', 'string', 'max:65500')
                ->resolveUsing(function ($value) {
                    return \Settings::stringify($this->value, $this->type);
                })
                ->hideFromDetail()
                ->help('NOTE! Incorrect/corrupted formats may set the value to NULL. Copy contents before saving!!'),

            Text::make('Comment')
                ->rules('nullable', 'max:255'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Determine if the current user can update the given resource.
     *
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        return $this->editable ? $this->authorizedTo($request, 'update') : false;
    }
}
