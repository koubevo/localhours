<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HoursController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'admin.login')
    ->middleware('unauthenticated')
    ->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('/employee', EmployeeController::class)
        ->only(['create', 'show', 'edit', 'hide']);

    Route::get('/employee/{employee}/toggleHidden', [EmployeeController::class, 'toggleHidden'])
        ->name('employee.toggleHidden');

    Route::resource('/hours', HoursController::class)
        ->only(['index', 'create', 'edit']);

    Route::get('/hours/deleted', [HoursController::class, 'deletedIndex'])
        ->name('hours.deletedIndex');

    Route::resource('/payment', PaymentController::class)
        ->only(['index', 'create', 'edit']);
});

require __DIR__.'/auth.php';
