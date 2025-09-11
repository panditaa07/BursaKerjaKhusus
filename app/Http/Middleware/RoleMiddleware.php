<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $user->role->name ?? null;

        // support multi-role: role1|role2
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode('|', $role));
        }

        if (!in_array($userRole, $allowedRoles)) {
            // Instead of redirecting, abort with 403 Unauthorized
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }

    private function getDashboardRoute($role)
    {
        if ($role === 'admin') {
            return 'admin.dashboard.index';
        } elseif ($role === 'company') {
            return 'company.dashboard.index';
        } elseif ($role === 'user') {
            return 'user.dashboard.index';
        } else {
            return null;
        }
    }
}
