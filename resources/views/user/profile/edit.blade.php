@extends('layouts.dashboard')

@section('title', 'Edit Profil Saya')

@section('content')
<div class="container">
    <h1>Edit Profil Saya</h1>

    <div class="card">
        <div class="card-header">
            <h3>Informasi Profil</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                        </div>
                        @if(Auth::user()->role->name !== 'company')
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NIK/NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn', Auth::user()->nisn) }}">
                        </div>
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date', Auth::user()->birth_date) }}">
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="short_profile" class="form-label">Profil Singkat</label>
                            <textarea class="form-control" id="short_profile" name="short_profile" rows="5">{{ old('short_profile', Auth::user()->short_profile) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="portfolio_link" class="form-label">Portfolio Link</label>
                            <input type="url" class="form-control" id="portfolio_link" name="portfolio_link" value="{{ old('portfolio_link', Auth::user()->portfolio_link) }}">
                        </div>
                        <div class="mb-3">
                            <label for="linkedin" class="form-label">LinkedIn</label>
                            <input type="url" class="form-control" id="linkedin" name="linkedin" value="{{ old('linkedin', Auth::user()->linkedin) }}">
                        </div>
                        <div class="mb-3">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', Auth::user()->instagram) }}">
                        </div>
                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', Auth::user()->facebook) }}">
                        </div>
                        <div class="mb-3">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="url" class="form-control" id="twitter" name="twitter" value="{{ old('twitter', Auth::user()->twitter) }}">
                        </div>
                        <div class="mb-3">
                            <label for="tiktok" class="form-label">TikTok</label>
                            <input type="url" class="form-control" id="tiktok" name="tiktok" value="{{ old('tiktok', Auth::user()->tiktok) }}">
                        </div>
                        @if(Auth::user()->role->name !== 'company')
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Foto Profil</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/png, image/jpeg">
                            @if(Auth::user()->profile_photo_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil" style="max-width: 100px;">
                                    <p class="text-muted">Foto saat ini</p>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="cv" class="form-label">CV</label>
                            <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx">
                            <small class="form-text text-muted">Format: PDF, DOC, DOCX. Maksimal 2MB.</small>
                            @if(Auth::user()->cv_path)
                                <div class="mt-2">
                                    <a href="{{ Storage::url(Auth::user()->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat CV saat ini</a>
                                </div>
                            @else
                                <p class="text-muted">Belum ada CV yang diunggah.</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label">Surat Lamaran</label>
                            <input type="file" class="form-control" id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx">
                            <small class="form-text text-muted">Format: PDF, DOC, DOCX. Maksimal 2MB.</small>

                            @if(Auth::user()->cover_letter_path && Storage::exists(Auth::user()->cover_letter_path))
                                <div class="mt-2">
                                    <a href="{{ Storage::url(Auth::user()->cover_letter_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                        Lihat Surat Lamaran saat ini
                                    </a>
                                </div>
                            @else
                                <p class="text-muted">Belum ada Surat Lamaran yang diunggah.</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
