<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrganizationSetting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\OrganizationSetting>
     */
    public static $model = \App\Models\OrganizationSetting::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Management';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'slug';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['organization'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'slug'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Organization')->sortable(),

            Text::make('Slug')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideWhenCreating(),

            Color::make('Primary Color')
                ->rules('required', 'max:7')
                ->help('Provide a hex color code, e.g., #ff0000'),

            Color::make('Secondary Color')
                ->rules('required', 'max:7')
                ->help('Provide a hex color code, e.g., #00ff00'),

            Image::make('Logo Small', 'logo_small')
                ->rules('nullable', 'image', 'max:1024'),

            Image::make('Logo Large', 'logo_large')
                ->rules('nullable', 'image', 'max:2048'),

            Text::make('Time Zone')
                ->sortable()
                ->rules('required', 'max:255')
                ->help('Specify the time zone, e.g., UTC, America/New_York'),

            Number::make('Appointment Duration')
                ->sortable()
                ->rules('required', 'integer', 'min:1')
                ->help('Duration in minutes'),

            DateTime::make('Created At')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Updated At')
                ->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request)
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
