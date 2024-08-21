<?php

namespace App\View\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Pagination extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(private ?LengthAwarePaginator $models = null, private ?array $appends = null)
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
        if ($this->models && ($this->models->total() > $this->models->perPage())) {
            return sprintf('<div class="mt-3">%s</div>', $this->models->appends($this->appends)->links()->toHtml());
        }

        return '';
    }
}
