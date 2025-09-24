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

        // Load role relationship if not already loaded
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        // Debug logging
        \Log::info('RoleMiddleware Debug', [
            'user_id' => $user->id,
            'user_role_id' => $user->role_id,
            'user_role_name' => $user->role->name ?? null,
            'required_roles' => $roles,
            'request_path' => $request->path()
        ]);

        $userRole = $user->role->name ?? null;

        // support multi-role: role1|role2
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode('|', $role));
        }

        if (!in_array($userRole, $allowedRoles)) {
            \Log::warning('RoleMiddleware: User role not allowed', [
                'user_id' => $user->id,
                'user_role' => $userRole,
                'allowed_roles' => $allowedRoles
            ]);
            abort(403, 'Unauthorized access - Role not allowed');
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
