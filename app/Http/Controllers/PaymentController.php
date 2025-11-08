<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(Request $request): View
    {
        $preselectedEmployee = $request->get('employee');

        return view('components.payments.create', [
            'preselectedEmployee' => $preselectedEmployee,
        ]);
    }

    public function edit(Payment $payment): View
    {
        return view('components.payments.edit', [
            'paymentId' => $payment->id,
        ]);
    }
}
