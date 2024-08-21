<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Password extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $key = 'password',
        public string $label = 'Password',
        public string $confirm_label = 'Confirm Password',
        public bool $confirm = true,
        public ?string $placeholder = null,
        public ?string $info = null,
        public ?string $class = null,
        public bool $required = true,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.password');
    }
}
