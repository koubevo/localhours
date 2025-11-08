@extends('livewire.layouts.admin-layout')

@section('title', 'Domů')

@section('content')
    <section class="space-y-4">
        <x-today-hours :employees="$employees" />

        @if (count($hours) > 0)
            @livewire('ui.table', [
                'columns' => [
                    ['label' => '', 'key' => 'status', 'status_color' => true],
                    ['label' => 'Kdo', 'key' => 'employee.name', 'route' => 'employee.show'],
                    ['label' => 'Datum', 'key' => 'formatted_work_date', 'print_only' => true],
                    ['label' => 'Od', 'key' => 'start_time'],
                    ['label' => 'Do', 'key' => 'end_time'],
                    ['label' => 'Popis', 'key' => 'description', 'shorten' => true],
                    ['label' => 'Částka', 'key' => 'earning', 'countable' => true, 'type' => 'currency'],
                ],
                'rows' => $hours,
                'showMonthSelector' => false,
                'editRoute' => 'hours.edit',
                'deleteModel' => \App\Models\Hour::class,
                'heading' => 'Dnešní docházka',
                'showHoursLegend' => true
            ])
        @endif
    </section>
@endsection