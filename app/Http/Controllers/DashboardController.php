<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\ContactMessage;

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
        
        return response()->json([
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
        ]);
    }
    
    /**
     * Get all leads for leads tab
     */
    public function getLeads()
    {
        $leads = Lead::orderBy('created_at', 'desc')
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
            
        return response()->json([
            'leads' => $leads
        ]);
    }
    
    /**
     * Get all messages for messages tab
     */
    public function getMessages()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')
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
            
        return response()->json([
            'messages' => $messages
        ]);
    }
}
