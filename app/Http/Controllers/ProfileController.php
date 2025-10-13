<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;

class ProfileController extends Controller
{
   public function show()
{
    $user = Auth::user();
    $user->load('company', 'applications.jobPost'); // Tambahkan eager loading untuk applications

    if ($user->role->name === 'company') {
        return view('company.profile.show', compact('user'));
    } else {
        return view('user.profile.show', compact('user'));
    }
}


    public function edit()
{
    $user = Auth::user();
    $user->load('company');

    if ($user->role->name === 'company') {
        return view('company.profile.edit', compact('user'));
    } else {
        return view('user.profile.edit', compact('user'));
    }
}

    public function update(Request $request)
{
    $user = Auth::user();

    if ($user->role->name === 'company') {
        return $this->updateCompanyProfile($request, $user);
    } else {
        return $this->updateUserProfile($request, $user);
    }
}


    private function updateCompanyProfile(Request $request, $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'nisn' => 'nullable|string|max:20|unique:users,nisn,' . $user->id,
            'birth_date' => 'nullable|date',
            'short_profile' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
            'industry_id' => 'nullable|exists:industries,id',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user data
        $userData = $request->only(['name', 'email', 'phone', 'address', 'nisn', 'birth_date', 'short_profile', 'portfolio_link', 'linkedin', 'instagram', 'facebook', 'twitter', 'tiktok']);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $userData['profile_photo_path'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Handle CV upload
        if ($request->hasFile('cv')) {
            if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
                Storage::disk('public')->delete($user->cv_path);
            }
            $userData['cv_path'] = $request->file('cv')->store('cv_files', 'public');
        }

        $user->update($userData);

        // Update or create company data
        $companyData = $request->only(['company_name', 'company_email', 'company_phone', 'company_address', 'industry_id', 'description']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($user->company && $user->company->logo && Storage::disk('public')->exists($user->company->logo)) {
                Storage::disk('public')->delete($user->company->logo);
            }
            $companyData['logo'] = $request->file('logo')->store('company_logos', 'public');
        }

        if ($user->company) {
            $user->company->update($companyData);
        } else {
            $companyData['user_id'] = $user->id;
            Company::create($companyData);
        }

        return redirect()->route('profile.show')->with('success', 'Profil perusahaan berhasil diperbarui!');
    }

    private function updateUserProfile(Request $request, $user)
    {
        // Debug: Log request data
        \Log::info('Profile update request data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'nisn' => 'nullable|string|max:20|unique:users,nisn,' . $user->id,
            'birth_date' => 'nullable|date',
            'short_profile' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
            'cover_letter' => 'nullable|file|mimes:pdf|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'portfolio_link' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'tiktok' => 'nullable|url',
        ]);

        $userData = $request->only(['name', 'email', 'phone', 'address', 'nisn', 'birth_date', 'short_profile', 'portfolio_link', 'linkedin', 'instagram', 'facebook', 'twitter', 'tiktok']);

        // Debug: Log userData before update
        \Log::info('UserData to be updated:', $userData);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $userData['profile_photo_path'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Handle CV upload
        if ($request->hasFile('cv')) {
            if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
                Storage::disk('public')->delete($user->cv_path);
            }
            $userData['cv_path'] = $request->file('cv')->store('cv_files', 'public');
        }

        // Handle Cover Letter upload
        if ($request->hasFile('cover_letter')) {
            if ($user->cover_letter_path && Storage::disk('public')->exists('cover_letter_files/' . $user->cover_letter_path)) {
                Storage::disk('public')->delete('cover_letter_files/' . $user->cover_letter_path);
            }
            $originalName = $request->file('cover_letter')->getClientOriginalName();
            $extension = $request->file('cover_letter')->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;
            $request->file('cover_letter')->storeAs('cover_letter_files', $filename, 'public');
            $userData['cover_letter_path'] = $filename; // Simpan hanya nama file
        }

        // Handle company logo upload if user has company
        if ($request->hasFile('logo') && $user->company) {
            if ($user->company->logo && Storage::disk('public')->exists($user->company->logo)) {
                Storage::disk('public')->delete($user->company->logo);
            }
            $user->company->update(['logo' => $request->file('logo')->store('company_logos', 'public')]);
        }

        $user->update($userData);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    public function showUploadForm()
    {
        return view('user.profile.upload-cv');
    }

    public function uploadCv(Request $request)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();

        // Hapus CV lama jika ada
        if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
            Storage::disk('public')->delete($user->cv_path);
        }

        // Simpan file baru
        $path = $request->file('cv')->store('cv_files', 'public');

        $user->update([
            'cv_path' => $path
        ]);

        return redirect()->back()->with('success', 'CV berhasil diunggah!');
    }
}
