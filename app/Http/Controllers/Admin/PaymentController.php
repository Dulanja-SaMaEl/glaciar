<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Payment::query()->with(['order.customer'])->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $numericId = preg_replace('/[^0-9]/', '', $search);
            $query->where(function ($q) use ($search, $numericId) {
                if (!empty($numericId)) {
                    $q->orWhere('id', (int) $numericId)
                      ->orWhere('order_id', (int) $numericId);
                }
                $q->orWhere('method', 'like', "%{$search}%")
                  ->orWhereHas('order.customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->paginate(20)->withQueryString();

        $metrics = [
            'total_volume' => Payment::where('status', 'verified')->sum('amount'),
            'verified_count' => Payment::where('status', 'verified')->count(),
            'pending_count' => Payment::where('status', '!=', 'verified')->count(),
            'all_count' => Payment::count(),
        ];

        return view('admin.payments.index', [
            'payments' => $payments,
            'metrics' => $metrics,
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

