@extends('layouts.dashboard')

@section('title', 'Edit Profil Perusahaan')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/editprofilcomp.css') }}">
@endpush

@section('content')
<div class="container">
    <h1>Edit Profil Perusahaan</h1>

    <div class="card">
        <div class="card-header">
            <h3>Informasi Perusahaan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h5>Data PIC</h5>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama PIC</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email PIC</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. HP PIC</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat PIC</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Foto Profil PIC</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                            @if(Auth::user()->profile_photo_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil" style="max-width: 100px; border-radius: 50%;">
                                    <p class="text-muted">Foto profil saat ini</p>
                                </div>
                            @else
                                <p class="text-muted">Belum ada foto profil yang diunggah.</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Data Perusahaan</h5>
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', Auth::user()->company->name ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="company_email" class="form-label">Email Kontak</label>
                            <input type="email" class="form-control" id="company_email" name="company_email" value="{{ old('company_email', Auth::user()->company->email ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="company_phone" class="form-label">No. Telp Perusahaan</label>
                            <input type="text" class="form-control" id="company_phone" name="company_phone" value="{{ old('company_phone', Auth::user()->company->phone ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="company_address" class="form-label">Alamat Perusahaan</label>
                            <textarea class="form-control" id="company_address" name="company_address" rows="3">{{ old('company_address', Auth::user()->company->address ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="industry_id" class="form-label">Industri</label>
                            <select class="form-select" id="industry_id" name="industry_id">
                                <option value="">Pilih Industri</option>
                                @foreach(\App\Models\Industry::all() as $industry)
                                    <option value="{{ $industry->id }}" {{ old('industry_id', Auth::user()->company->industry_id ?? '') == $industry->id ? 'selected' : '' }}>
                                        {{ $industry->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', Auth::user()->company->description ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo Perusahaan</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                            @if(Auth::user()->company && Auth::user()->company->logo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo" style="max-width: 100px;">
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