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
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NIK/NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn', Auth::user()->nisn) }}">
                        </div>
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date', Auth::user()->birth_date) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="short_profile" class="form-label">Profil Singkat</label>
                            <textarea class="form-control" id="short_profile" name="short_profile" rows="5">{{ old('short_profile', Auth::user()->short_profile) }}</textarea>
                        </div>
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
                            <label for="logo" class="form-label">Logo Perusahaan</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            @if(Auth::user()->company && Auth::user()->company->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo Perusahaan" style="max-width: 100px;">
                                    <p class="text-muted">Logo saat ini</p>
                                </div>
                            @else
                                <p class="text-muted">Belum ada logo perusahaan yang diunggah.</p>
                            @endif
                        </div>

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
</create_file>
