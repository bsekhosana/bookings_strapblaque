<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class CrudActions extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(private Model $model)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Closure|string
     */
    public function render()
    {
        $echo = '';

        if ($show = $this->model->routes?->show) {
            $echo .= sprintf('<a class="btn btn-sm btn-success mb-1 px-2 me-1" title="View" href="%s"><i class="fas fa-fw fa-eye"></i></a>', $show);
        }

        if ($edit = $this->model->routes?->edit) {
            $echo .= sprintf('<a class="btn btn-sm btn-info mb-1 px-2 me-1" title="Edit" href="%s"><i class="fas fa-fw fa-pencil-alt"></i></a>', $edit);
        }

        if ($destroy = $this->model->routes?->destroy) {
            $key = $this->model->getRouteKeyName();
            $echo .= sprintf('<a class="btn btn-sm btn-danger mb-1 px-2" title="Delete" style="cursor: pointer;" onclick="deleteModel(\'%s\');"><i class="fas fa-fw fa-trash-alt"></i></a>', $this->model->{$key});
            $echo .= sprintf('<form id="delete-%s" action="%s" method="POST" style="display: none;">', $this->model->{$key}, $destroy);
            $echo .= sprintf('<input type="hidden" name="_token" value="%s"><input type="hidden" name="_method" value="DELETE"></form>', csrf_token());
        }

        return $echo;
    }
}
