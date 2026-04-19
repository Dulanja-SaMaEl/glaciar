<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'priority' => 'nullable|in:Low,Medium,High',
        ]);

        try {
            $rep = $request->user()->rep;
            if (!$rep) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $complaint = Complaint::create([
                'customer_id' => $validatedData['customer_id'],
                'rep_id' => $rep->id,
                'description' => $validatedData['description'],
                'category' => $validatedData['category'],
                'priority' => $validatedData['priority'] ?? 'Low',
                'status' => 'Open',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Issue logged successfully from field',
                'data' => $complaint
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
