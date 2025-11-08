<?php

namespace App\Http\Controllers;

use App\Models\Hour;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HoursController extends Controller
{
    public function index(): View
    {
        $hours = Hour::with('employee')->get();

        return view('livewire.hours.index', ['hours' => $hours]);
    }

    public function deletedIndex(): View
    {
        $hours = Hour::with('employee')->onlyTrashed()->get();

        return view('livewire.hours.deleted-index', ['hours' => $hours]);
    }

    public function create(Request $request): View
    {
        $preselectedEmployee = $request->get('employee') ?? null;

        return view('components.hours.create', [
            'preselectedEmployee' => $preselectedEmployee,
        ]);
    }

    public function edit(Hour $hour): View
    {
        return view('components.hours.edit', [
            'hourId' => $hour->id,
        ]);
    }
}
