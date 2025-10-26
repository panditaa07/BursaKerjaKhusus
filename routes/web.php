<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyDashboardController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\AdminJobPostController;
use App\Http\Controllers\Auth\ForgotPasswordController;



// ================== PUBLIC ROUTES ==================

// Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// ✅ Login & Logout pakai LoginController
Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ✅ Register with role-based forms
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::get('/register/{role}', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register.role');
Route::post('/register/{role}', [RegisteredUserController::class, 'store'])->name('register.store');

// Temporary route to check authentication
Route::get('/check-auth', function () {
    return Auth::check() ? 'User is authenticated' : 'User is not authenticated';
});

// Route for /says to return JSON


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
        Route::get('/users/{user}', [AdminDashboardController::class, 'showUser'])->name('users.show');
        // Route::get('/users/create', [AdminDashboardController::class, 'createUser'])->name('users.create');
        // Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
        Route::get('/users/{user}/download-cover-letter', [AdminDashboardController::class, 'downloadCoverLetter'])->name('users.download_cover_letter');
        Route::get('/users/{user}/preview-cv', [AdminDashboardController::class, 'previewCv'])->name('users.preview_cv');
        Route::get('/users/{user}/download-cv', [AdminDashboardController::class, 'downloadCv'])->name('users.download_cv');
        Route::get('/users/{user}/preview-cover-letter', [AdminDashboardController::class, 'previewCoverLetter'])->name('users.preview_cover_letter');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.destroy');
        Route::delete('/company/{company}', [AdminDashboardController::class, 'destroyCompany'])->name('company.destroy');

        // Job Posts (Admin)
        Route::resource('admin-jobs', AdminJobPostController::class)->parameters(['admin-jobs' => 'jobPost'])->names([
            'index'   => 'job-posts.index',
            'create'  => 'job-posts.create',
            'store'   => 'job-posts.store',
            'show'    => 'job-posts.show',
            'edit'    => 'job-posts.edit',
            'update'  => 'job-posts.update',
            'destroy' => 'job-posts.destroy',
        ]);

        // Applications Management
        // Removed applications/all route as it's duplicate of /admin/dashboard/pelamar
        Route::get('applications/month', [\App\Http\Controllers\Admin\AdminApplicationController::class, 'month'])->name('applications.month');
        Route::get('applications/{application}', [\App\Http\Controllers\Admin\AdminApplicationController::class, 'show'])->name('applications.show');
        Route::get('applications/{application}/edit', [\App\Http\Controllers\Admin\AdminApplicationController::class, 'edit'])->name('applications.edit');
        Route::patch('applications/{application}', [\App\Http\Controllers\Admin\AdminApplicationController::class, 'update'])->name('applications.update');
        Route::delete('applications/{id}', [\App\Http\Controllers\Admin\AdminApplicationController::class, 'destroy'])->name('applications.destroy');

        // File serving for secure accessz
        Route::get('files/{path}', [\App\Http\Controllers\Admin\AdminApplicationController::class, 'serveFile'])->name('files')->where('path', '.*');

        // Account Verification
        Route::get('/verifications', [\App\Http\Controllers\Admin\VerificationController::class, 'index'])->name('verifications.index');
        Route::post('/verifications/users/{user}/approve', [\App\Http\Controllers\Admin\VerificationController::class, 'approveUser'])->name('verifications.users.approve');
        Route::post('/verifications/users/{user}/reject', [\App\Http\Controllers\Admin\VerificationController::class, 'rejectUser'])->name('verifications.users.reject');
        Route::post('/verifications/companies/{company}/approve', [\App\Http\Controllers\Admin\VerificationController::class, 'approveCompany'])->name('verifications.companies.approve');
        Route::post('/verifications/companies/{company}/reject', [\App\Http\Controllers\Admin\VerificationController::class, 'rejectCompany'])->name('verifications.companies.reject');
    });

    // ===== Company Routes =====
    Route::prefix('company')->middleware(['auth','role:company'])->name('company.')->group(function () {
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard.index');

        // Job management
        Route::get('/jobs', [JobPostController::class, 'allJobs'])->name('jobs.all'); // This will use index.blade.php for "Kelola Lowongan Kerja"
        Route::get('/jobs/manage', [JobPostController::class, 'allJobs'])->name('jobs.manage'); // Alternative route for manage page
        Route::get('/jobs/active', [JobPostController::class, 'activeJobs'])->name('jobs.active');
        Route::get('/jobs/inactive', [JobPostController::class, 'inactiveJobs'])->name('jobs.inactive');
        Route::get('/jobs/create', [JobPostController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobPostController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [JobPostController::class, 'edit'])->name('jobs.edit');
        Route::get('/jobs/{job}', [JobPostController::class, 'show'])->name('jobs.show');
        Route::put('/jobs/{job}', [JobPostController::class, 'update'])->name('jobs.update');
        Route::patch('/jobs/{job}/toggle-status', [JobPostController::class, 'toggleStatus'])->name('jobs.toggle-status');
        Route::delete('/jobs/{job}', [JobPostController::class, 'destroy'])->name('jobs.destroy');

        // Applications
        Route::get('/pelamar', [ApplicationController::class, 'indexAllApplicants'])->name('pelamar.all');
        Route::get('/pelamar/bulan-ini', [ApplicationController::class, 'indexThisMonthApplicants'])->name('applications.this_month');
        Route::get('/applications/{applicationId}', [ApplicationController::class, 'showForCompany'])->name('applications.show.company');
        Route::get('/applications/{application}/preview', [ApplicationController::class, 'previewPdf'])->name('applications.preview');
        Route::get('/applications/{application}/download', [ApplicationController::class, 'downloadPdf'])->name('applications.download');
        Route::get('/applications/{application}/preview-cover-letter', [ApplicationController::class, 'previewCoverLetter'])->name('applications.preview-cover-letter');
        Route::get('/applications/{application}/download-cover-letter', [ApplicationController::class, 'downloadCoverLetter'])->name('applications.download-cover-letter');
        Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('lamarans.update');
        Route::put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

        // Alias routes for applicants (as specified in requirements)
        Route::get('/applicants/{application}', [ApplicationController::class, 'showForCompany'])->name('applicants.show');
        Route::get('/applicants/{application}/edit', [ApplicationController::class, 'edit'])->name('applicants.edit');
        Route::delete('/applicants/{application}', [ApplicationController::class, 'destroy'])->name('applicants.destroy');

        // Debug routes for testing
        Route::get('/debug-role', function () {
            $user = Auth::user();
            $user->load(['role', 'company']);
            return response()->json([
                'user_id' => $user->id,
                'user_role_id' => $user->role_id,
                'user_role_name' => $user->role->name ?? null,
                'user_company_id' => $user->company_id,
                'user_company_name' => $user->company->name ?? null,
                'is_authenticated' => Auth::check(),
                'middleware_should_pass' => $user->role && $user->role->name === 'company'
            ]);
        })->name('debug.role');

        Route::get('/debug-access', [ApplicationController::class, 'debugAccess'])->name('debug.access');
    });

    // ===== User Routes =====
    Route::prefix('user')->middleware(['auth', 'role:user'])->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    });

    // ===== Jobs (umum) =====
    Route::prefix('jobs')->name('jobs.')->group(function () {
        Route::get('/', [JobPostController::class, 'index'])->name('index');
        Route::get('/{job}', [JobPostController::class, 'show'])->name('show');
        Route::get('/jobs/{id}/edit', [JobPostController::class, 'edit'])->name('edit');

    });

    // ===== Applications (pelamar) =====
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::post('/', [ApplicationController::class, 'store'])->name('store')->middleware('role:user');
        Route::put('/{application}/repair-status', [ApplicationController::class, 'updateRepairStatus'])->name('updateRepairStatus')->middleware('role:admin');
    });

    // ===== Profile =====
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('index');
        Route::get('/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
        Route::get('/upload-cv', [ProfileController::class, 'showUploadForm'])->name('upload-cv');
        Route::post('/upload-cv', [ProfileController::class, 'uploadCv'])->name('upload-cv.post');
        Route::get('/preview-cover-letter', [ProfileController::class, 'previewCoverLetter'])->name('preview_cover_letter');
        Route::get('/preview-cv', [ProfileController::class, 'previewCv'])->name('preview_cv');
    });



    Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotifikasiUser::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotifikasiUser::class, 'markAsRead'])->name('notifications.read');
});

});
