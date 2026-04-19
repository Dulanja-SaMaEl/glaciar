<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rep;
use Illuminate\Http\Request;

class RepController extends Controller
{
    public function index()
    {
        $reps = Rep::with(['zone'])->get();

        return view('admin.reps.index', compact('reps'));
    }

    public function show(Rep $rep)
    {
        $rep->load(['zone', 'attendance' => function($q) {
            $q->orderBy('date', 'desc')->take(7);
        }]);

        // We could calculate actual metrics here, but we'll use placeholder logic matching the view for now
        
        return view('admin.reps.show', compact('rep'));
    }
}
