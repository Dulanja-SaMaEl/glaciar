<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rep;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RepController extends Controller
{
    public function index()
    {
        $reps = Rep::with(['zone'])->get();

        return view('admin.reps.index', compact('reps'));
    }

    public function create()
    {
        $zones = Zone::all();
        return view('admin.reps.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'required|string|max:255|unique:reps',
            'email' => 'required|string|email|max:255|unique:reps',
            'phone' => 'nullable|string|max:20',
            'zone_id' => 'nullable|exists:zones,id',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Rep::create($validated);

        return redirect()->route('admin.reps.index')->with('success', 'Sales Representative created successfully.');
    }

    public function show(Rep $rep)
    {
        $rep->load(['zone', 'targets' => function($q) {
            $q->orderBy('year', 'desc')->orderBy('month', 'desc');
        }, 'attendance' => function($q) {
            $q->orderBy('date', 'desc')->take(7);
        }]);

        // We could calculate actual metrics here, but we'll use placeholder logic matching the view for now
        
        return view('admin.reps.show', compact('rep'));
    }

    public function edit(Rep $rep)
    {
        $zones = Zone::all();
        return view('admin.reps.edit', compact('rep', 'zones'));
    }

    public function update(Request $request, Rep $rep)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => ['required', 'string', 'max:255', Rule::unique('reps')->ignore($rep->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('reps')->ignore($rep->id)],
            'phone' => 'nullable|string|max:20',
            'zone_id' => 'nullable|exists:zones,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $rep->update($validated);

        return redirect()->route('admin.reps.index')->with('success', 'Sales Representative updated successfully.');
    }

    public function destroy(Rep $rep)
    {
        $rep->delete();
        return redirect()->route('admin.reps.index')->with('success', 'Sales Representative deleted successfully.');
    }
}
