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
                $user = Auth::guard($guard)->user();
                $roleName = $this->resolveRoleName($user);

                if (in_array($roleName, ['admin', 'company', 'user'])) {
                    $request->session()->forget('url.intended');
                    $targetRoute = RouteServiceProvider::dashboardRouteForRole($roleName);
                    
                    if ($targetRoute !== 'login') {
                        return redirect()->route($targetRoute);
                    }
                }

                // Jika role tidak dikenali padahal sudah login, jangan paksa logout di sini 
                // karena bisa menyebabkan loop jika dipanggil dari login page.
                // Cukup biarkan lanjut atau arahkan ke home.
                return $next($request);
            }
        }

        return $next($request);
    }

    private function resolveRoleName($user)
    {
        if (!$user) return null;
        
        // Pastikan relasi role dimuat
        if (!$user->relationLoaded('role') && isset($user->role_id)) {
            $user->load('role');
        }

        if (isset($user->role->name)) return $user->role->name;
        
        if (is_string($user->role) && in_array($user->role, ['admin', 'company', 'user'])) return $user->role;
        
        if (isset($user->role_id)) {
            $r = Role::find($user->role_id);
            return $r ? $r->name : null;
        }
        
        return null;
    }
}