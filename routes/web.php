<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\MyInfoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProjectController;
use App\Models\Plan;
use App\Models\MyInfo;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    $data = Cache::remember('homepage_data', 600, function () {
        return [
            'plans' => Plan::all(),
            'myInfo' => MyInfo::first(),
            'socialLinks' => SocialLink::all(),
            'last_cached' => now()
        ];
    });

    // Check if data is stale (older than 8 mins), but not expired
    if (now()->diffInSeconds($data['last_cached']) > 480) {
        // Dispatch background cache refresh (no waiting)
        Cache::put('homepage_data_refreshing', true, 120); // prevent double refresh
        dispatch(function () {
            try {
                Cache::put('homepage_data', [
                    'plans' => Plan::all(),
                    'myInfo' => MyInfo::first(),
                    'socialLinks' => SocialLink::all(),
                    'last_cached' => now()
                ], 600);
                Cache::forget('homepage_data_refreshing');
            } catch (\Exception $e) {
                Log::error('Failed to refresh homepage_data: ' . $e->getMessage());
            }
        });
    }

    return view('welcome', [
        'plans' => $data['plans'],
        'myInfo' => $data['myInfo'],
        'socialLinks' => $data['socialLinks'],
    ]);
});

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::post('/lead', [LeadController::class, 'store'])->name('lead.store');
Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('login.store')->middleware(['guest', 'login-rate-limiter']);
Route::get('/privacy-policy', function () {
    $socialLinks = SocialLink::all();
    $myInfo = MyInfo::first();
    return view('privacy-policy', compact('socialLinks', 'myInfo'));
})->name('privacy-policy');

Route::middleware('auth')->prefix('api')->group(function() {
    Route::get('/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('api.dashboard.data');
    Route::get('/dashboard/leads', [DashboardController::class, 'getLeads'])->name('api.dashboard.leads');
    Route::get('/dashboard/messages', [DashboardController::class, 'getMessages'])->name('api.dashboard.messages');
    Route::get('/dashboard/settings', [DashboardController::class, 'getSettings'])->name('api.dashboard.settings');
    Route::get('/dashboard/leads/filter', [DashboardController::class, 'filterLeads'])->name('api.dashboard.leads.filter');
    Route::get('/dashboard/messages/filter', [DashboardController::class, 'filterMessages'])->name('api.dashboard.messages.filter');
    Route::get('/dashboard/projects/filter', [DashboardController::class, 'filterProjects'])->name('api.dashboard.projects.filter');
    Route::get('/dashboard/projects', [DashboardController::class, 'getProjects'])->name('api.dashboard.projects');

    Route::post('/messages/{message}/status', [ContactMessageController::class, 'updateMessageStatus'])->name('api.dashboard.messages.update');
    Route::delete('/messages/{message}', [ContactMessageController::class, 'deleteMessage'])->name('api.dashboard.messages.delete');

    Route::put('/dashboard/leads/{lead}', [LeadController::class, 'updateLead'])->name('api.dashboard.leads.update');
    Route::delete('/leads/{lead}', [LeadController::class, 'deleteLead'])->name('api.dashboard.leads.delete');
    
    Route::put('/social-links/{socialLink}/toggle-status', [SocialLinkController::class, 'toggleStatus']);
    Route::put('/social-links/{socialLink}', [SocialLinkController::class, 'update']);
    Route::delete('/social-links/{socialLink}', [SocialLinkController::class, 'destroy']);
    Route::post('/social-links', [SocialLinkController::class, 'store']);

    Route::put('/plans/{plan}/toggle-status', [PlanController::class, 'toggleStatus']);
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy']);
    Route::put('/plans/{plan}', [PlanController::class, 'update']);
    Route::post('/plans', [PlanController::class, 'store']);

    Route::put('/my-info/{myInfo}', [MyInfoController::class, 'update']);
    
    Route::put('/update-password', [SessionController::class, 'updatePassword']);
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
});

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::middleware('auth')->group(function() {
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects/create', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::get('/projects/{project}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.forceDelete');
    Route::get('/projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::get('/projects/trashed', [ProjectController::class, 'trashedProjects'])->name('projects.trashed');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Add a route for the API to get projects without authentication
Route::prefix('api')->group(function() {
    Route::get('/projects', [ProjectController::class, 'index'])->name('api.projects');
});