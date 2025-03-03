<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleOrPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roleOrPermission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roleOrPermission)
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        // Temporary implementation - allow all roles/permissions
        // In a real implementation, you would check if the user has any of the given roles or permissions
        // using your own permission system or Spatie's when it's properly installed
        
        return $next($request);
    }
}