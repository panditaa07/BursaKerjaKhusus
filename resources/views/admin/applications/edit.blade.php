@extends('layouts.dashboard')
@section('title', 'Edit Pelamar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}" />

<div class="container mx-auto px-4 py-4">
    <div class="page-title-wrapper d-flex align-items-center justify-content-center gap-2">
        <h1 class="page-title">Update Data Pelamar</h1>
    </div><br>

        <form class="form-container"
              action="{{ route('admin.applications.update', $application->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="section-header">
                        <h5><i class="fas fa-user"></i> Informasi Pribadi</h5>
                    </div>

                    {{-- Foto Profil --}}
                    <div class="profile-photo-container">
                        <img src="{{ $application->user && $application->user->profile_photo_path
                                    ? asset('storage/' . $application->user->profile_photo_path)
                                    : asset('images/default-avatar.png') }}"
                             alt="Foto Profil" class="profile-photo">
                        <input type="file" name="profile_photo_path" class="form-control" accept="image/*">
                        @error('profile_photo_path')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="form-group floating-label">
                        <input type="text" name="name" class="form-control"
                               placeholder=" " value="{{ old('name', $application->user?->name ?? '') }}" required>
                        <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group floating-label">
                        <input type="email" name="email" class="form-control" placeholder=" "
                               value="{{ old('email', $application->user?->email ?? '') }}" required>
                        <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-calendar"></i> Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control"
                               value="{{ old('birth_date', $application->user?->birth_date ? \Carbon\Carbon::parse($application->user->birth_date)->format('Y-m-d') : '') }}">
                        @error('birth_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="form-group floating-label">
                        <input type="text" name="phone" class="form-control" placeholder=" "
                               value="{{ old('phone', $application->user?->phone ?? '') }}">
                        <label class="form-label"><i class="fas fa-phone"></i> No. HP</label>
                        @error('phone')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NISN --}}
                    <div class="form-group floating-label">
                        <input type="text" name="nisn" class="form-control" placeholder=" "
                               value="{{ old('nisn', $application->user?->nisn ?? '') }}">
                        <label class="form-label"><i class="fas fa-id-card"></i> NIK/NISN</label>
                        @error('nisn')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $application->user?->address ?? '') }}</textarea>
                        @error('address')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Profil Singkat --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user-circle"></i> Profil Singkat</label>
                        <textarea name="short_profile" class="form-control" rows="3">{{ old('short_profile', $application->user?->short_profile ?? '') }}</textarea>
                        @error('short_profile')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sosial Media --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-share-alt"></i> Link Sosial Media</label>
                        <div class="social-media-grid">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                <input type="url" name="facebook" class="form-control"
                                       value="{{ old('facebook', $application->user?->facebook ?? '') }}" placeholder="Facebook URL">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                <input type="url" name="instagram" class="form-control"
                                       value="{{ old('instagram', $application->user?->instagram ?? '') }}" placeholder="Instagram URL">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                <input type="url" name="linkedin" class="form-control"
                                       value="{{ old('linkedin', $application->user?->linkedin ?? '') }}" placeholder="LinkedIn URL">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                <input type="url" name="twitter" class="form-control"
                                       value="{{ old('twitter', $application->user?->twitter ?? '') }}" placeholder="Twitter URL">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                <input type="url" name="tiktok" class="form-control"
                                       value="{{ old('tiktok', $application->user?->tiktok ?? '') }}" placeholder="TikTok URL">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="section-header">
                        <h5><i class="fas fa-briefcase"></i> Informasi Lamaran</h5>
                    </div>

                    {{-- Lowongan --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-bullhorn"></i> Lowongan (Posisi)</label>
                        <select name="job_post_id" class="form-control form-select" required>
                            <option value="">Pilih Posisi...</option>
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

                    {{-- Tanggal Melamar --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-calendar-plus"></i> Tanggal Melamar</label>
                        <input type="date" name="applied_at" class="form-control"
                               value="{{ old('applied_at', $application->applied_at ? \Carbon\Carbon::parse($application->applied_at)->format('Y-m-d') : $application->created_at->format('Y-m-d')) }}" required>
                        @error('applied_at')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-flag"></i> Status</label>
                        <select name="status" class="form-control form-select" required>
                            <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Menunggu</option>
                            <option value="test1" {{ $application->status == 'test1' ? 'selected' : '' }}>Test 1</option>
                            <option value="test2" {{ $application->status == 'test2' ? 'selected' : '' }}>Test 2</option>
                            <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Wawancara</option>
                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <span class="status-badge status-{{ $application->status }}">
                            <i class="fas fa-paper-plane"></i> {{ $application->status_display }}
                        </span>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CV --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-file-pdf"></i> Upload CV Baru (Opsional)</label>
                        <input type="file" name="cv_path" class="form-control" accept=".pdf">
                        @if($application->cv_path)
                            <div class="file-info">
                                <i class="fas fa-file-pdf"></i>
                                <span>CV saat ini: <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank">Download CV</a></span>
                            </div>
                        @endif
                    </div>

                    {{-- Surat Lamaran --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-file-alt"></i> Upload Surat Lamaran Baru (Opsional)</label>
                        <input type="file" name="cover_letter" class="form-control" accept=".pdf">
                        @if($application->cover_letter)
                            <div class="file-info">
                                <i class="fas fa-file-alt"></i>
                                <span>Surat Lamaran saat ini: <a href="{{ asset('storage/' . $application->cover_letter) }}" target="_blank">Download Surat</a></span>
                            </div>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-comment-alt"></i> Deskripsi Lamaran</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $application->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/edit.js') }}"></script>
@endsection
