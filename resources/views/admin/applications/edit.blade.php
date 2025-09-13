@extends('layouts.dashboard')
@section('title', 'Edit Pelamar')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit Pelamar</h1>

    <form action="{{ route('admin.applications.update', $application->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-md-6">
                <h5>Informasi Pribadi</h5>

                <div class="mb-3 text-center">
                    <img src="{{ $application->user && $application->user->profile_photo_path ? asset('storage/' . $application->user->profile_photo_path) : asset('images/default-avatar.png') }}"
                         alt="Foto Profil"
                         class="rounded-circle mb-3"
                         style="width: 100px; height: 100px; object-fit: cover;">
                    <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control" accept="image/*">
                    @error('profile_photo_path')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $application->user ? $application->user->name : '' }}" required>
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $application->user ? $application->user->email : '' }}" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ $application->user && $application->user->birth_date ? \Carbon\Carbon::parse($application->user->birth_date)->format('Y-m-d') : '' }}">
                    @error('birth_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">No. HP</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $application->user ? $application->user->phone : '' }}">
                    @error('phone')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nisn" class="form-label">NIK/NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control" value="{{ $application->user ? $application->user->nisn : '' }}">
                    @error('nisn')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" id="address" class="form-control" rows="3">{{ $application->user ? $application->user->address : '' }}</textarea>
                    @error('address')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="short_profile" class="form-label">Profil Singkat</label>
                    <textarea name="short_profile" id="short_profile" class="form-control" rows="3">{{ $application->user ? $application->user->short_profile : '' }}</textarea>
                    @error('short_profile')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Link Sosial Media</label>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                <input type="url" name="facebook" id="facebook" class="form-control" placeholder="Facebook URL" value="{{ $application->user ? $application->user->facebook : '' }}">
                            </div>
                            @error('facebook')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                <input type="url" name="instagram" id="instagram" class="form-control" placeholder="Instagram URL" value="{{ $application->user ? $application->user->instagram : '' }}">
                            </div>
                            @error('instagram')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                <input type="url" name="linkedin" id="linkedin" class="form-control" placeholder="LinkedIn URL" value="{{ $application->user ? $application->user->linkedin : '' }}">
                            </div>
                            @error('linkedin')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                <input type="url" name="twitter" id="twitter" class="form-control" placeholder="Twitter URL" value="{{ $application->user ? $application->user->twitter : '' }}">
                            </div>
                            @error('twitter')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                <input type="url" name="tiktok" id="tiktok" class="form-control" placeholder="TikTok URL" value="{{ $application->user ? $application->user->tiktok : '' }}">
                            </div>
                            @error('tiktok')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h5>Informasi Lamaran</h5>

                <div class="mb-3">
                    <label for="job_post_id" class="form-label">Lowongan (Posisi)</label>
                    <select name="job_post_id" id="job_post_id" class="form-select" required>
                        @foreach($jobPosts as $jobPost)
                            <option value="{{ $jobPost->id }}" {{ $application->job_post_id == $jobPost->id ? 'selected' : '' }}>
                                {{ $jobPost->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('job_post_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="applied_at" class="form-label">Tanggal Melamar</label>
                    <input type="date" name="applied_at" id="applied_at" class="form-control" value="{{ $application->applied_at ? \Carbon\Carbon::parse($application->applied_at)->format('Y-m-d') : $application->created_at->format('Y-m-d') }}" required>
                    @error('applied_at')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="test1" {{ $application->status == 'test1' ? 'selected' : '' }}>Test 1</option>
                        <option value="test2" {{ $application->status == 'test2' ? 'selected' : '' }}>Test 2</option>
                        <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cv_path" class="form-label">Upload CV Baru (Opsional)</label>
                    <input type="file" name="cv_path" id="cv_path" class="form-control" accept=".pdf,.doc,.docx">
                    @if($application->cv_path)
                        <small class="text-muted">CV saat ini: <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank">Download</a></small>
                    @endif
                    @error('cv_path')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cover_letter" class="form-label">Upload Surat Lamaran Baru (Opsional)</label>
                    <input type="file" name="cover_letter" id="cover_letter" class="form-control" accept=".pdf,.doc,.docx">
                    @if($application->cover_letter)
                        <small class="text-muted">Surat Lamaran saat ini: <a href="{{ asset('storage/' . $application->cover_letter) }}" target="_blank">Download</a></small>
                    @endif
                    @error('cover_letter')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Lamaran</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ $application->description ?? '' }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
