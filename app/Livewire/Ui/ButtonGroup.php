<?php

namespace App\Livewire\Ui;

use Illuminate\View\View;
use Livewire\Component;

class ButtonGroup extends Component
{
    /**
     * @var string[]
     */
    public $buttons = [];

    /**
     * @param  string[]  $buttons
     */
    public function mount(array $buttons): void
    {
        $this->buttons = $buttons;
    }

    public function render(): View
    {
        return view('livewire.ui.button-group');
    }
}
