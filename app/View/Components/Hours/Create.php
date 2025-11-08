<?php

namespace App\View\Components\Hours;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Create extends Component
{
    public function __construct() {}

    public function render(): View|Closure|string
    {
        return view('components.hours.create');
    }
}
