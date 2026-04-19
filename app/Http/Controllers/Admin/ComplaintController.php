<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['customer', 'rep', 'assignee']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else {
            // Default to showing un-resolved if no status specified
            $query->whereNotIn('status', ['Resolved', 'Closed']);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(15);
        $complaints->appends($request->all());

        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['customer', 'rep', 'assignee']);

        return view('admin.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
            'resolution' => 'nullable|string|max:5000',
        ]);

        $complaint->update([
            'status' => $request->status,
            'resolution' => $request->resolution,
        ]);

        return redirect()->back()->with('success', 'Complaint updated.');
    }
}
