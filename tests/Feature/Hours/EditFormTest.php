<?php

use App\Livewire\Forms\HoursForm;
use App\Models\Hour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('edit hours form can be rendered', function () {
    $hour = Hour::factory()->create();
    $response = $this->withSession(['is_admin' => true])->get('/admin/hours/'.$hour->id.'/edit');

    $response->assertStatus(200);
});

test('edit hours form can be submitted', function () {
    $hour = Hour::factory()->create([
        'work_date' => '2025-10-19',
        'start_time' => '08:00',
        'end_time' => '12:00',
    ]);

    Livewire::test(HoursForm::class)
        ->set('isEditMode', true)
        ->set('hour', $hour)
        ->set('employee', $hour->employee_id)
        ->set('work_date', $hour->work_date)
        ->set('start_time', $hour->start_time)
        ->set('end_time', '14:00')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('hours', [
        'id' => $hour->id,
        'work_date' => $hour->work_date,
        'start_time' => $hour->start_time,
        'end_time' => '14:00:00',
    ]);
});
