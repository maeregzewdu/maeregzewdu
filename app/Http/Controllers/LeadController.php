<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
class LeadController extends Controller
{
    /**
     * Store a new lead.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:5000'],
            'plan' => ['required', 'string', 'max:255'],
            'ip_address' => ['nullable', 'ip'],
            'location' => ['nullable', 'array'],
            'location.city' => ['nullable', 'string', 'max:255'],
            'location.region' => ['nullable', 'string', 'max:255'],
            'location.country' => ['nullable', 'string', 'max:255'],
            'location.country_code' => ['nullable', 'string', 'size:2'],
            'location.timezone' => ['nullable', 'string', 'max:255'],
            'location.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'location.longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        // Normalize plan name
        $validatedData['plan'] = strtolower($request->input('plan'));

        // Ensure we're using the correct field name for the message
        if ($request->has('details') && !$request->has('message')) {
            $validatedData['message'] = $request->input('details');
        }

        // Extract and merge location data
        if ($request->has('location')) {
            $location = $request->input('location');
            $validatedData = array_merge($validatedData, [
                'city'         => $location['city'] ?? null,
                'region'       => $location['region'] ?? null,
                'country'      => $location['country'] ?? null,
                'country_code' => $location['country_code'] ?? null,
                'timezone'     => $location['timezone'] ?? null,
                'latitude'     => $location['latitude'] ?? null,
                'longitude'    => $location['longitude'] ?? null,
            ]);
        }

        unset($validatedData['location']);

        Log::info($validatedData);

        DB::beginTransaction();
        try {
            $lead = Lead::create($validatedData);
            DB::commit();

            $response = [
                'success' => true,
                'message' => 'Thank you for your message! I will get back to you as soon as possible.'
            ];

            return $request->expectsJson() 
                ? response()->json($response)
                : redirect()->back()->with('success', $response['message']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to save lead.'], 500)
                : redirect()->back()->with('error', 'Failed to save lead.');
        }
    }

    /**
     * Update an existing lead.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLead(Request $request, Lead $lead)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'message' => ['required', 'string', 'max:5000'],
            'plan' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['new', 'contacted', 'qualified', 'converted', 'rejected', 'lost'])],
            'source' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'ip'],
            'city' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'country_code' => ['nullable', 'string', 'size:2'],
            'timezone' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'note' => ['nullable', 'string', 'max:5000'],
        ]);

        // Normalize plan name
        $validatedData['plan'] = Str::slug($request->input('plan'));

        DB::beginTransaction();
        try {
            $lead->update($validatedData);
            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Lead updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update lead'
            ], 500);
        }
    }

    /**
     * Delete a lead.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteLead(Lead $lead)
    {
        DB::beginTransaction();
        try {
            $lead->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lead deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete lead'
            ], 500);
        }
    }
}
