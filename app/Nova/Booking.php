<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Booking extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Booking>
     */
    public static $model = \App\Models\Booking::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Scheduling';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['organization', 'subscription', 'service', 'user'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'client_name',
        'client_email',
        'client_phone',
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

            BelongsTo::make('Organization', 'organization', Organization::class)
                ->sortable()
                ->searchable()
                ->rules('required'),

            BelongsTo::make('Subscription', 'subscription', Subscription::class)
                ->sortable()
                ->searchable()
                ->rules('required'),

            BelongsTo::make('Service', 'service', Service::class)
                ->sortable()
                ->searchable()
                ->rules('required'),

            BelongsTo::make('User', 'user', User::class)
                ->sortable()
                ->searchable()
                ->rules('required'),

            Text::make('Client Name', 'client_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Client Email', 'client_email')
                ->sortable()
                ->rules('required', 'email', 'max:255'),

            Text::make('Client Phone', 'client_phone')
                ->sortable()
                ->rules('required', 'max:20'),

            DateTime::make('Start Time', 'start_time')
                ->sortable()
                ->rules('required', 'date'),

            DateTime::make('End Time', 'end_time')
                ->sortable()
                ->rules('required', 'date'),

            Select::make('Status', 'status')
                ->options([
                    'Scheduled' => 'Scheduled',
                    'Completed' => 'Completed',
                    'Canceled' => 'Canceled',
                ])
                ->displayUsingLabels()
                ->rules('required'),

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
