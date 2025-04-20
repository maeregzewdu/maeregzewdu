<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LoginRateLimiter
{
    protected $limiter;
    protected $maxAttempts = 5;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = Str::lower($request->input('email')).'|'.$request->ip();
        $remainingAttempts = $this->limiter->remaining($key, $this->maxAttempts);

        if ($this->limiter->tooManyAttempts($key, $this->maxAttempts)) {
            $seconds = $this->limiter->availableIn($key);
            $minutes = ceil($seconds / 60);
            
            return back()->withErrors([
                'login_attempts' => 'Too many login attempts. Please try again in ' . 
                    ($minutes > 60 ? floor($minutes / 60) . ' hour' : $minutes . ' minutes')
            ])->withInput($request->except('password'));
        }

        $response = $next($request);

        // Check if login was successful by checking if we're redirecting to any of our success routes
        $successRoutes = ['/', '/superAdminDashboard', '/admin/dashboard', '/webAdmin/dashboard'];
        $redirectTo = $response->headers->get('Location');
        
        if ($response->getStatusCode() === 302 && in_array($redirectTo, $successRoutes)) {
            // Successful login, clear the rate limiter
            $this->limiter->clear($key);
        } else {
            // Failed login attempt - lock for 1 hour (3600 seconds)
            $this->limiter->hit($key, 3600);
            
            // Calculate remaining attempts after the hit
            $remainingAttempts = $this->limiter->remaining($key, $this->maxAttempts);
            
            // Override the original error message if we have attempts remaining
            if ($remainingAttempts > 0) {
                return back()->withErrors([
                    'attempts_remaining' => "Invalid credentials. You have {$remainingAttempts} login " . 
                        ($remainingAttempts === 1 ? 'attempt' : 'attempts') . " remaining."
                ])->withInput($request->except('password'));
            } else {
                // Last attempt was just used
                return back()->withErrors([
                    'login_attempts' => 'Account locked. Please try again in 60 minutes.'
                ])->withInput($request->except('password'));
            }
        }

        return $response;
    }
}