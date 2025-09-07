<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;

class AdminJobPostClosedController extends Controller
{
    /**
     * Tampilkan daftar lowongan yang sudah ditutup
     */
    public function index()
    {
        // Ambil semua job posts dengan status "closed" + relasi company
        $closedJobPosts = JobPost::with('company')
            ->where('status', 'closed')
            ->latest()
            ->paginate(10);

        return view('admin.job_posts.closed', compact('closedJobPosts'));
    }
}
