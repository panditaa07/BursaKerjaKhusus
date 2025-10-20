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

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|string', // Validate that photo is a base64 string
        ]);

        $user = Auth::user();
        $photoData = $request->input('photo');

        // Decode the base64 string
        // The string is in format data:image/png;base64,iVBORw0KGgo...
        @list(, $photoData) = explode(';', $photoData);
        @list(, $photoData) = explode(',', $photoData);
        $photoData = base64_decode($photoData);

        // Create a GD image resource from the decoded data
        $sourceImage = @imagecreatefromstring($photoData);

        if (!$sourceImage) {
            return response()->json(['success' => false, 'message' => 'Invalid image data.'], 400);
        }

        // Get original image dimensions
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        // Create a new true color image (the canvas)
        $destImage = imagecreatetruecolor($width, $height);

        // IMPORTANT: Enable alpha blending and save alpha channel
        imagealphablending($destImage, false);
        imagesavealpha($destImage, true);

        // Create a white background color
        $white = imagecolorallocate($destImage, 255, 255, 255);

        // Fill the canvas with the white background
        imagefill($destImage, 0, 0, $white);

        // Copy the source (transparent PNG) onto the white canvas
        imagecopy($destImage, $sourceImage, 0, 0, 0, 0, $width, $height);

        // Define path and filename for the new JPG
        $filename = 'profile_photos/' . uniqid() . '.jpg';
        $path = storage_path('app/public/' . $filename);

        // Ensure the directory exists
        Storage::disk('public')->makeDirectory('profile_photos');

        // Save the final image as a JPG
        imagejpeg($destImage, $path, 90);

        // Clean up GD resources from memory
        imagedestroy($sourceImage);
        imagedestroy($destImage);

        // Delete the old photo from storage if it exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Update user record with the new photo path
        $user->profile_photo_path = $filename;
        $user->save();

        return response()->json([
            'success' => true,
            'path' => asset('storage/' . $filename),
            'message' => 'Foto profil berhasil diperbarui.'
        ]);
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
            'company_website' => 'nullable|url',
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
        $companyData = [
            'name' => $request->company_name,
            'email' => $request->company_email,
            'address' => $request->company_address,
            'phone' => $request->company_phone,
            'website' => $request->company_website,
            'industry_id' => $request->industry_id,
            'description' => $request->description,
        ];

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
        \Log::info('[PROFILE UPDATE] Start for User ID: ' . $user->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'nisn' => 'nullable|string|max:20|unique:users,nisn,' . $user->id,
            'birth_date' => 'nullable|date',
            'short_profile' => 'nullable|string|max:500',
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

        \Log::info('[PROFILE UPDATE] Validation passed.');

        $userData = $request->only(['name', 'email', 'phone', 'address', 'nisn', 'birth_date', 'short_profile', 'portfolio_link', 'linkedin', 'instagram', 'facebook', 'twitter', 'tiktok']);

        // Handle CV upload
        if ($request->hasFile('cv')) {
            \Log::info('[PROFILE UPDATE] Uploading CV...');
            if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
                Storage::disk('public')->delete($user->cv_path);
            }
            $userData['cv_path'] = $request->file('cv')->store('cv_files', 'public');
            \Log::info('[PROFILE UPDATE] CV uploaded.');
        }

        // Handle Cover Letter upload
        if ($request->hasFile('cover_letter')) {
            \Log::info('[PROFILE UPDATE] Uploading cover letter...');
            if ($user->cover_letter_path && Storage::disk('public')->exists('cover_letter_files/' . $user->cover_letter_path)) {
                Storage::disk('public')->delete('cover_letter_files/' . $user->cover_letter_path);
            }
            $originalName = $request->file('cover_letter')->getClientOriginalName();
            $extension = $request->file('cover_letter')->getClientOriginalExtension();
            $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;
            $request->file('cover_letter')->storeAs('cover_letter_files', $filename, 'public');
            $userData['cover_letter_path'] = $filename; // Simpan hanya nama file
            \Log::info('[PROFILE UPDATE] Cover letter uploaded.');
        }

        // Handle company logo upload if user has company
        if ($request->hasFile('logo') && $user->company) {
            \Log::info('[PROFILE UPDATE] Updating company logo...');
            if ($user->company->logo && Storage::disk('public')->exists($user->company->logo)) {
                Storage::disk('public')->delete($user->company->logo);
            }
            $user->company->update(['logo' => $request->file('logo')->store('company_logos', 'public')]);
            \Log::info('[PROFILE UPDATE] Company logo updated.');
        }

        \Log::info('[PROFILE UPDATE] Preparing to update user model. Data:', $userData);
        $user->update($userData);
        \Log::info('[PROFILE UPDATE] User model update finished. Redirecting...');

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

    public function previewCoverLetter()
    {
        $user = Auth::user();

        if (!$user->cover_letter_path) {
            abort(404, 'Cover letter not found.');
        }

        $filePath = storage_path('app/public/cover_letter_files/' . $user->cover_letter_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->file($filePath);
    }

    public function previewCv()
    {
        $user = Auth::user();

        if (!$user->cv_path) {
            abort(404, 'CV not found.');
        }

        $filePath = storage_path('app/public/' . $user->cv_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->file($filePath);
    }
}
