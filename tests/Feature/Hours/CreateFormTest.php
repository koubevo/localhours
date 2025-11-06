<?php

use App\Enum\HoursStatus;
use App\Livewire\Forms\HoursForm;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('create hours form can be rendered', function () {
    $response = $this->withSession(['is_admin' => true])->get('/admin/hours/create');

    $response->assertStatus(200);
});

test('create hours form can be submitted', function () {
    $employee = Employee::factory()->create();

    $workDate = now()->format('Y-m-d');
    $start = '08:00';
    $end = '10:00';

    Livewire::test(HoursForm::class)
        ->set('employee', $employee->id)
        ->set('work_date', $workDate)
        ->set('start_time', $start)
        ->set('end_time', $end)
        ->set('hour_rate', 500)
        ->call('save')
        ->assertSessionHas('success')
        ->assertRedirect(route('admin.dashboard'));

    $this->assertDatabaseHas('hours', [
        'employee_id' => $employee->id,
        'work_date' => $workDate,
        'start_time' => $start,
        'end_time' => $end,
        'status' => HoursStatus::Completed->value,
        'earning' => '1000',
    ]);
});
