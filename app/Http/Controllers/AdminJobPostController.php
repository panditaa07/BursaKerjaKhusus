<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Company;
use Illuminate\Http\Request;

class AdminJobPostController extends Controller
{
    public function index()
    {
        $jobPosts = JobPost::with('company')->latest()->paginate(10);
        return view('admin.jobs.index', compact('jobPosts'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.jobs.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'industry_id' => 'required|exists:industries,id',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Internship',
            'vacancies' => 'required|integer|min:1',
            'deadline' => 'required|date|after:today',
            'salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        JobPost::create($validated);
        return redirect()->route('admin.job-posts.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function show(JobPost $jobPost)
    {
        return view('admin.jobs.show', compact('jobPost'));
    }

    public function edit(JobPost $jobPost)
    {
        $companies = Company::all();
        $industries = \App\Models\Industry::all();
        return view('admin.jobs.edit', compact('jobPost', 'companies', 'industries'));
    }

    public function update(Request $request, JobPost $jobPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'industry_id' => 'required|exists:industries,id',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:Full-time,Part-time,Contract,Internship',
            'vacancies' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload for company logo
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $validated['company_logo'] = $logoPath;
        }

        $jobPost->update($validated);
        return redirect()->route('admin.job-posts.index')->with('success', 'Lowongan berhasil diupdate');
    }

    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();
        return redirect()->route('admin.job-posts.index')->with('success', 'Lowongan berhasil dihapus');
    }
}
