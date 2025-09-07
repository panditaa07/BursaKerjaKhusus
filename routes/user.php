<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserJobPostController;
use App\Http\Controllers\User\UserApplicationController;
use App\Http\Controllers\User\UserProfileController;

// User routes with role middleware
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Job Posts
    Route::prefix('job-posts')->name('job-posts.')->group(function () {
        Route::get('/', [UserJobPostController::class, 'index'])->name('index');
        Route::get('/{job}', [UserJobPostController::class, 'show'])->name('show');
    });

    // Applications
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [UserApplicationController::class, 'index'])->name('index');
        Route::post('/', [UserApplicationController::class, 'store'])->name('store');
        Route::get('/{application}', [UserApplicationController::class, 'show'])->name('show');
    });

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class, 'show'])->name('show');
        Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::put('/', [UserProfileController::class, 'update'])->name('update');
        Route::post('/upload-cv', [UserProfileController::class, 'uploadCv'])->name('upload-cv');

        // Attachment routes
        Route::post('/upload-attachment', [UserProfileController::class, 'uploadAttachment'])->name('upload-attachment');
        Route::post('/add-link', [UserProfileController::class, 'addLink'])->name('add-link');
        Route::delete('/attachment/{id}', [UserProfileController::class, 'deleteAttachment'])->name('delete-attachment');
        Route::get('/attachments', [UserProfileController::class, 'getAttachments'])->name('get-attachments');
    });
});
