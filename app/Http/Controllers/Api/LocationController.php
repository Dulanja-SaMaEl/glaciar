<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RepLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            $rep = $request->user()->rep;
            if (!$rep) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $rep_id = $rep->id;

            // This usually happens frequently (e.g., every 5 minutes in background)
            // We can keep a history or just update the latest, depending on exact needs.
            // For Glaciar, we keep a history to show routing efficiency, but typically
            // just the last few records are kept. Here we store a new point.
            
            // To prevent massive DB bloat, older records might be purged nightly in a real app.
            $location = RepLocation::create([
                'rep_id' => $rep_id,
                'lat' => $validatedData['latitude'],
                'lng' => $validatedData['longitude'],
                'recorded_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Location updated',
                // 'data' => $location // Optional to return to save bandwidth
            ]);

        } catch (\Exception $e) {
             return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
