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
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Full-time,Part-time,Contract,Internship',
            'salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        JobPost::create($validated);
        return redirect()->route('admin.job-posts.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function edit(JobPost $jobPost)
    {
        $companies = Company::all();
        return view('admin.jobs.edit', compact('jobPost', 'companies'));
    }

    public function update(Request $request, JobPost $jobPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|in:Full-time,Part-time,Contract,Internship',
            'salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $jobPost->update($validated);
        return redirect()->route('admin.job-posts.index')->with('success', 'Lowongan berhasil diupdate');
    }

    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();
        return redirect()->route('admin.job-posts.index')->with('success', 'Lowongan berhasil dihapus');
    }
}
