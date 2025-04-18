<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\LeadController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::post('/lead', [LeadController::class, 'store'])->name('lead.store');