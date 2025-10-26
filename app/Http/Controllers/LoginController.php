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
        $roleName = $user->role->name ?? null;

        // arahkan sesuai role
        return redirect()->route(\App\Providers\RouteServiceProvider::dashboardRouteForRole($roleName));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            if ($user->role->name !== 'admin') {
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
            }

            $request->session()->regenerate();

            // clear cache biar ga ada redirection lama
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');

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

        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}