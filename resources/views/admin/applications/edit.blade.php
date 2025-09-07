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
                    <label for="phone" class="form-label">Nomor Telepon</label>
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
                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ $application->user ? $application->user->birth_date : '' }}">
                    @error('birth_date')
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
                    <label for="social_media_link" class="form-label">Link Sosial Media</label>
                    <input type="url" name="social_media_link" id="social_media_link" class="form-control" value="{{ $application->user ? $application->user->social_media_link : '' }}">
                    @error('social_media_link')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="company_name" class="form-label">Nama Perusahaan</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $application->jobPost->company->name ?? '' }}">
                    <small class="text-muted">Nama perusahaan dari lowongan yang dilamar</small>
                </div>
            </div>

            <div class="col-md-6">
                <h5>Informasi Lamaran</h5>

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
                    <label for="application_letter_path" class="form-label">Upload Surat Lamaran Baru (Opsional)</label>
                    <input type="file" name="application_letter_path" id="application_letter_path" class="form-control" accept=".pdf,.doc,.docx">
                    @if($application->application_letter_path)
                        <small class="text-muted">Surat Lamaran saat ini: <a href="{{ asset('storage/' . $application->application_letter_path) }}" target="_blank">Download</a></small>
                    @endif
                    @error('application_letter_path')
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

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.applications.all') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
