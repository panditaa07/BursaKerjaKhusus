<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Role-based redirection
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard.index');
            } else {
                return redirect()->intended('/dashboard');
            }
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

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'student',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login');
    }

    public function statistics()
    {
        $totalApplicants = \App\Models\Application::count();
        $acceptedApplicants = \App\Models\Application::where('status', 'accepted')->count();
        $pendingApplicants = \App\Models\Application::where('status', 'pending')->count();
        $rejectedApplicants = \App\Models\Application::where('status', 'rejected')->count();

        return view('statistics', compact(
            'totalApplicants',
            'acceptedApplicants',
            'pendingApplicants',
            'rejectedApplicants'
        ));
    }

    public function achievements()
    {
        return view('achievements');
    }

    public function info()
    {
        return view('info');
    }
}
