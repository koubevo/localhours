<?php

namespace App\Livewire\Ui;

use App\Models\Employee;
use App\Models\Hour;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Table extends Component
{
    /**
     * @var string[]
     */
    public array $columns = [];

    /**
     * @var Collection<int, Hour|Payment>
     */
    public Collection $rows;

    public bool $showMonthSelector = false;

    public bool $showDatesSelector = false;

    public bool $showEmployeeSelector = false;

    public bool $showSum = false;

    public ?string $selectedMonth = null;

    public ?string $selectedStartDate = null;

    public ?string $selectedEndDate = null;

    public ?string $selectedEmployee = null;

    public ?string $editRoute = null;

    public bool $showDeleteModal = false;

    public ?int $rowToDeleteId = null;

    public ?string $deleteModel = null;

    /**
     * @var array<string, float|string|null>|null
     */
    public ?array $arrayDeleteInformation = null;

    public ?string $heading = null;

    public ?string $tableType = null;

    public bool $showRestoreModal = false;

    public ?int $rowToRestoreId = null;

    public ?string $restoreModel = null;

    /**
     * @var array<string, float|string|null>|null
     */
    public ?array $arrayRestoreInformation = null;

    public ?int $tableNumber = 1;

    public function render(): View
    {
        return view('livewire.ui.table');
    }

    public function updatedSelectedStartDate(): void
    {
        $this->refreshRows();
    }

    public function updatedSelectedEndDate(): void
    {
        $this->refreshRows();
    }

    public function updatedSelectedEmployee(): void
    {
        $this->refreshRows();
    }

    protected function refreshRows(): void
    {
        if (empty($this->deleteModel)) {
            return;
        }

        $modelClass = $this->deleteModel;

        $dateColumn = null;
        $with = [];
        switch ($modelClass) {
            case Hour::class:
                $dateColumn = 'work_date';
                $with = ['employee'];
                break;
            case Payment::class:
                $dateColumn = 'payment_date';
                $with = ['employee'];
                break;
            default:
                $dateColumn = 'created_at';
        }

        $query = $modelClass::query()->with($with);

        if ($this->tableType === 'deleted' && method_exists($modelClass, 'bootSoftDeletes')) {
            $query = $modelClass::onlyTrashed()->with($with);
        }

        if (! empty($this->selectedEmployee)) {
            $query->where('employee_id', (int) $this->selectedEmployee);
        }

        if (! empty($this->selectedStartDate)) {
            $query->whereDate($dateColumn, '>=', $this->selectedStartDate);
        }
        if (! empty($this->selectedEndDate)) {
            $query->whereDate($dateColumn, '<=', $this->selectedEndDate);
        }
        $query->when($dateColumn, fn ($q) => $q->orderByDesc($dateColumn));

        $this->rows = $query->get();
    }

    public function confirmDelete(int $rowId): void
    {
        $this->rowToDeleteId = $rowId;
        $this->showDeleteModal = true;
        if (isset($this->deleteModel)) {
            $model = $this->deleteModel;
            $row = $model::findOrFail($this->rowToDeleteId);

            switch ($model) {
                case 'App\Models\Hour':
                    $this->arrayDeleteInformation = self::arrayHourInformation($row, $row->employee);
                    break;
                case 'App\Models\Payment':
                    $this->arrayDeleteInformation = self::arrayPaymentInformation($row, $row->employee);
                    break;
                default:
                    $this->arrayDeleteInformation = null;
            }
        }
    }

    public function confirmRestore(int $rowId): void
    {
        $this->rowToRestoreId = $rowId;
        $this->showRestoreModal = true;
        if (isset($this->restoreModel)) {
            $model = $this->restoreModel;
            $row = $model::onlyTrashed()->findOrFail($this->rowToRestoreId);
            switch ($model) {
                case 'App\Models\Hour':
                    $this->arrayRestoreInformation = self::arrayHourInformation($row, $row->employee);
                    break;
                case 'App\Models\Payment':
                    $this->arrayRestoreInformation = self::arrayPaymentInformation($row, $row->employee);
                    break;
                default:
                    $this->arrayRestoreInformation = null;
            }
        }
    }

    public function deleteRow(): void
    {
        $model = $this->deleteModel;
        if (! $this->rowToDeleteId || ! isset($model)) {
            return;
        }

        $row = $model::findOrFail($this->rowToDeleteId);
        $row->delete();

        $this->showDeleteModal = false;
        $this->rowToDeleteId = null;

        session()->flash('success', 'Záznam byl úspěšně smazán.');
        $this->redirect(request()->header('Referer'), navigate: true);
    }

    public function restoreRow(): void
    {
        $model = $this->restoreModel;

        if (! $this->rowToRestoreId || ! isset($model)) {
            return;
        }

        $row = $model::onlyTrashed()->findOrFail($this->rowToRestoreId);
        $row->restore();

        $this->showRestoreModal = false;
        $this->rowToRestoreId = null;

        session()->flash('success', 'Záznam byl úspěšně obnoven.');
        $this->redirect(request()->header('Referer'), navigate: true);
    }

    /**
     * @return array<string, string|null>
     */
    public function arrayHourInformation(Hour $hour, Employee $employee): array
    {
        return [
            'label1' => 'Kdo',
            'label2' => 'Datum',
            'label3' => 'Od',
            'label4' => 'Do',
            'value1' => $employee->name,
            'value2' => $hour->formatted_work_date,
            'value3' => $hour->start_time,
            'value4' => $hour->end_time,
        ];
    }

    /**
     * @return array<string, string|float|null>
     */
    public function arrayPaymentInformation(Payment $payment, Employee $employee): array
    {
        return [
            'label1' => 'Kdo',
            'label2' => 'Datum',
            'label3' => 'Částka',
            'value1' => $employee->name,
            'value2' => $payment->formatted_payment_date,
            'value3' => $payment->amount,
        ];
    }
}
