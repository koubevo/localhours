<?php

namespace App\Livewire\Layouts;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class AdminLayout extends Component
{
    public function render(): View
    {
        return view('livewire.layouts.admin-layout');
    }

    public function navigateToRoute(?Employee $employee = null): RedirectResponse
    {
        return redirect()->route('hours.create', [
            'employee' => $employee,
        ]);
    }
}
