<?php

namespace App\Livewire\Hours;

use Illuminate\View\View;
use Livewire\Component;

class DeletedIndex extends Component
{
    public function render(): View
    {
        return view('livewire.hours.deleted-index');
    }
}
