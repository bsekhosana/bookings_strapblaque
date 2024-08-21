<?php

namespace App\View\Components\Readonly;

use Illuminate\View\Component;

class Boolean extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $key,
        public string $label,
        public bool|string $value = false,
        public ?string $info = null,
        public ?string $class = null,
    ) {
        $this->value = $value ? 'Yes' : 'No';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.readonly.text');
    }
}
