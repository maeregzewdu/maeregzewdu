<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\ContactMessage;
use App\Models\MyInfo;
use App\Models\Plan;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    // Cache duration in seconds (5 minutes)
    protected $cacheDuration = 300;
    
    public function index()
    {
        $leads = Lead::all();
        $contacts = ContactMessage::all();

        $leadCount = $leads->count();
        $contactCount = $contacts->count();

        return view('auth.dashboard', compact('leadCount', 'contactCount', 'leads', 'contacts'));
    }
    
    /**
     * Get dashboard general data (stats and recent items)
     */
    public function getDashboardData()
    {
        // Try to get data from cache first
        return Cache::remember('dashboard_data', $this->cacheDuration, function () {
            // Get counts
            $leadCount = Lead::count();
            $contactCount = ContactMessage::count();
            
            // Get recent leads (5 most recent)
            $recentLeads = Lead::orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function($lead) {
                    return [
                        'id' => $lead->id,
                        'name' => $lead->name,
                        'email' => $lead->email,
                        'phone' => $lead->phone,
                        'plan' => $lead->plan,
                        'message' => $lead->message,
                        'status' => $lead->status ?? 'new',
                        'created_at' => $lead->created_at->diffForHumans()
                    ];
                });
                
            // Get recent messages (5 most recent)
            $recentMessages = ContactMessage::orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function($message) {
                    return [
                        'id' => $message->id,
                        'name' => $message->name,
                        'email' => $message->email,
                        'phone' => $message->phone,
                        'subject' => $message->subject,
                        'message' => $message->message,
                        'status' => $message->status ?? 'unread',
                        'created_at' => $message->created_at->diffForHumans()
                    ];
                });
                
            // Calculate stats
            $newLeadsCount = Lead::where('created_at', '>=', now()->subDays(30))->count();
            $lastMonthLeadsCount = Lead::where('created_at', '>=', now()->subDays(60))
                                        ->where('created_at', '<', now()->subDays(30))
                                        ->count();
                                        
            $leadIncrease = $lastMonthLeadsCount > 0 
                            ? round((($newLeadsCount - $lastMonthLeadsCount) / $lastMonthLeadsCount) * 100)
                            : 0;

            $newMessagesCount = ContactMessage::where('created_at', '>=', now()->subDays(30))->count();
            $lastMonthMessagesCount = ContactMessage::where('created_at', '>=', now()->subDays(60))
                                                  ->where('created_at', '<', now()->subDays(30))
                                                  ->count();
                                                  
            $messageIncrease = $lastMonthMessagesCount > 0 
                            ? round((($newMessagesCount - $lastMonthMessagesCount) / $lastMonthMessagesCount) * 100)
                            : 0;
            
            // Sample active projects and revenue (replace with real data in production)
            $activeProjects = 7;
            $projectIncrease = 15;
            $revenue = 45000;
            $revenueIncrease = 18;
            
            return [
                'leadCount' => $leadCount,
                'contactCount' => $contactCount,
                'recentLeads' => $recentLeads,
                'recentMessages' => $recentMessages,
                'stats' => [
                    'leadIncrease' => $leadIncrease,
                    'messageIncrease' => $messageIncrease,
                    'activeProjects' => $activeProjects,
                    'projectIncrease' => $projectIncrease,
                    'revenue' => $revenue,
                    'revenueIncrease' => $revenueIncrease,
                ]
            ];
        });
    }
    
    /**
     * Get all leads for leads tab
     */
    public function getLeads(Request $request)
    {
        // Generate a unique cache key based on the request parameters
        $cacheKey = 'leads_' . md5(json_encode([
            'search' => $request->search,
            'page' => $request->input('page', 1),
            'per_page' => $request->input('per_page', 6)
        ]));
        
        // Store the cache key for later clearing
        $cacheKeys = Cache::get('lead_cache_keys', []);
        if (!in_array($cacheKey, $cacheKeys)) {
            $cacheKeys[] = $cacheKey;
            Cache::put('lead_cache_keys', $cacheKeys, now()->addDays(1));
        }
        
        // Try to get data from cache first
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($request) {
            $query = Lead::orderBy('created_at', 'desc');
            
            // Apply search if search parameter is provided
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%")
                      ->orWhere('phone', 'like', "%{$searchTerm}%")
                      ->orWhere('message', 'like', "%{$searchTerm}%")
                      ->orWhere('status', 'like', "%{$searchTerm}%")
                      ->orWhere('plan', 'like', "%{$searchTerm}%");
                });
            }
            
            // Get pagination parameters
            $perPage = $request->input('per_page', 6);
            $page = $request->input('page', 1);
            
            // Get paginated results
            $paginatedLeads = $query->paginate($perPage, ['*'], 'page', $page);
            
            // Transform the data
            $leads = $paginatedLeads->map(function($lead) {
                    return [
                        'id' => $lead->id,
                        'name' => $lead->name,
                        'email' => $lead->email,
                        'phone' => $lead->phone,
                        'plan' => $lead->plan,
                        'message' => $lead->message,
                    'status' => $lead->status,
                    'source' => $lead->source,
                        'created_at' => $lead->created_at->diffForHumans()
                    ];
                });
                
            return [
                'leads' => $leads,
                'pagination' => [
                    'current_page' => $paginatedLeads->currentPage(),
                    'last_page' => $paginatedLeads->lastPage(),
                    'per_page' => $paginatedLeads->perPage(),
                    'total' => $paginatedLeads->total()
                ]
            ];
        });
    }
    
    /**
     * Get all messages for messages tab
     */
    public function getMessages(Request $request)
    {
        // Generate a unique cache key based on the request parameters
        $cacheKey = 'messages_' . md5(json_encode([
            'search' => $request->search,
            'page' => $request->input('page', 1),
            'per_page' => $request->input('per_page', 6)
        ]));
        
        // Try to get data from cache first
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($request) {
            $query = ContactMessage::orderBy('created_at', 'desc')->where('status', '!=', 'deleted');
            
            // Apply search if search parameter is provided
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('email', 'like', "%{$searchTerm}%")
                      ->orWhere('phone', 'like', "%{$searchTerm}%")
                      ->orWhere('subject', 'like', "%{$searchTerm}%")
                      ->orWhere('message', 'like', "%{$searchTerm}%");
                });
            }
            
            // Get pagination parameters
            $perPage = $request->input('per_page', 6);
            $page = $request->input('page', 1);
            
            // Get paginated results
            $paginatedMessages = $query->paginate($perPage, ['*'], 'page', $page);
            
            // Transform the data
            $messages = $paginatedMessages->map(function($message) {
                    return [
                        'id' => $message->id,
                        'name' => $message->name,
                        'email' => $message->email,
                        'phone' => $message->phone,
                        'subject' => $message->subject,
                        'message' => $message->message,
                    'status' => $message->status,
                        'created_at' => $message->created_at->diffForHumans()
                    ];
                });
                
            return [
                'messages' => $messages,
                'pagination' => [
                    'current_page' => $paginatedMessages->currentPage(),
                    'last_page' => $paginatedMessages->lastPage(),
                    'per_page' => $paginatedMessages->perPage(),
                    'total' => $paginatedMessages->total()
                ]
            ];
        });
    }

    public function filterLeads(Request $request)
    {
        // Generate a unique cache key based on the filter parameters
        $cacheKey = 'filtered_leads_' . md5(json_encode([
            'dateFrom' => $request->dateFrom,
            'dateTo' => $request->dateTo,
            'status' => $request->status,
            'plan' => $request->plan,
            'search' => $request->search,
            'page' => $request->input('page', 1),
            'per_page' => $request->input('per_page', 6)
        ]));
        
        // Store the cache key for later clearing
        $cacheKeys = Cache::get('lead_cache_keys', []);
        if (!in_array($cacheKey, $cacheKeys)) {
            $cacheKeys[] = $cacheKey;
            Cache::put('lead_cache_keys', $cacheKeys, now()->addDays(1));
        }
        
        // Try to get data from cache first
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($request) {
            $query = Lead::query();

            // Apply filters
            if ($request->has('dateFrom') && $request->has('dateTo')) {
                $query->whereBetween('created_at', [$request->dateFrom, $request->dateTo]);
            }

            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            if ($request->has('plan') && $request->plan !== '') {
                $query->where('plan', ucfirst($request->plan));
            }

            if ($request->has('search') && $request->search !== '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // Get paginated results
            $perPage = $request->input('per_page', 6);
            $paginatedLeads = $query->paginate($perPage);

            $leads = $paginatedLeads->map(function($lead) {
                return [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'plan' => $lead->plan,
                    'message' => $lead->message,
                    'status' => $lead->status,
                    'source' => $lead->source,
                    'created_at' => $lead->created_at->diffForHumans()
                ];
            });

            return [
                'leads' => $leads,
                'pagination' => [
                    'current_page' => $paginatedLeads->currentPage(),
                    'last_page' => $paginatedLeads->lastPage(),
                    'per_page' => $paginatedLeads->perPage(),
                    'total' => $paginatedLeads->total()
                ]
            ];
        });
    }

    public function filterMessages(Request $request)
    {
        // Generate a unique cache key based on the filter parameters
        $cacheKey = 'filtered_messages_' . md5(json_encode([
            'dateFrom' => $request->dateFrom,
            'dateTo' => $request->dateTo,
            'status' => $request->status,
            'search' => $request->search,
            'page' => $request->input('page', 1),
            'per_page' => $request->input('per_page', 6)
        ]));
        
        // Try to get data from cache first
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($request) {
            $query = ContactMessage::query();

            // Apply filters
            if ($request->has('dateFrom') && $request->has('dateTo')) {
                $query->whereBetween('created_at', [$request->dateFrom, $request->dateTo]);
            }

            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', strtolower($request->status));
            }

            if ($request->has('search') && $request->search !== '') {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
                });
            }

            // Get paginated results
            $perPage = $request->input('per_page', 6);
            $paginatedMessages = $query->orderBy('created_at', 'desc')->paginate($perPage);

            $messages = $paginatedMessages->map(function($message) {
                return [
                    'id' => $message->id,
                    'name' => $message->name,
                    'email' => $message->email,
                    'phone' => $message->phone,
                    'subject' => $message->subject,
                    'message' => $message->message,
                    'status' => $message->status,
                    'created_at' => $message->created_at->diffForHumans()
                ];
            });

            return [
                'messages' => $messages,
                'pagination' => [
                    'current_page' => $paginatedMessages->currentPage(),
                    'last_page' => $paginatedMessages->lastPage(),
                    'per_page' => $paginatedMessages->perPage(),
                    'total' => $paginatedMessages->total()
                ]
            ];
        });
    }

    public function getSettings()
    {
        // Try to get data from cache first
        return Cache::remember('settings_data', $this->cacheDuration, function () {
            $myInfo = MyInfo::first();
            $plans = Plan::all();
            $socialLinks = SocialLink::all();

            return [
                'myInfo' => $myInfo,
                'plans' => $plans,
                'socialLinks' => $socialLinks
            ];
        });
    }
    
    /**
     * Clear all dashboard-related caches
     * This can be called when data is updated to ensure fresh data is shown
     */
    public function clearCache()
    {
        Cache::forget('dashboard_data');
        Cache::forget('settings_data');
        
        // Clear paginated data caches (this is a bit more aggressive)
        // In a production environment, you might want to be more selective
        $keys = Cache::get('dashboard_cache_keys', []);
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        return response()->json(['message' => 'Cache cleared successfully']);
    }
    
    /**
     * Store a cache key for later clearing
     * This helps track all the cache keys we've created
     */
    protected function storeCacheKey($key)
    {
        $keys = Cache::get('dashboard_cache_keys', []);
        if (!in_array($key, $keys)) {
            $keys[] = $key;
            Cache::put('dashboard_cache_keys', $keys, 60 * 60 * 24); // Store for 24 hours
        }
    }
}
