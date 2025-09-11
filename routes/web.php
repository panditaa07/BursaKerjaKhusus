<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\AdminJobPostController;
use App\Http\Controllers\AdminPelam;
use Illuminate\Support\Facades\Auth;

// ================== PUBLIC ROUTES ==================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ✅ Login & Logout pakai LoginController
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Register with role-based forms
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::get('/register/{role}', [RegisteredUserController::class, 'create'])->name('register.role');
Route::post('/register/{role}', [RegisteredUserController::class, 'store'])->name('register.store');

// Temporary route to check authentication
Route::get('/check-auth', function () {
    return Auth::check() ? 'User is authenticated' : 'User is not authenticated';
});

Route::middleware(['auth'])->group(function () {

    // ===== Admin Routes =====
    Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/dashboard/pelamar', [AdminDashboardController::class, 'Pelamar'])->name('dashboard.pelamar');
        Route::get('/dashboard/pelamar/bulanini', [AdminDashboardController::class, 'pelamarBulanIni'])->name('dashboard.pelamar.bulanini');
        Route::get('/dashboard/lowongan-aktif', [AdminDashboardController::class, 'lowonganAktif'])->name('dashboard.lowongan-aktif');
        Route::get('/dashboard/lowongan-tidak-aktif', [AdminDashboardController::class, 'lowonganTidakAktif'])->name('dashboard.lowongan-tidak-aktif');
        Route::get('/companies/pending', [AdminDashboardController::class, 'pendingCompanies'])->name('companies.pending');

        // User Management
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
        Route::get('/users/create', [AdminDashboardController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.destroy');

        // Job Posts (Admin)
        Route::resource('job-posts', AdminJobPostController::class)->names([
            'index'   => 'job-posts.index',
            'create'  => 'job-posts.create',
            'store'   => 'job-posts.store',
            'edit'    => 'job-posts.edit',
            'update'  => 'job-posts.update',
            'destroy' => 'job-posts.destroy',
        ]);
    });

    // ===== Company Routes =====
    Route::prefix('company')->middleware(['auth','role:company'])->name('company.')->group(function () {
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard.index');

        // Job management
        Route::get('/jobs', [JobPostController::class, 'companyIndex'])->name('jobs.index');
        Route::get('/jobs/create', [JobPostController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobPostController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobPostController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobPostController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobPostController::class, 'destroy'])->name('jobs.destroy');

        // Applications
        Route::get('/applications', [ApplicationController::class, 'indexForCompany'])->name('applications.index');
        Route::get('/applications/{application}/preview', [ApplicationController::class, 'previewPdf'])->name('applications.preview');
        Route::get('/applications/{application}/download', [ApplicationController::class, 'downloadPdf'])->name('applications.download');
        Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    });

    // ===== User Routes =====
    Route::prefix('user')->middleware(['auth', 'role:user'])->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    });

    // ===== Jobs (umum) =====
    Route::prefix('jobs')->name('jobs.')->group(function () {
        Route::get('/', [JobPostController::class, 'index'])->name('index');
        Route::get('/{job}', [JobPostController::class, 'show'])->name('show');
    });

    // ===== Applications (pelamar) =====
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::post('/', [ApplicationController::class, 'store'])->name('store')->middleware('role:user');
        Route::get('/{application}', [ApplicationController::class, 'show'])->name('show')->middleware('role:user|company|admin');
    });

    // ===== Profile =====
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('index');
        Route::get('/show', [ProfileController::class, 'show'])->name('show');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/upload-cv', [ProfileController::class, 'showUploadForm'])->name('upload-cv');
        Route::post('/upload-cv', [ProfileController::class, 'uploadCv'])->name('upload-cv.post');
    });

    // ===== Lamaran Routes =====
    Route::prefix('lamarans')->middleware('role:student|alumni|user')->name('lamarans.')->group(function () {
        Route::get('/', [LamaranController::class, 'index'])->name('index');
        Route::get('/create', [LamaranController::class, 'create'])->name('create');
        Route::post('/', [LamaranController::class, 'store'])->name('store');
        Route::get('/{lamaran}', [LamaranController::class, 'show'])->name('show');
        Route::get('/{lamaran}/edit', [LamaranController::class, 'edit'])->name('edit');
        Route::put('/{lamaran}', [LamaranController::class, 'update'])->name('update');
        Route::delete('/{lamaran}', [LamaranController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/status', [LamaranController::class, 'updateStatus'])->name('updateStatus');
    });

    // ===== Lowongan Routes =====
    Route::prefix('lowongans')->name('lowongans.')->group(function () {
        Route::get('/', [LowonganController::class, 'index'])->name('index');
        Route::get('/create', [LowonganController::class, 'create'])->name('create')->middleware('role:company');
        Route::post('/', [LowonganController::class, 'store'])->name('store')->middleware('role:company');
        Route::get('/{lowongan}', [LowonganController::class, 'show'])->name('show');
        Route::get('/{lowongan}/edit', [LowonganController::class, 'edit'])->name('edit')->middleware('role:company');
        Route::put('/{lowongan}', [LowonganController::class, 'update'])->name('update')->middleware('role:company');
        Route::delete('/{lowongan}', [LowonganController::class, 'destroy'])->name('destroy')->middleware('role:company');
    });
});