<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Pastikan role dimuat
        $user->loadMissing('role');
        $roleName = $user->role->name ?? null;

        $targetRoute = \App\Providers\RouteServiceProvider::dashboardRouteForRole($roleName);

        \Log::info('Login Success', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $roleName,
            'target_route' => $targetRoute
        ]);

        if ($targetRoute === 'login') {
             \Log::warning('Login Redirect Fallback to Login', [
                'user_id' => $user->id,
                'role' => $roleName
            ]);
            // Jika role tidak dikenal, logout dan kembalikan ke login dengan error
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Role user tidak dikenali atau tidak memiliki akses dashboard.']);
        }

        return redirect()->route($targetRoute);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            if ($user->status === 'pending') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda sedang menunggu persetujuan admin.',
                ]);
            }
    
            if ($user->status === 'rejected') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda telah ditolak.',
                ]);
            }

            $request->session()->regenerate();

            // buang url intended lama
            $request->session()->forget('url.intended');

            return $this->authenticated($request, $user);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}