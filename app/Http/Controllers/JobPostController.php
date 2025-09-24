<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use Illuminate\Support\Facades\DB;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobPost::with('company')->latest()->get();
        return view('user.jobs.index', compact('jobs'));
    }

    /**
     * Display a listing of all jobs for the authenticated company.
     */
    public function allJobs(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('home')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $query = JobPost::where('company_id', $company->id)
                        ->with('company')
                        ->latest();

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->paginate(10);

        return view('company.jobs.all', compact('jobs'));
    }

    /**
     * Display a listing of active jobs for the authenticated company.
     */
    public function activeJobs(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('home')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $query = JobPost::where('company_id', $company->id)
                        ->where('status', 'active')
                        ->with('company')
                        ->latest();

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->paginate(10);

        return view('company.jobs.active', compact('jobs'));
    }

    /**
     * Display a listing of inactive jobs for the authenticated company.
     */
    public function inactiveJobs(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('home')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $query = JobPost::where('company_id', $company->id)
                        ->where('status', 'inactive')
                        ->with('company')
                        ->latest();

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->paginate(10);

        return view('company.jobs.inactive', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salary' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:full-time,part-time,contract,internship',
            'deadline' => 'nullable|date|after:today',
        ]);

        $company = auth()->user()->company;
        $job = $company->jobPosts()->create($request->all());

        // Determine redirect based on 'from' parameter
        $from = $request->input('from', 'all');
        $redirectRoute = $this->getRedirectRoute($from);

        return redirect()->route($redirectRoute)
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {
        // Ensure the job belongs to the authenticated company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403, 'Unauthorized action.');
        }

        $job->load(['company', 'applications', 'industry']);
        return view('company.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $job)
    {
        // Ensure the job belongs to the authenticated company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('company.jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPost $job)
    {
        // Ensure the job belongs to the authenticated company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salary' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:full-time,part-time,contract,internship',
            'deadline' => 'nullable|date|after:today',
        ]);

        $job->update($request->all());

        // Determine redirect based on 'from' parameter
        $from = $request->input('from', 'all');
        $redirectRoute = $this->getRedirectRoute($from);

        return redirect()->route($redirectRoute)
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, JobPost $job)
    {
        // Ensure the job belongs to the authenticated company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403, 'Unauthorized action.');
        }

        $job->delete();

        // Determine redirect based on 'from' parameter
        $from = $request->input('from', 'all');
        $redirectRoute = $this->getRedirectRoute($from);

        return redirect()->route($redirectRoute)
            ->with('success', 'Job deleted successfully.');
    }

    /**
     * Toggle the status of a job post (active/inactive).
     */
    public function toggleStatus(JobPost $job)
    {
        // Ensure the job belongs to the authenticated company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403, 'Unauthorized action.');
        }

        $job->update([
            'status' => $job->status === 'active' ? 'inactive' : 'active'
        ]);

        $status = $job->status === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Lowongan berhasil {$status}.");
    }

    /**
     * Helper method to determine redirect route based on source page.
     */
    private function getRedirectRoute($from)
    {
        switch ($from) {
            case 'active':
                return 'company.jobs.active';
            case 'inactive':
                return 'company.jobs.inactive';
            default:
                return 'company.jobs.all';
        }
    }
}
