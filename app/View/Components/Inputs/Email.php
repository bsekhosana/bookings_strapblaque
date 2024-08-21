<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Email extends Component
{
    public string $type = 'email';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $key,
        public string $label,
        public ?string $value = null,
        public ?string $placeholder = null,
        public ?string $info = null,
        public ?string $class = null,
        public bool $required = true,
        public ?int $min = null,
        public ?int $max = null,
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
        return view('components.inputs.text');
    }
}
