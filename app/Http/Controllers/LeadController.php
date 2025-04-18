<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'description' => 'required',
            'plan' => 'required',
        ]);

        $plan = Str::slug($request->input('plan'));

        Lead::create($validatedData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! I will get back to you as soon as possible.'
            ]);
        }

        return redirect()->back()->with('success', 'Thank you for your message! I will get back to you as soon as possible.');
    }
}
