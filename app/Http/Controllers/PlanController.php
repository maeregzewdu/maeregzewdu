<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function toggleStatus(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $plan->update(['status' => $validated['status']]);
        return response()->json(['success' => true]);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json(['success' => true, 'message' => 'Plan deleted successfully']);
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'required|array',
            'status' => 'required|string|max:255',
            'is_popular' => 'required|boolean',
        ]);

        $plan->update($validated);
        return response()->json(['plan' => $plan]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'required|array',
            'status' => 'required|string|max:255',
            'is_popular' => 'required|boolean',
        ]);

        $plan = Plan::create($validated);
        return response()->json(['success' => true, 'plan' => $plan]);
    }
}
