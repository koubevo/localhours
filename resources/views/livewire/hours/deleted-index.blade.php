@extends('livewire.layouts.admin-layout')

@section('title', 'Smazané hodiny')

@section('content')

    <section class="space-y-4">
        @livewire('ui.table', [
            'columns' => [
                ['label' => '', 'key' => 'status', 'status_color' => true],
                ['label' => 'Kdo', 'key' => 'employee.name'],
                ['label' => 'Datum', 'key' => 'formatted_work_date'],
                ['label' => 'Od', 'key' => 'start_time'],
                ['label' => 'Do', 'key' => 'end_time'],
                ['label' => 'Částka', 'key' => 'earning', 'countable' => true, 'type' => 'currency'],
                ['label' => 'Datum smazání', 'key' => 'formatted_deleted_at'],
            ],
            'rows' => $hours,
            'showDatesSelector' => true,
            'showEmployeeSelector' => true,
            'restoreRoute' => 'hours.restore',
            'restoreModel' => \App\Models\Hour::class,
            'heading' => 'Smazané hodiny',
            'tableType' => 'deleted',
            'showHoursLegend' => true
        ])
    </section>
@endsection