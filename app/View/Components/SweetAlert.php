<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SweetAlert extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Closure|string
     */
    public function render()
    {
        return view('components.sweetalert')->with([
            'alert' => \Session::get('sweetAlert'),
        ]);
    }
}
