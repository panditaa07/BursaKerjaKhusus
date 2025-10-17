<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\Application;

class UserDashboardController extends Controller
{
    public function index()
    {
        $statistics = [
            'total_users'        => User::count(),
            'total_companies'    => Company::count(),
            'total_jobs'         => JobPost::count(),
            'total_applications' => Application::count(),
        ];

        // Get latest active job postings with companies
        $latestJobs = JobPost::where('status', 'active')->whereHas('company')->with('company')->latest()->take(6)->get();

        return view('user.dashboard.index', compact('statistics', 'latestJobs'));
    }
}
