<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        ContactMessage::create($validatedData);

        // Return JSON response if request expects JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Thank you for your message! I will get back to you as soon as possible.'
            ]);
        }

        // Return redirect with flash message for traditional form submissions
        return redirect()->back()->with('success', 'Thank you for your message! I will get back to you as soon as possible.');
    }
    
}
