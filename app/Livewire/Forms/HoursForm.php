<?php

namespace App\Livewire\Forms;

use App\Enum\HoursStatus;
use App\Models\Employee;
use App\Models\Hour;
use App\Support\HoursCalculator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class HoursForm extends Component
{
    /**
     * @var Collection<int, Employee>
     */
    public Collection $employees;

    public ?int $employee;

    public string $work_date;

    public string $start_time;

    public ?string $end_time;

    public ?string $description;

    public ?int $hour_rate;

    public Hour $hour;

    public int $hourId;

    public bool $isEditMode = false;

    /**
     * @var array<string, string>
     */
    protected array $rules = [
        'employee' => 'required|exists:employees,id',
        'work_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i',
        'description' => 'nullable|string|max:10000',
        'hour_rate' => 'nullable|integer|min:0|max:100000',
    ];

    public function mount(?int $employee = null, ?int $hour_id = null): void
    {
        $this->employees = Employee::where('is_hidden', false)->orderBy('name')->get();
        $isEditMode = (bool) $hour_id;

        if ($isEditMode) {
            $this->isEditMode = true;
            $this->hourId = $hour_id;
            $this->hour = Hour::findOrFail($hour_id);
            $this->employee = $this->hour->employee_id;
            $this->fill($this->hour->except(['employee_id']));
        } else {
            $this->employee = $employee ?? 0;
            $this->work_date = now()->format('Y-m-d');
        }

        if ($this->employee) {
            $this->updateHourRate();
        }
    }

    public function updateHourRate(): void
    {
        if ($this->employee && isset($this->employee)) {
            $selectedEmployee = Employee::find($this->employee);
            if ($selectedEmployee) {
                $this->hour_rate = $selectedEmployee->hour_rate ?? 0;
            }
        }
    }

    public function render(): View
    {
        return view('livewire.forms.hours-form');
    }

    public function save(): Redirector|RedirectResponse
    {
        $validated = $this->validate();

        $data = $validated;
        $data['employee_id'] = $data['employee'];
        unset($data['hour_rate'], $data['employee']);

        if (isset($data['end_time']) && $data['end_time'] !== '') {
            $data['status'] = HoursStatus::Completed;
            $data['earning'] = HoursCalculator::calculateEarning(
                $validated['start_time'],
                $validated['end_time'],
                $validated['hour_rate'] ?? 0
            );
        } else {
            $data['end_time'] = null;
            $data['earning'] = 0;
            $data['status'] = HoursStatus::Draft;
        }

        if ($this->isEditMode) {
            $this->hour->update($data);
            session()->flash('success', 'Hodiny byly aktualizovány.');
        } else {
            Hour::create($data);
            session()->flash('success', 'Hodiny byly přidány.');
        }

        return redirect()->route('admin.dashboard');
    }
}
