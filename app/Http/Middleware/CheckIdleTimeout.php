<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckIdleTimeout
{
    private const IDLE_TIMEOUT_MINUTES = 30;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $lastActivity = Session::get('last_activity');
        $currentTime = time();

        // Initialize last activity if not set
        if (!$lastActivity) {
            Session::put('last_activity', $currentTime);
            return $next($request);
        }

        // Check if user has been idle for more than the timeout period
        $idleMinutes = ($currentTime - $lastActivity) / 60;
        
        if ($idleMinutes > self::IDLE_TIMEOUT_MINUTES) {
            return $this->handleTimeout($request);
        }

        // Update last activity time
        Session::put('last_activity', $currentTime);
        
        return $next($request);
    }

    /**
     * Handle session timeout.
     */
    private function handleTimeout(Request $request)
    {
        Auth::logout();
        Session::flush();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'timeout',
                'message' => 'Your session has expired due to inactivity. Please login again.',
                'redirect' => route('login')
            ], 401);
        }

        return redirect()->route('login')
            ->with('message', 'Your session has expired due to inactivity. Please login again.')
            ->with('alert-type', 'warning');
    }
}
