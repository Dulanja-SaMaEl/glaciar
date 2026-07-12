<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Admin;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['customer', 'rep', 'assignee']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('customer', fn($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else {
            // Default to showing un-resolved if no status specified
            $query->whereNotIn('status', ['Resolved', 'Closed']);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'unassigned' => Complaint::whereNull('assigned_to')->whereNotIn('status', ['Resolved', 'Closed'])->count(),
            'in_progress' => Complaint::where('status', 'In Progress')->count(),
            'total_open' => Complaint::whereIn('status', ['Open', 'In Progress'])->count(),
            'resolved_today' => Complaint::where('status', 'Resolved')->whereDate('updated_at', today())->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'stats'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['customer', 'rep', 'assignee']);
        $admins = Admin::all();

        return view('admin.complaints.show', compact('complaint', 'admins'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'assigned_to' => 'nullable|exists:admins,id',
            'resolution' => 'nullable|string|max:5000',
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $complaint->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'resolution' => $request->resolution,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Complaint updated successfully.');
    }
}
