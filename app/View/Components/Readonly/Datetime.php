<?php

namespace App\View\Components\Readonly;

use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class Datetime extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $key,
        public string $label,
        public Carbon|string|null $value = null,
        public ?string $info = null,
        public ?string $class = null,
    ) {
        if (! empty($this->value) && $this->value instanceof Carbon) {
            $this->value = $this->value->format(\Settings::get('datetime_format'));
        }
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
