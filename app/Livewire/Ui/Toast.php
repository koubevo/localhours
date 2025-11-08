<?php

namespace App\Livewire\Ui;

use Illuminate\View\View;
use Livewire\Component;

class Toast extends Component
{
    public bool $success = true;

    public string $message = '';

    public string $icon = 'shield-check';

    public function render(): View
    {
        return view('livewire.ui.toast');
    }
}
