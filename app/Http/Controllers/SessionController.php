<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($validatedData, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Clear login attempts on successful login
            Cache::forget('login_attempts_' . $request->ip());

            return $request->expectsJson()
                ? response()->json(['success' => true, 'message' => 'Logged in successfully'])
                : redirect()->intended('/dashboard');
        }

        // Increment login attempts
        $attempts = Auth::attempts() + 1;
        Cache::put('login_attempts_' . $request->ip(), $attempts, now()->addMinutes(1));

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        // Clear any user-specific caches
        if ($user = Auth::user()) {
            Cache::forget('dashboard_data_' . $user->id);
            Cache::forget('leads_' . $user->id);
            Cache::forget('filtered_leads_' . $user->id);
            Cache::forget('plans_' . $user->id);
            Cache::forget('my_info_' . $user->id);
            Cache::forget('social_links_' . $user->id);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Logged out successfully'])
            : redirect()->route('login')->with('success', 'Logged out successfully');
    }
    
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        try {
            $user->update($validatedData);

            return $request->expectsJson()
                ? response()->json(['success' => true, 'message' => 'Profile updated successfully'])
                : redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Failed to update profile'], 500)
                : redirect()->back()->with('error', 'Failed to update profile');
        }
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($validatedData['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        try {
            $user->update([
                'password' => Hash::make($validatedData['new_password'])
            ]);

            // Clear any user-specific caches
            Cache::tags(['user_' . $user->id])->flush();

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update password'
            ], 500);
        }
    }
}
