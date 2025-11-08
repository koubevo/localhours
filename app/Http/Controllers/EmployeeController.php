<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function create(): View
    {
        return view('components.employees.create');
    }

    public function show(Employee $employee): View
    {
        $employee->load([
            'hours' => function ($query) {
                $query->orderBy('work_date', 'desc');
            },
            'payments' => function ($query) {
                $query->orderBy('payment_date', 'desc');
            },
        ]);

        return view('livewire.employees.show', ['employee' => $employee]);
    }

    public function edit(Employee $employee): View
    {
        return view('components.employees.edit', ['employee' => $employee]);
    }

    public function toggleHidden(Employee $employee): RedirectResponse
    {
        $employee->update(['is_hidden' => ! $employee->is_hidden]);

        return redirect()->route('employee.show', $employee);
    }
}
