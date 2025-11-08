<?php

namespace App\Livewire\Ui;

use Illuminate\View\View;
use Livewire\Component;

class SuccessToast extends Component
{
    public string $message = '';

    public function render(): View
    {
        return view('livewire.ui.success-toast');
    }
}
