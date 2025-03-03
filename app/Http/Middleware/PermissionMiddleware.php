<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        // Temporary implementation - allow all permissions
        // In a real implementation, you would check if the user has the given permission
        // using your own permission system or Spatie's when it's properly installed
        
        return $next($request);
    }
}