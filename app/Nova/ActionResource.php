<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphToActionTarget;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

/**
 * @template TActionModel of \Laravel\Nova\Actions\ActionEvent
 *
 * @extends \Laravel\Nova\Resource<TActionModel>
 */
class ActionResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<TActionModel>
     */
    public static $model = \App\Models\ActionEvent::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    /**
     * Indicates whether the resource should automatically poll for new resources.
     *
     * @var bool
     */
    public static $polling = true;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'System';

    /**
     * Determine if the current user can create new resources.
     *
     * @return bool
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can edit resources.
     *
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can replicate the given resource.
     *
     * @return bool
     */
    public function authorizedToReplicate(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can delete resources.
     *
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request) // (Request $request)
    {
        return [
            ID::make('ID', 'id')->showOnPreview(),

            Text::make('Action', 'name', function ($value) {
                return $value;
            })->showOnPreview(),

            Text::make('Initiated By', function () {
                return $this->user->name ?? $this->user->email ?? 'Nova User';
            })->showOnPreview(),

            MorphToActionTarget::make('Target', 'target')->showOnPreview(),

            Status::make('Status', 'status', function ($value) {
                return ucfirst($value);
            })->loadingWhen(['Waiting', 'Running'])->failedWhen(['Failed']),

            $this->when(isset($this->original), function () {
                return KeyValue::make('Original', 'original')->showOnPreview();
            }),

            $this->when(isset($this->changes), function () {
                return KeyValue::make('Changes', 'changes')->showOnPreview();
            }),

            Textarea::make('Exception', 'exception')->showOnPreview(),

            DateTime::make('Actioned At', 'created_at')->exceptOnForms()->showOnPreview(),
        ];
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->with('user');
    }

    /**
     * Determine if this resource is available for navigation.
     *
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return true;
    }

    /**
     * Determine if this resource is searchable.
     *
     * @return bool
     */
    public static function searchable()
    {
        return false;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'Admin Actions';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Action';
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'action-events';
    }
}
