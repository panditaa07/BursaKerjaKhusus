<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyPelamarController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of all applications for the company
     */
    public function indexAll()
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;

        if (!$company) {
            return redirect()->route('user.dashboard.index')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $applications = Application::whereHas('jobPost', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->with(['user', 'jobPost'])->latest()->paginate(10);

        return view('company.pelamar.index', compact('applications'));
    }

    /**
     * Display a listing of applications for the current month for the company
     */
    public function indexThisMonth()
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;

        if (!$company) {
            return redirect()->route('user.dashboard.index')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $applications = Application::whereHas('jobPost', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->with(['user', 'jobPost'])
        ->latest()
        ->paginate(10);

        return view('company.pelamar.bulan_ini', compact('applications'));
    }
}
