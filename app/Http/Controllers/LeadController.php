<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Controllers\DashboardController;

class LeadController extends Controller
{
    private $dashboardController;

    public function __construct(DashboardController $dashboardController)
    {
        $this->dashboardController = $dashboardController;
    }
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
        ]);

        // Normalize plan name
        $validatedData['plan'] = Str::slug($request->input('plan'));

        // Ensure we're using the correct field name for the message
        if ($request->has('details') && !$request->has('message')) {
            $validatedData['message'] = $request->input('details');
        }

        DB::beginTransaction();
        try {
            $lead = Lead::create($validatedData);
            DB::commit();

            // Clear relevant caches
            $this->clearLeadCaches();

            $response = [
                'success' => true,
                'message' => 'Thank you for your message! I will get back to you as soon as possible.'
            ];
            $this->dashboardController->clearCache();

            return $request->expectsJson() 
                ? response()->json($response)
                : redirect()->back()->with('success', $response['message']);
        } catch (\Exception $e) {
            DB::rollBack();
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
            'note' => ['nullable', 'string', 'max:5000'],
        ]);

        // Normalize plan name
        $validatedData['plan'] = Str::slug($request->input('plan'));

        DB::beginTransaction();
        try {
            $lead->update($validatedData);
            DB::commit();

            // Clear relevant caches
            $this->clearLeadCaches();
            $this->dashboardController->clearCache();

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

            // Clear relevant caches
            $this->clearLeadCaches();
            $this->dashboardController->clearCache();

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

    /**
     * Clear all lead-related caches.
     *
     * @return void
     */
    private function clearLeadCaches()
    {
        // Clear specific cache keys instead of using tags
        Cache::forget('dashboard_data');
        Cache::forget('leads_count');
        
        // Clear paginated leads caches
        $cacheKeys = Cache::get('lead_cache_keys', []);
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }
}
