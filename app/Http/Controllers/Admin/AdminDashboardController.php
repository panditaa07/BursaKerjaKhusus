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
     * Daftar semua pelamar
     */
    public function Pelamar(Request $request)
    {
        $query = Application::with('user', 'jobPost.company');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('jobPost', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $pelamar = $query->latest()->paginate(10)->appends($request->query());
        return view('admin.dashboard.pelamar', compact('pelamar'));
    }

    /**
     * Daftar pelamar bulan ini
     */
    public function pelamarBulanIni(Request $request)
    {
        $query = Application::with('user', 'jobPost.company')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('jobPost', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $pelamar = $query->latest()->paginate(10)->appends($request->query());
        return view('admin.dashboard.pelamar_bulan_ini', compact('pelamar'));
    }

    /**
     * Daftar lowongan aktif
     */
    public function lowonganAktif()
    {
        $lowongan = JobPost::with('company')->where('status', 'active')->get();
        return view('admin.dashboard.lowongan-aktif', compact('lowongan'));
    }

    /**
     * Daftar lowongan tidak aktif
     */
    public function lowonganTidakAktif()
    {
        $lowongan = JobPost::with('company')->where('status', 'inactive')->get();
        return view('admin.dashboard.lowongan-tidak-aktif', compact('lowongan'));
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
     * Manajemen User - list semua user (kecuali admin)
     */
    public function users(Request $request)
    {
        $query = User::whereHas('role', function ($q) {
                $q->where('name', '!=', 'admin');
            })
            ->with('role')
            ->withCount(['jobPosts', 'applications']);

        // Search by name or email
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && in_array($request->role, ['company', 'user'])) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by kategori
        if ($request->has('kategori') && !empty($request->kategori)) {
            $kategori = $request->kategori;
            if ($kategori === 'company_with_jobs') {
                $query->whereHas('role', function ($q) {
                    $q->where('name', 'company');
                })->having('job_posts_count', '>', 0);
            } elseif ($kategori === 'company_without_jobs') {
                $query->whereHas('role', function ($q) {
                    $q->where('name', 'company');
                })->having('job_posts_count', '=', 0);
            } elseif ($kategori === 'user_with_applications') {
                $query->whereHas('role', function ($q) {
                    $q->where('name', 'user');
                })->having('applications_count', '>', 0);
            } elseif ($kategori === 'user_without_applications') {
                $query->whereHas('role', function ($q) {
                    $q->where('name', 'user');
                })->having('applications_count', '=', 0);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());
        return view('admin.users.index', compact('users'));
    }

    /**
     * Form create user
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Tampilkan detail user
     */
    public function showUser(User $user)
    {
        // Load relationships based on role
        if ($user->role->name === 'company') {
            $user->load(['jobPosts' => function($query) {
                $query->latest()->take(5);
            }]);
        } elseif ($user->role->name === 'user') {
            $user->load(['applications' => function($query) {
                $query->with('jobPost.company')->latest()->take(10);
            }]);
        }

        return view('admin.users.show', compact('user'));
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

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:500',
            'nisn'      => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'role'      => 'required|string|in:admin,company,user',
            'status'    => 'required|in:active,inactive',
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'nisn'      => $request->nisn,
            'birth_date' => $request->birth_date,
            'role_id'   => \App\Models\Role::where('name', $request->role)->first()->id,
        ]);

        if ($request->status === 'active') {
            $user->restore();
        } else {
            $user->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user (permanent delete)
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting their own account
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->forceDelete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus secara permanen.');
    }
}

