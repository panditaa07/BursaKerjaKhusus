<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminJobPostController;
use App\Http\Controllers\Admin\AdminApplicationController;

use App\Http\Controllers\Admin\UserProfileViewController;

// ================== ADMIN ROUTES ==================
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/companies/pending', [AdminDashboardController::class, 'pendingCompanies'])->name('companies.pending');

    // Manage Users
    Route::resource('users', AdminDashboardController::class)->parameters([
        'users' => 'user'
    ])->except(['show']);

    // User Profile View (read-only)
    Route::get('users/{id}/profile', [UserProfileViewController::class, 'show'])->name('users.profile.show');

    // Job Posts Management
    Route::get('job-posts', [AdminJobPostController::class, 'index'])->name('job-posts.all');
    Route::get('job-posts/active', [AdminJobPostController::class, 'active'])->name('job-posts.active');
    Route::get('job-posts/closed', [AdminJobPostController::class, 'closed'])->name('job-posts.closed');
    Route::get('job-posts/create', [AdminJobPostController::class, 'create'])->name('job-posts.create');
    Route::post('job-posts', [AdminJobPostController::class, 'store'])->name('job-posts.store');
    Route::get('job-posts/{job_post}', [AdminJobPostController::class, 'show'])->name('job-posts.show');
    Route::get('job-posts/{job_post}/edit', [AdminJobPostController::class, 'edit'])->name('job-posts.edit');
    Route::patch('job-posts/{job_post}', [AdminJobPostController::class, 'update'])->name('job-posts.update');
    Route::delete('job-posts/{job_post}', [AdminJobPostController::class, 'destroy'])->name('job-posts.destroy');

    // Separate route for Lowongan Ditutup page
    Route::get('lowongan-ditutup', [\App\Http\Controllers\Admin\AdminJobPostClosedController::class, 'index'])->name('lowongan.ditutup');

    // New route for statistics index page
    Route::get('/statistics', [AdminDashboardController::class, 'statisticsIndex'])->name('statistics.index');

    // Applications Management
    Route::get('applications/all', [AdminApplicationController::class, 'all'])->name('applications.all');
    Route::get('applications/month', [AdminApplicationController::class, 'month'])->name('applications.month');
    Route::get('applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
    Route::get('applications/{application}/edit', [AdminApplicationController::class, 'edit'])->name('applications.edit');
    Route::patch('applications/{application}', [AdminApplicationController::class, 'update'])->name('applications.update');
    Route::delete('applications/{application}', [AdminApplicationController::class, 'destroy'])->name('applications.destroy');
});
