<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Jurusan;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all_time');
        
        // Base queries
        $jobPostsQuery = JobPost::query();
        $applicationsQuery = Application::query();
        
        // Apply role-based filtering
        if ($user->role === 'company') {
            $company = $user->company;
            if ($company) {
                $companyId = $company->id;
                $jobPostsQuery->where('company_id', $companyId);
                $applicationsQuery->whereHas('jobPost', function($query) use ($companyId) {
                    $query->where('company_id', $companyId);
                });
            } else {
                // If company doesn't exist, return empty results
                $jobPostsQuery->where('company_id', 0);
                $applicationsQuery->where('id', 0);
            }
        }
        
        // Apply time filters
        $this->applyTimeFilter($jobPostsQuery, $filter);
        $this->applyTimeFilter($applicationsQuery, $filter, 'created_at');
        
        // Calculate statistics
        $statistics = [
            'active_jobs' => (clone $jobPostsQuery)->where('status', 'active')->count(),
            'closed_jobs' => (clone $jobPostsQuery)->where('status', 'closed')->count(),
            'total_applicants' => (clone $applicationsQuery)->count(),
            'accepted_applicants' => (clone $applicationsQuery)->where('status', 'accepted')->count(),
            'rejected_applicants' => (clone $applicationsQuery)->where('status', 'rejected')->count(),
            'pending_applicants' => (clone $applicationsQuery)->where('status', 'pending')->count(),
        ];
        
        // Get berita and jurusan data
        $beritas = Berita::with('user')->latest()->take(3)->get();
        $jurusans = Jurusan::all();
        
        return view('user.dashboard.index', compact('user', 'statistics', 'filter', 'beritas', 'jurusans'));
    }
    
    private function applyTimeFilter($query, $filter, $column = 'created_at')
    {
        switch ($filter) {
            case 'today':
                $query->whereDate($column, today());
                break;
            case 'this_week':
                $query->whereBetween($column, [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth($column, now()->month)
                      ->whereYear($column, now()->year);
                break;
            case 'all_time':
            default:
                // No filter applied
                break;
        }
    }
}
