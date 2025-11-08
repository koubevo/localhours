<?php

namespace App\Livewire\Partials;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class StartHoursButton extends Component
{
    public int $employeeId;

    public function navigate(): RedirectResponse
    {
        return redirect()->route('hours.create', [
            'employee' => $this->employeeId,
        ]);
    }

    public function render(): View
    {
        return view('livewire.partials.start-hours-button');
    }
}
