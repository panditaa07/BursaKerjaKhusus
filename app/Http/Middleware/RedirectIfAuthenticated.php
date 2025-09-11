<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\Role;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                $roleName = $this->resolveRoleName($user);

                if (in_array($roleName, ['admin', 'company', 'user'])) {
                    $request->session()->forget('url.intended');
                    return redirect()->route(RouteServiceProvider::dashboardRouteForRole($roleName));
                }

                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')->withErrors(['role' => 'Unknown role']);
            }
        }

        return $next($request);
    }

    private function resolveRoleName($user)
    {
        if (!$user) return null;
        if (is_string($user->role) && in_array($user->role, ['admin', 'company', 'user'])) return $user->role;
        if (isset($user->role->name)) return $user->role->name;
        if (isset($user->role_id)) {
            $r = Role::find($user->role_id);
            return $r ? $r->name : null;
        }
        return null;
    }
}