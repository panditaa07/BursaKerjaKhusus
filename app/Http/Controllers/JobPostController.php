<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\Industry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobPost::active()->with('company.user', 'industry')->latest();

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('company', function($companyQuery) use ($search) {
                      $companyQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $jobs = $query->paginate(5);
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
                        ->with('company.user', 'industry')
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
                        ->with('company.user', 'industry')
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
                        ->with('company.user', 'industry')
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
        $industries = Industry::all();
        return view('company.jobs.create', compact('industries'));
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
            'location' => 'nullable|string|max:500',
            'employment_type' => 'required|in:full_time,part_time,internship,freelance',
            'vacancies' => 'required|integer|min:1',
            'deadline' => 'nullable|date|after:today',
            'industry_id' => 'required|exists:industries,id',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0|gte:min_salary',
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
        $user = auth()->user();

        // Check user role and permissions
        if ($user->role->name === 'company') {
            // Company users can only view their own jobs
            if ($job->company_id !== $user->company->id) {
                abort(403, 'Unauthorized action.');
            }
            $view = 'company.jobs.show';
        } elseif ($user->role->name === 'user') {
            // Regular users can view active jobs
            if ($job->status !== 'active') {
                // Instead of aborting, show all active jobs
                $jobs = JobPost::where('status', 'active')->with('company')->latest()->paginate(10);
                return view('user.jobs.index', compact('jobs'))->with('error', 'Job is not available. Showing all active jobs.');
            }
            $view = 'user.jobs.show'; // Assuming there's a user view for jobs
        } elseif ($user->role->name === 'admin') {
            // Admins can view all jobs
            $view = 'admin.jobs.show';
        } else {
            abort(403, 'Unauthorized access.');
        }

        $job->load(['company.user', 'applications.user', 'industry']);
        return view($view, compact('job'));
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

        $industries = Industry::all();

        return view('company.jobs.edit', compact('job', 'industries'));
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
            'location' => 'nullable|string|max:255',
            'employment_type' => 'required|string|in:full_time,part_time,internship,freelance',
            'vacancies' => 'required|integer|min:1',
            'deadline' => 'nullable|date|after_or_equal:today',
            'status' => 'required|in:active,inactive',
            'industry_id' => 'required|exists:industries,id',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0|gte:min_salary',
            'berkas_lamaran' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'created_at' => 'nullable|date_format:Y-m-d\TH:i',
            'total_pelamar' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($request, $job) {
            // Update company fields if provided
            $companyUpdates = [];
            if ($request->filled('company_name')) {
                $companyUpdates['name'] = $request->company_name;
            }
            if ($request->filled('company_address')) {
                $companyUpdates['address'] = $request->company_address;
            }
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($job->company->logo && Storage::disk('public')->exists($job->company->logo)) {
                    Storage::disk('public')->delete($job->company->logo);
                }
                // Store new logo
                $logoPath = $request->file('logo')->store('logo_perusahaan', 'public');
                $companyUpdates['logo'] = $logoPath;
            }
            if (!empty($companyUpdates)) {
                $job->company->update($companyUpdates);
            }

            // Update job fields
            $jobUpdates = $request->only([
                'title', 'description', 'requirements', 'location', 'employment_type',
                'vacancies', 'deadline', 'status', 'industry_id', 'min_salary', 'max_salary', 'berkas_lamaran'
            ]);
            if ($request->filled('created_at')) {
                $jobUpdates['created_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->created_at)->toDateTimeString();
            }
            if ($request->has('total_pelamar')) {
                $jobUpdates['total_pelamar'] = $request->total_pelamar;
            }
            $job->update($jobUpdates);
        });

        return redirect()->route('company.jobs.show', $job)
            ->with('success', 'Data lowongan berhasil diperbarui.');
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
            ->with('success', 'Lowongan berhasil dihapus.');
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
            case 'dashboard':
                return 'company.dashboard.index';
            case 'active':
                return 'company.jobs.active';
            case 'inactive':
                return 'company.jobs.inactive';
            default:
                return 'company.jobs.all';
        }
    }
}
