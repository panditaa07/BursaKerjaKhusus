@extends('layouts.dashboard')

@section('title', 'Edit Profil Saya')

@section('content')
<link rel="stylesheet" href="{{ asset('css/editprofile-user.css') }}">

<div class="container">
    <div class="header">
        <h1>Edit Profil</h1>
    </div>

    <div class="profile-card">
        <div class="photo-section">
            <div class="photo-wrapper">
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                         alt="Foto Profil" class="profile-photo-img">
                @else
                    <div class="profile-photo">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            <label class="upload-btn">
                Upload Foto
                <input type="file" id="profile_photo" name="profile_photo" accept="image/png, image/jpeg" hidden>
            </label>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="address" value="{{ old('address', Auth::user()->address) }}">
                </div>
            </div>

            @if(Auth::user()->role->name !== 'company')
            <div class="form-row">
                <div class="form-group">
                    <label>NIK/NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn', Auth::user()->nisn) }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', Auth::user()->birth_date) }}">
                </div>
            </div>
            @endif

            <div class="form-group">
                <label>Profil Singkat</label>
                <textarea name="short_profile" rows="4">{{ old('short_profile', Auth::user()->short_profile) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Portfolio Link</label>
                    <input type="url" name="portfolio_link" value="{{ old('portfolio_link', Auth::user()->portfolio_link) }}">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="url" name="linkedin" value="{{ old('linkedin', Auth::user()->linkedin) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram', Auth::user()->instagram) }}">
                </div>
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="url" name="facebook" value="{{ old('facebook', Auth::user()->facebook) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Twitter</label>
                    <input type="url" name="twitter" value="{{ old('twitter', Auth::user()->twitter) }}">
                </div>
                <div class="form-group">
                    <label>TikTok</label>
                    <input type="url" name="tiktok" value="{{ old('tiktok', Auth::user()->tiktok) }}">
                </div>
            </div>

            @if(Auth::user()->role->name !== 'company')
            <div class="form-group">
                <label>Upload CV</label>
                <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx">
                @if(Auth::user()->cv_path)
                    <p class="current-file">CV saat ini: 
                        <a href="{{ Storage::url(Auth::user()->cv_path) }}" target="_blank">Lihat</a>
                    </p>
                @endif
            </div>
            @endif

            @if(Auth::user()->role->name !== 'company')

            <div class="form-group">
                <label for="cover_letter">Upload Surat Lamaran</label>
                <input type="file" id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx">
                @if(Auth::user()->cover_letter_path)
                    <p class="current-file">Surat Lamaran saat ini: 
                        <a href="{{ asset('storage/cover_letter_files/' . Auth::user()->cover_letter_path) }}" target="_blank">Lihat</a>
                    </p>
                @endif
            </div>
@endif

            <div class="btn-group">
                <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/editprofile-user.js') }}"></script>
@endsection
