<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alternative extends Component
{

    public string $capital;

    public function __construct(string $capital)
    {
        $this->capital = $capital;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alternative');
    }
}
