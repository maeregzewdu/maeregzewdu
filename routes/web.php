<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::post('/lead', [LeadController::class, 'store'])->name('lead.store');
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
Route::post('/user-info/update', [UserController::class, 'update'])->name('user-info.update');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Dashboard API Routes
Route::middleware('auth')->group(function() {
    Route::get('/api/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('api.dashboard.data');
    Route::get('/api/dashboard/leads', [DashboardController::class, 'getLeads'])->name('api.dashboard.leads');
    Route::get('/api/dashboard/messages', [DashboardController::class, 'getMessages'])->name('api.dashboard.messages');
});