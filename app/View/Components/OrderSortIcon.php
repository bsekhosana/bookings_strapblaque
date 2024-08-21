<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OrderSortIcon extends Component
{
    private string $icon;

    /**
     * Create a new component instance.
     */
    public function __construct(private string $route, string $order, bool $text)
    {
        // <x-order-sort-icon route="user.example.index" order="column" :text="true"/>

        if (request()->query('order') != $order) {
            $sort = 'asc';
        } else {
            $sort = request()->query('sort') == 'desc' ? 'asc' : 'desc';
        }

        $this->route = route($route, compact('order', 'sort'));

        if ($text) {
            $this->icon = $sort == 'desc' ? 'fa-arrow-up-z-a' : 'fa-arrow-down-a-z';
        } else {
            $this->icon = $sort == 'desc' ? 'fa-arrow-up-9-1' : 'fa-arrow-down-1-9';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return sprintf('<a href="%s"><i class="fas fa-fw %s"></i></a>', $this->route, $this->icon);
    }
}
