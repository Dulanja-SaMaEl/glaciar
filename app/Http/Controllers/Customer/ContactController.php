<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Show the concierge contact interface.
     */
    public function index()
    {
        return view('customer.contact');
    }

    /**
     * Store and log a client inquiry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:150',
            'format_interest' => 'nullable|string|max:100',
            'message' => 'required|string|max:3000',
        ]);

        // Log the inquiry for dispatch telemetry
        Log::info('GLACIAR Concierge Inquiry Received', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'timestamp' => now()->toIso8601String(),
        ]);

        return redirect()->route('contact')->with(
            'success',
            'Inquiry received. A Glaciar Concierge specialist has been dispatched to review your request within 4 business hours.'
        );
    }
}
