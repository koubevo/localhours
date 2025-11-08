<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class PaymentForm extends Component
{
    /**
     * @var Collection<int, Employee>
     */
    public Collection $employees;

    public int $employee;

    public string $payment_date;

    public float $amount;

    public Payment $payment;

    public ?int $paymentId;

    public bool $isEditMode = false;

    /**
     * @var array<string, string>
     */
    protected array $rules = [
        'employee' => 'required|exists:employees,id',
        'payment_date' => 'required|date',
        'amount' => 'required|decimal:0,2|min:1|max:100000',
    ];

    public function mount(?int $employee = null, ?int $payment_id = null): void
    {
        $this->employees = Employee::where('is_hidden', false)->orderBy('name')->get();
        $isEditMode = $payment_id ? true : false;

        if ($isEditMode) {
            $this->isEditMode = true;
            $this->paymentId = $payment_id;
            $this->payment = Payment::findOrFail($payment_id);
            $this->employee = $this->payment->employee_id;
            $this->payment_date = $this->payment->payment_date;
            $this->fill($this->payment->except(['employee_id']));
        } else {
            $this->employee = $employee ? $employee : 0;
            $this->payment_date = now()->format('Y-m-d');
        }
    }

    public function render(): View
    {
        return view('livewire.forms.payment-form');
    }

    public function save(): Redirector|RedirectResponse
    {
        $validated = $this->validate();
        /** @var \App\Models\Employee $employee */
        $employee = Employee::findOrFail($validated['employee']);
        $debt = $employee->debt();

        if ($this->isEditMode) {
            $debt += $this->payment->amount;
        }

        if ($debt - $validated['amount'] >= 0) {
            $data = $validated;
            $data['employee_id'] = $data['employee'];
            unset($data['employee']);

            if ($this->isEditMode) {
                $this->payment->update($data);
                session()->flash('success', 'Platba byla aktualizována.');
            } else {
                Payment::create($data);
                session()->flash('success', 'Platba byla přidána.');
            }
        } else {
            session()->flash('failure', 'Platba nebyla přidána: dluh by byl záporný.');
        }

        return redirect()->route('employee.show', [$validated['employee']]);
    }
}
