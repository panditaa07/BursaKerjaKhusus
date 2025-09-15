<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Company;
use Illuminate\Http\Request;

class AdminJobPostController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with('company');

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('company', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }

        $jobPosts = $query->latest()->paginate(10);
        $totalLoker = JobPost::count();

        return view('admin.jobs.index', compact('jobPosts', 'totalLoker'));
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
            'min_salary' => 'nullable|string|max:255',
            'max_salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'berkas_lamaran' => 'nullable|string',
            'company_address' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload for company logo
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $validated['company_logo'] = $logoPath;
        }

        $jobPost = JobPost::create($validated);

        // Update company if address or phone provided
        if ($request->filled('company_address') || $request->filled('company_phone')) {
            $company = Company::find($validated['company_id']);
            if ($company) {
                $company->update([
                    'address' => $request->company_address,
                    'phone' => $request->company_phone,
                ]);
            }
        }

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
            'min_salary' => 'nullable|string|max:255',
            'max_salary' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'berkas_lamaran' => 'nullable|string',
            'company_address' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:255',
            'company_email' => 'nullable|email',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            // Handle file upload for company logo
            if ($request->hasFile('company_logo')) {
                $logoPath = $request->file('company_logo')->store('company_logos', 'public');
                $validated['company_logo'] = $logoPath;
            }

            // Update job post
            $jobPost->fill($validated);
            $jobPost->save();

            // Update company address and phone regardless of filled() to allow clearing fields
            $company = Company::find($validated['company_id']);
            if ($company) {
                $company->update([
                    'address' => $request->input('company_address'),
                    'phone' => $request->input('company_phone'),
                ]);
            }

            // Update user email regardless of filled() to allow clearing email
            if ($company && $company->user) {
                $company->user->update(['email' => $request->input('company_email')]);
            }

            return redirect()->route('admin.job-posts.show', $jobPost)->with('success', 'Lowongan berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('admin.job-posts.edit', $jobPost)->withErrors('Perubahan gagal disimpan')->withInput();
        }
    }

    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();
        return redirect()->route('admin.job-posts.index')->with('success', 'Lowongan berhasil dihapus');
    }
}
