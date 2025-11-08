<?php

namespace App\View\Composers;

use App\Models\Employee;
use Illuminate\View\View;

class EmployeeSidebarComposer
{
    public function compose(View $view): void
    {
        $view->with('allEmployees', Employee::where('is_hidden', false)->orderBy('name')->get());
        $view->with('hiddenEmployees', Employee::where('is_hidden', true)->orderBy('name')->get());
    }
}
