<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Company;
use App\Models\Application;
use App\Models\Loker;
use App\Models\Lamaran;
use App\Models\Pelamar;
use App\Models\PelamarBulanIni;
use App\Models\LowonganAktif;
use App\Models\LowonganTidakAktif;
use App\Models\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{

        // Method baru khusus notifikasi
    public function notifications()
    {
        $notifications = UserNotification::where('user_id', auth()->id())
                        ->latest()
                        ->get();
        return view('user.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = UserNotification::where('user_id', auth()->id())
                        ->findOrFail($id);
        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    /**
     * Tampilkan halaman dashboard admin
     */
    public function index()
    {
        $user = Auth::user();

        // Statistik utama untuk card
        $statistics = [
            'total_pelamar'         => Application::count(),
            'pelamar_bulan_ini'     => Application::whereMonth('created_at', now()->month)
                                                   ->whereYear('created_at', now()->year)
                                                   ->count(),
            'lowongan_aktif'        => JobPost::where('status', 'active')->count(),
            'lowongan_tidak_aktif'  => JobPost::where('status', 'inactive')->count(),
        ];

        // Data untuk tabel
        $daftar_pelamar_terbaru = Application::with('user', 'jobPost.company')->latest()->take(5)->get();

        // Eager load user phone to avoid N+1 and ensure phone is accessible
        $daftar_pelamar_terbaru->load('user');
        $loker_terbaru          = JobPost::where('status', 'active')->latest()->take(5)->get();
        $loker_tidak_aktif      = JobPost::where('status', 'inactive')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'user',
            'statistics',
            'daftar_pelamar_terbaru',
            'loker_terbaru',
            'loker_tidak_aktif'
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
        return view('admin.users.index', compact('users'));
    }

    public function index1()
    {
        return $this->index();
    }

    


    public function Pelamar(Request $request)
    {
        $query = Application::with('user', 'jobPost.company');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pelamar = $query->paginate(10);
        return view('admin.dashboard.pelamar', compact('pelamar'));
    }

    public function pelamarBulanIni(Request $request) {
        $query = Application::with('user', 'jobPost.company')
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pelamar = $query->paginate(10);
        return view('admin.dashboard.pelamar_bulan_ini', compact('pelamar'));
    }

    public function lowonganAktif() {
        $lowongan = JobPost::with('company')->where('status', 'active')->get();
        return view('admin.dashboard.lowongan-aktif', compact('lowongan'));
    }
    public function lowonganTidakAktif() {
        $lowongan = JobPost::with('company')->where('status', 'inactive')->get();
        return view('admin.dashboard.lowongan-tidak-aktif', compact('lowongan'));
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