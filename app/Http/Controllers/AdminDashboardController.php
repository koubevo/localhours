<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $employees = Employee::where('is_hidden', false)->orderBy('name')->get();
        $hours = Hour::with('employee')->where('work_date', Carbon::today()->toDateString())->get();

        return view('admin.dashboard', [
            'employees' => $employees,
            'hours' => $hours,
        ]);
    }
}
