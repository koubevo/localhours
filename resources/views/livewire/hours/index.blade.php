@extends('livewire.layouts.admin-layout')

@section('title', 'Vyhledat hodiny')

@section('content')

    <section class="space-y-4">
        @if (!empty($hours))
            @livewire('ui.table', [
                'columns' => [
                    ['label' => '', 'key' => 'status', 'status_color' => true],
                    ['label' => 'Kdo', 'key' => 'employee.name'],
                    ['label' => 'Datum', 'key' => 'formatted_work_date'],
                    ['label' => 'Od', 'key' => 'start_time'],
                    ['label' => 'Do', 'key' => 'end_time'],
                    ['label' => 'Částka', 'key' => 'earning', 'countable' => true, 'type' => 'currency'],
                ],
                'rows' => $hours,
                'showDatesSelector' => true,
                'showEmployeeSelector' => true,
                'editRoute' => 'hours.edit',
                'deleteModel' => \App\Models\Hour::class,
                'heading' => 'Docházka',
                'showHoursLegend' => true
            ])
        @endif  
    </section>
@endsection