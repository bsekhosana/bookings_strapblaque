<?php

namespace App\View\Components\Readonly;

use Illuminate\View\Component;

class MultiSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $key,
        public string $label,
        public array $options = [],
        public array $value = [],
        public int $size = 5,
        public ?string $class = null,
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
        return view('components.readonly.multi-select');
    }
}
