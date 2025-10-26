<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Company;
use Illuminate\Http\Request;

class AdminJobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with('company')->latest();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('company', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status')) {
            $status = $request->input('status');
            if (in_array($status, ['active', 'inactive'])) {
                $query->where('status', $status);
            }
        }

        $jobPosts = $query->paginate(10)->appends($request->query());
        $totalLoker = JobPost::count(); // Global count regardless of filters
        return view('admin.jobs.index', compact('jobPosts', 'totalLoker'));
    }

    public function show(JobPost $jobPost)
    {
        return view('admin.jobs.show', compact('jobPost'));
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
            'employment_type' => 'required|in:full_time,part_time,internship,freelance',
            'vacancies' => 'required|integer|min:1',
            'salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'deadline' => 'required|date|after:today',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $data['company_logo'] = $logoPath;
        }

        $jobPost = JobPost::create($data);
        return redirect()->route('admin.job-posts.show', $jobPost)->with('success', 'Lowongan berhasil ditambahkan');
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
            'employment_type' => 'required|in:full_time,part_time,internship,freelance',
            'vacancies' => 'required|integer|min:1',
            'salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'deadline' => 'required|date',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $data['company_logo'] = $logoPath;
        }

        try {
            $jobPost->update($data);
            return redirect()->route('admin.job-posts.show', $jobPost)->with('success', 'Lowongan berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('admin.job-posts.edit', $jobPost)->withErrors('Perubahan gagal disimpan')->withInput();
        }
    }

    public function active(Request $request)
    {
        $query = JobPost::with('company')->where('status', 'active')->latest();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $jobPosts = $query->paginate(10);
        return view('admin.job_posts.active', compact('jobPosts'));
    }

    public function closed(Request $request)
    {
        $query = JobPost::with('company')->where('status', 'inactive')->latest();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $jobPosts = $query->paginate(10);
        return view('admin.job_posts.closed', compact('jobPosts'));
    }

    public function destroy(JobPost $jobPost, Request $request)
    {
        $jobPost->delete();
        $redirectTo = $request->input('_redirect_to', url()->previous());
        return redirect($redirectTo)->with('success', 'Lowongan berhasil dihapus');
    }
}