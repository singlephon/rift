<?php

namespace Singlephon\Rift\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rift extends Component
{
    public string $component;

    public function __construct(string $component)
    {
        $this->component = $component;
    }

    public function render(): View|Closure|string
    {
        return view('rift::components.rift');
    }
}
