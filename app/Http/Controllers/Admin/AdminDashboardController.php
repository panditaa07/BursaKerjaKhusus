<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik utama
        $statistics = [
            'total_users'            => User::count(),
            'total_companies'        => Company::count(),
            'total_jobs'             => JobPost::count(),
            'total_applications'     => Application::count(),
            'pending_companies'      => Company::where('is_verified', false)->count(),
            'active_jobs'            => JobPost::where('status', 'active')->count(),
            'closed_jobs'            => JobPost::where('status', 'closed')->count(),
            'pending_applications'   => Application::where('status', 'pending')->count(),
            'applications_this_month'=> Application::whereMonth('created_at', now()->month)
                                                   ->whereYear('created_at', now()->year)
                                                   ->count(),
        ];

        // Data terbaru
        $recentUsers        = User::latest()->take(5)->get();
        $recentCompanies    = Company::latest()->take(5)->get();
        $recentJobs         = JobPost::latest()->take(5)->get();
        $recentApplications = Application::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'user',
            'statistics',
            'recentUsers',
            'recentCompanies',
            'recentJobs',
            'recentApplications'
        ));
    }

    /**
     * Perusahaan yang pending verifikasi
     */
    public function pendingCompanies()
    {
        $pendingCompanies = Company::where('is_verified', false)->get();
        return view('admin.pending_companies', compact('pendingCompanies'));
    }

    /**
     * Manajemen User - list semua user
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Form create user
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|string|in:admin,company,user',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    /**
     * Form edit user
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update data user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|string|in:admin,company,user',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    /**
     * Hapus user
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting their own account
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}