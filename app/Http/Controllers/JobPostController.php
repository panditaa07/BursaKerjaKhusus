<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

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
     * Display a listing of jobs for the authenticated company.
     */
    public function companyIndex()
    {
        $user = auth()->user();
        $company = $user->company;

        if (!$company) {
            // Redirect to a safe route to avoid redirect loop, e.g. logout or home
            return redirect()->route('home')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $jobs = JobPost::where('company_id', $company->id)
                      ->with('company')
                      ->latest()
                      ->get();
        
        return view('company.jobs.index', compact('jobs'));
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
        $company->jobPosts()->create($request->all());

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {
        $job->load('company');
        return view('user.jobs.show', compact('job'));
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

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        // Ensure the job belongs to the authenticated company
        if ($job->company_id !== auth()->user()->company->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $job->delete();

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
}
