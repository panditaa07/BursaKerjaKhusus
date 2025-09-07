<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Role-based redirection
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard.index');
                } elseif ($user->role === 'company') {
                    return redirect()->route('company.dashboard.index');
                } elseif (in_array($user->role, ['user', 'student', 'alumni'])) {
                    return redirect()->route('user.dashboard.index');
                } else {
                    return redirect()->route('user.dashboard.index');
                }
            }
        }

        return $next($request);
    }
}