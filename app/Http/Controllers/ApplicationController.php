<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\JobPost;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Mail\StatusLamaranMail;

class ApplicationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of applications for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $applications = $user->applications()->with(['jobPost.company'])->latest()->paginate(10);

        // Get notifications for the user (if notifications table exists)
        try {
            $notifications = $user->notifications()->latest()->take(5)->get();
        } catch (\Exception $e) {
            $notifications = collect(); // Empty collection if notifications not available
        }

        return view('user.applications.index', compact('applications', 'notifications'));
    }

    /**
     * Display a listing of all applications for the company
     */
    public function indexAllApplicants(Request $request)
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;

        if (!$company) {
            // Redirect to a safe route to avoid redirect loop, e.g. logout or home
            return redirect()->route('user.dashboard.index')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $search = $request->input('search');
        $filter = $request->input('filter');

        $applications = Application::whereHas('jobPost', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })
        ->when($search, function ($q) use ($search) {
            $q->whereHas('user', function ($u) use ($search) {
                $u->where('name', 'like', "%{$search}%");
            })->orWhereHas('jobPost', function ($l) use ($search) {
                $l->where('title', 'like', "%{$search}%");
            })->orWhere('status', 'like', "%{$search}%");
        })
        ->when($filter === 'new', function ($q) {
            $q->whereIn('status', ['submitted', 'reviewed']);
        })
        ->when($filter === 'process', function ($q) {
            $q->whereIn('status', ['interview', 'test1', 'test2']);
        })
        ->with(['user', 'jobPost'])
        ->latest()
        ->paginate(10);

        return view('company.applications.all', compact('applications'));
    }

    /**
     * Display a listing of applications for the current month for the company
     */
    public function indexThisMonthApplicants(Request $request)
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;

        if (!$company) {
            // Redirect to a safe route to avoid redirect loop, e.g. logout or home
            return redirect()->route('user.dashboard.index')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $search = $request->input('search');

        $applications = Application::whereHas('jobPost', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->when($search, function ($q) use ($search) {
            $q->whereHas('user', function ($u) use ($search) {
                $u->where('name', 'like', "%{$search}%");
            })->orWhereHas('jobPost', function ($l) use ($search) {
                $l->where('title', 'like', "%{$search}%");
            })->orWhere('status', 'like', "%{$search}%");
        })
        ->with(['user', 'jobPost'])
        ->latest()
        ->paginate(10);

        return view('company.applications.this_month', compact('applications'));
    }

    /**
     * Preview PDF file
     */
    public function previewPdf(Application $application)
    {
        // Cek hak akses - company hanya bisa akses aplikasi untuk job mereka
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;

        if (!$company || $application->jobPost->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }

        $filePath = storage_path('app/public/' . $application->cv_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->file($filePath);
    }

    /**
     * Download PDF file
     */
    public function downloadPdf(Application $application)
    {
        // Cek hak akses - company hanya bisa akses aplikasi untuk job mereka
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;

        if (!$company || $application->jobPost->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }

        $filePath = storage_path('app/public/' . $application->cv_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, 'CV_' . $application->user->name . '.pdf');
    }

    /**
     * Store a new application (for students)
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_post_id' => 'required|exists:job_posts,id',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $job = JobPost::findOrFail($request->job_post_id);

        // Prevent duplicate applications
        if (Application::where('user_id', $user->id)
            ->where('job_post_id', $job->id)
            ->exists()) {
            return back()->with('error', 'You already applied to this job.');
        }

        $cvPath = $request->hasFile('cv')
            ? $request->file('cv')->store('cvs', 'public')
            : $user->cv_path;

        $application = Application::create([
            'user_id' => $user->id,
            'job_post_id' => $request->job_post_id,
            'cv_path' => $cvPath,
            'cover_letter' => $request->cover_letter,
            'status' => 'submitted',
        ]);

        // Null safety checks for email notification
        $companyName = $job->company ? $job->company->name : 'Unknown Company';
        $jobTitle = $job->title ?? 'Unknown Position';

        // Kirim email notifikasi Apply
        try {
            Mail::to($user->email)->send(new StatusLamaranMail(
                $user->name,
                $jobTitle,
                $companyName,
                'apply',
                route('user.applications.show', $application->id)
            ));
        } catch (\Exception $e) {
            // Log error but don't break the application
            \Log::error('Failed to send email notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Application submitted successfully.');
    }

    /**
     * Update application status + send email
     */
    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:submitted,reviewed,accepted,rejected,interview,test1,test2',
        ]);

        // Pastikan hanya perusahaan pemilik job yang bisa update
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;
        if (!$company || $application->jobPost->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }

        // Update status
        $application->update(['status' => $request->status]);

        // Kirim email notifikasi status diterima/ditolak
        Mail::to($application->user->email)->send(new StatusLamaranMail(
            $application->user->name,
            $application->jobPost->title,
            $application->jobPost->company->name,
            $application->status,
            route('user.applications.show', $application->id)
        ));

        return redirect()->back()
            ->with('success', 'Application status updated successfully & email notification sent.');
    }

    /**
     * Get applications for a specific job
     */
    public function indexForJob(JobPost $job)
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $this->authorize('view', $job);

        $applications = $job->applications()->with('user')->latest()->get();

        return view('company.applications.show', compact('applications', 'job'));
    }

    /**
     * Delete an application
     */
    public function destroy(Application $application)
    {
        // Pastikan hanya perusahaan pemilik job yang bisa hapus
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;
        if (!$company || $application->jobPost->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file CV jika ada
        if ($application->cv_path && file_exists(storage_path('app/public/' . $application->cv_path))) {
            unlink(storage_path('app/public/' . $application->cv_path));
        }

        // Hapus aplikasi
        $application->delete();

        return redirect()->back()
            ->with('success', 'Lamaran berhasil dihapus.');
    }

    /**
     * Show a specific application for company
     */
    public function showForCompany($applicationId)
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        // Debug information
        \Log::info('Company Application Access Debug', [
            'user_id' => $user->id,
            'user_role' => $user->role->name ?? null,
            'user_company_id' => $user->company_id,
            'user_company_name' => $user->company->name ?? null,
            'requested_application_id' => $applicationId,
            'middleware_passed' => true
        ]);

        // Find the application manually to avoid model binding issues
        $application = Application::findOrFail($applicationId);

        \Log::info('Application found', [
            'application_id' => $application->id,
            'application_job_post_id' => $application->job_post_id,
            'application_job_post_company_id' => $application->jobPost->company_id ?? null
        ]);

        $company = $user->company;

        // Check if user has company
        if (!$company) {
            \Log::warning('User does not have associated company', [
                'user_id' => $user->id,
                'user_company_id' => $user->company_id
            ]);
            abort(403, 'Anda tidak memiliki data perusahaan yang terkait. Silakan hubungi administrator.');
        }

        // Check if application belongs to company's job post
        if (!$application->jobPost || $application->jobPost->company_id !== $company->id) {
            \Log::warning('Application does not belong to user company', [
                'user_company_id' => $company->id,
                'application_job_post_company_id' => $application->jobPost->company_id ?? null,
                'application_id' => $application->id
            ]);
            abort(403, 'Anda tidak memiliki akses untuk melihat lamaran ini.');
        }

        // Load relationships
        $application->load(['user', 'jobPost']);

        return view('company.applications.show', compact('application'));
    }

    /**
     * Edit a specific application for company
     */
    public function edit(Application $application)
    {
        // Pastikan hanya perusahaan pemilik job yang bisa edit
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;
        if (!$company || $application->jobPost->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }

        // Load relationships
        $application->load(['user', 'jobPost']);

        // Pass as $lamaran to match the view expectation
        $lamaran = $application;

        return view('company.applications.edit', compact('lamaran'));
    }

    /**
     * Update a specific application for company
     */
    public function update(Request $request, Application $application)
    {
        // Pastikan hanya perusahaan pemilik job yang bisa update
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        $company = $user->company;
        if (!$company || $application->jobPost->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'nama_pelamar' => 'nullable|string|max:255',
            'lowongan' => 'nullable|string|max:255',
        ]);

        $data = [];

        if ($request->hasFile('cv')) {
            // Hapus CV lama jika ada
            if ($application->cv_path && file_exists(storage_path('app/public/' . $application->cv_path))) {
                unlink(storage_path('app/public/' . $application->cv_path));
            }

            $data['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        // Update description with nama_pelamar if provided
        if ($request->filled('nama_pelamar')) {
            $data['description'] = $request->nama_pelamar;
        }

        if (!empty($data)) {
            $application->update($data);
        }

        return redirect()->route('company.applications.show.company', $application->id)
            ->with('success', 'Lamaran berhasil diupdate.');
    }

    /**
     * Debug method to test role and company access
     */
    public function debugAccess()
    {
        $user = Auth::user();
        $user->load(['role', 'company']);

        return response()->json([
            'user_id' => $user->id,
            'user_role' => $user->role->name ?? null,
            'user_company' => $user->company->name ?? null,
            'has_company' => $user->company !== null,
            'can_access_company_routes' => $user->role && $user->role->name === 'company' && $user->company !== null,
            'route_middleware_should_pass' => $user->role && $user->role->name === 'company'
        ]);
    }

    /**
     * Show a specific application (for link in email)
     */
    public function show(Application $application)
    {
        $user = Auth::user();

        // Load relationships to avoid N+1 queries
        $user->load(['role', 'company']);

        // Only allow USER role to access this page
        if ($user->role->name !== 'user') {
            abort(403, 'Halaman ini hanya untuk role USER.');
        }

        // Cek hak akses: pelamar bisa lihat aplikasinya sendiri
        $isOwner = $user->id === $application->user_id;

        if (!$isOwner) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.applications.show', compact('application'));
    }


}
