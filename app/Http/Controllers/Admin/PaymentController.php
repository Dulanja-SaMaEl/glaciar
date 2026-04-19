<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->with(['order.customer'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', [
            'payments' => $payments,
        ]);
    }

    public function verify(Payment $payment): RedirectResponse
    {
        $payment->update([
            'status' => 'verified',
            'verified_at' => Carbon::now(),
        ]);

        return back()->with('status', 'Payment verified.');
    }
}

