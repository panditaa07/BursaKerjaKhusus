<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            // Redirect to a safe route to avoid redirect loop, e.g. logout or home
            return redirect()->route('home')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $statistics = [
            'total_jobs' => JobPost::where('company_id', $company->id)->count(),
            'active_jobs' => JobPost::where('company_id', $company->id)->where('status', 'active')->count(),
            'total_applications' => Application::whereHas('jobPost', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->count(),
        ];

        $recentJobs = JobPost::where('company_id', $company->id)->latest()->take(5)->get();
        $recentApplications = Application::whereHas('jobPost', function($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with('user')->latest()->take(5)->get();

        return view('company.dashboard.index', compact('company', 'statistics', 'recentJobs', 'recentApplications'));
    }
}