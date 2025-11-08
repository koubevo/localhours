<?php

namespace App\Livewire\Ui;

use Illuminate\View\View;
use Livewire\Component;

class FailureToast extends Component
{
    public string $message = '';

    public function render(): View
    {
        return view('livewire.ui.failure-toast');
    }
}
