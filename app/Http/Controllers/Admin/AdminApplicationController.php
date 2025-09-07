<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;

class AdminApplicationController extends Controller
{
    public function index(Request $request)
    {
        // Deprecated: Remove this method or redirect to all()
        return redirect()->route('admin.applications.all');
    }

    // Removed duplicate all() and month() methods to fix redeclaration error

    public function all(Request $request)
    {
        $query = Application::with(['user', 'jobPost'])->latest();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(10);
        return view('admin.applications.index', compact('applications'));
    }

    public function month(Request $request)
    {
        $query = Application::with(['user', 'jobPost'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->latest();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(10);
        return view('admin.applications.month', compact('applications'));
    }

    public function show(Application $application)
    {
        $application->load(['user', 'jobPost']);
        return view('admin.applications.show', compact('application'));
    }

    public function edit(Application $application)
    {
        $application->load(['user', 'jobPost']);
        $statuses = ['submitted', 'test1', 'test2', 'interview', 'accepted', 'rejected'];
        return view('admin.applications.edit', compact('application', 'statuses'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:submitted,test1,test2,interview,accepted,rejected',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'short_profile' => 'nullable|string',
            'social_media_link' => 'nullable|url',
            'cv_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'application_letter_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'description' => 'nullable|string',
        ]);

        // Update user information
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'nisn' => $validated['nisn'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'address' => $validated['address'] ?? null,
            'short_profile' => $validated['short_profile'] ?? null,
            'social_media_link' => $validated['social_media_link'] ?? null,
        ];

        if ($application->user) {
            $application->user->update($userData);
        }

        // Handle file uploads
        $applicationData = ['status' => $validated['status'], 'description' => $validated['description'] ?? null];

        if ($request->hasFile('cv_path')) {
            $cvPath = $request->file('cv_path')->store('applications/cv', 'public');
            $applicationData['cv_path'] = $cvPath;
        }

        if ($request->hasFile('application_letter_path')) {
            $letterPath = $request->file('application_letter_path')->store('applications/letters', 'public');
            $applicationData['application_letter_path'] = $letterPath;
        }

        $application->update($applicationData);

        return redirect()->route('admin.applications.all')->with('success', 'Pelamar berhasil diupdate.');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('admin.applications.all')->with('success', 'Application deleted successfully.');
    }
}
