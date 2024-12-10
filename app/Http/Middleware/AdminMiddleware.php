<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Extremely verbose logging
        $user = Auth::user();
        
        // Log EVERYTHING for debugging
        Log::channel('single')->emergency('ADMIN MIDDLEWARE TRIGGERED', [
            'is_authenticated' => Auth::check(),
            'user_exists' => $user !== null,
            'user_id' => $user ? $user->id : 'NO USER',
            'user_email' => $user ? $user->email : 'NO USER',
            'is_admin_column' => $user ? $user->is_admin : 'NO USER',
            'is_admin_method_exists' => $user && method_exists($user, 'isAdmin'),
            'is_admin_method_result' => $user && method_exists($user, 'isAdmin') ? $user->isAdmin() : 'METHOD NOT EXISTS',
            'request_path' => $request->path(),
            'request_url' => $request->fullUrl(),
        ]);

        // Multiple checks to ensure admin access
        if (!Auth::check()) {
            Log::channel('single')->warning('Unauthenticated access attempt');
            return redirect('/')->with('error', 'Please log in');
        }

        // Check is_admin column directly
        if (!$user->is_admin) {
            Log::channel('single')->warning('Non-admin user access attempt', [
                'user_id' => $user->id,
                'user_email' => $user->email
            ]);
            return redirect('/')->with('error', 'Admin access required');
        }

        return $next($request);
    }
}
