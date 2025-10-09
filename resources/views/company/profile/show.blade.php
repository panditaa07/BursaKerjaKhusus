@extends('layouts.dashboard')

@section('title', 'Profil Perusahaan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profilcompany.css') }}">
@endpush

@section('content')
<div class="container">
    <h1>Profil Perusahaan</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Informasi Perusahaan</h3>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-pencil-alt me-1"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <!-- Profile Photo Section -->
            <div class="text-center mb-4">
                <h5 class="mb-3">
                    <i class="fas fa-user-circle text-primary"></i>
                    Foto Profil PIC
                </h5>
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                         alt="Foto Profil {{ Auth::user()->name }}"
                         class="rounded-circle border"
                         style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important; border-color: #dee2e6 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                @else
                    <div class="rounded-circle border bg-light d-inline-flex align-items-center justify-content-center"
                         style="width: 120px; height: 120px; border-width: 4px !important; border-color: #dee2e6 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        <i class="fas fa-user text-muted fa-3x"></i>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama PIC:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email PIC:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>No. HP PIC:</strong> {{ Auth::user()->phone ?? '-' }}</p>
                    <p><strong>Alamat PIC:</strong> {{ Auth::user()->address ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nama Perusahaan:</strong> {{ Auth::user()->company->name ?? '-' }}</p>
                    <p><strong>Alamat Perusahaan:</strong> {{ Auth::user()->company->address ?? '-' }}</p>
                    <p><strong>No. Telp Perusahaan:</strong> {{ Auth::user()->company->phone ?? '-' }}</p>
                    <p><strong>Email Kontak:</strong> {{ Auth::user()->company->email ?? '-' }}</p>
                    <p><strong>Industri:</strong> {{ Auth::user()->company->industry->name ?? '-' }}</p>
                    <p><strong>Deskripsi:</strong> {{ Auth::user()->company->description ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-3">
                <p><strong>Logo Perusahaan:</strong><br>
                    @if(Auth::user()->company && Auth::user()->company->logo)
                        <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo" style="max-width: 150px;">
                    @else
                        <span class="text-muted">Belum ada logo perusahaan yang diunggah.</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
