<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\ContactMessage;
use App\Models\MyInfo;
use App\Models\Plan;
use App\Models\SocialLink;

class DashboardController extends Controller
{
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
    }
    
    /**
     * Get all leads for leads tab
     */
    public function getLeads(Request $request)
    {
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
                    'note' => $lead->note,
                    'ip_address' => $lead->ip_address,
                    'city' => $lead->city,
                    'region' => $lead->region,
                    'country' => $lead->country,
                    'country_code' => $lead->country_code,
                    'timezone' => $lead->timezone,
                    'latitude' => $lead->latitude,
                    'longitude' => $lead->longitude,
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
    }
    
    /**
     * Get all messages for messages tab
     */
    public function getMessages(Request $request)
    {
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
    }

    public function filterLeads(Request $request)
    {
        $query = Lead::query();

        // Apply filters
        if ($request->has('dateFrom') && $request->has('dateTo')) {
            $query->whereBetween('created_at', [$request->dateFrom, $request->dateTo]);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', strtolower($request->status));
        }

        if ($request->has('plan') && $request->plan !== '') {
            $query->where('plan', strtolower($request->plan));
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
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
                'note' => $lead->note,
                'ip_address' => $lead->ip_address,
                'city' => $lead->city,
                'region' => $lead->region,
                'country' => $lead->country,
                'country_code' => $lead->country_code,
                'timezone' => $lead->timezone,
                'latitude' => $lead->latitude,
                'longitude' => $lead->longitude,
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
    }

    public function filterMessages(Request $request)
    {
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
    }

    public function getSettings()
    {
        $myInfo = MyInfo::first();
        $plans = Plan::all();
        $socialLinks = SocialLink::all();

        return [
            'myInfo' => $myInfo,
            'plans' => $plans,
            'socialLinks' => $socialLinks
        ];
    }
}
