<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized Access - no user logged in');
        }

        // Normalize role and allowed roles to uppercase for case-insensitive check
        $userRole = strtoupper($user->role);
        $allowedRoles = array_map('strtoupper', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized Access - role not allowed');
        }

        return $next($request);
    }
}
