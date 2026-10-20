<?php

namespace App\Http\Controllers;

use App\Models\RepTarget;
use App\Models\Rep;
use Illuminate\Http\Request;

class RepTargetController extends Controller
{
    public function storeOrUpdate(Request $request, Rep $rep)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
            'target_amount' => 'required|numeric|min:0',
            'achieved_amount' => 'required|numeric|min:0',
        ]);

        RepTarget::updateOrCreate(
            [
                'rep_id' => $rep->id,
                'month' => $validated['month'],
                'year' => $validated['year'],
            ],
            [
                'target_amount' => $validated['target_amount'],
                'achieved_amount' => $validated['achieved_amount'],
            ]
        );

        return back()->with('success', 'Monthly target updated successfully.');
    }
}
