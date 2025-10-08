@extends('layouts.dashboard')
@section('title', 'Detail Pelamar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="container-fluid">
    <div class="page-header">
        <h1>Detail Pelamar</h1>
    </div>

    <!-- Profile Photo Section -->
    <div class="profile-section">
        <div class="profile-photo-container">
            <img src="{{ $application->user && $application->user->profile_photo_path ? asset('storage/' . $application->user->profile_photo_path) : asset('images/default-avatar.png') }}"
                 alt="Foto Profil"
                 class="profile-photo">
        </div>
    </div>

    <div class="modern-card">
        <div class="card-body">
            <div class="row">
                <!-- Informasi Pribadi -->
                <div class="col-md-6">
                    <h6 class="section-header">
                        <i class="fas fa-user me-2"></i>
                        Informasi Pribadi
                    </h6>

                    <div class="info-item">
                        <span class="info-label">NIK/NISN:</span>
                        <span class="info-value">{{ $application->user ? $application->user->nisn : '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Nama Lengkap:</span>
                        <span class="info-value">{{ $application->user ? $application->user->name : '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $application->user ? $application->user->email : '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Tanggal Lahir:</span>
                        <span class="info-value">
                            {{ $application->user && $application->user->birth_date ? \Carbon\Carbon::parse($application->user->birth_date)->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">No. HP:</span>
                        <span class="info-value">{{ $application->user ? $application->user->phone : '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Alamat:</span>
                        <span class="info-value">{{ $application->user ? $application->user->address : '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Profil Singkat:</span>
                        <span class="info-value">{{ $application->user ? $application->user->short_profile : '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Sosial Media:</span>
                        <div class="social-buttons">
                            @if($application->user)
                                @if($application->user->facebook)
                                    <a href="{{ $application->user->facebook }}" class="social-btn social-btn-facebook" target="_blank" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if($application->user->instagram)
                                    <a href="{{ $application->user->instagram }}" class="social-btn social-btn-instagram" target="_blank" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if($application->user->linkedin)
                                    <a href="{{ $application->user->linkedin }}" class="social-btn social-btn-linkedin" target="_blank" title="LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                @endif
                                @if($application->user->twitter)
                                    <a href="{{ $application->user->twitter }}" class="social-btn social-btn-twitter" target="_blank" title="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                @if($application->user->tiktok)
                                    <a href="{{ $application->user->tiktok }}" class="social-btn social-btn-tiktok" target="_blank" title="TikTok">
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informasi Lamaran -->
                <div class="col-md-6">
                    <h6 class="section-header">
                        <i class="fas fa-briefcase me-2"></i>
                        Informasi Lamaran
                    </h6>

                    <div class="info-item">
                        <span class="info-label">Lowongan:</span>
                        <span class="info-value">{{ $application->jobPost->title ?? '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="status-badge 
                            {{ $application->status == 'pending' ? 'status-pending' : ($application->status == 'approved' ? 'status-success' : 'status-danger') }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Tanggal Melamar:</span>
                        <span class="info-value">
                            @php
                                $appliedAt = $application->applied_at;
                                if (is_string($appliedAt)) {
                                    $appliedAt = \Carbon\Carbon::parse($appliedAt);
                                }
                            @endphp
                            {{ $appliedAt ? $appliedAt->format('d M Y') : $application->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Deskripsi:</span>
                        <span class="info-value">{{ $application->description ?? 'Tidak ada deskripsi' }}</span>
                    </div>

                    @if($application->cv_path)
                        <div class="info-item">
                            <span class="info-label">CV:</span>
                            <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="download-link">
                                <i class="fas fa-download"></i> Download CV
                            </a>
                        </div>
                    @endif

                    @if($application->cover_letter)
                        <div class="info-item">
                            <span class="info-label">Surat Lamaran:</span>
                            <a href="{{ asset('storage/' . $application->cover_letter) }}" target="_blank" class="download-link">
                                <i class="fas fa-download"></i> Download Surat Lamaran
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<div class="d-flex gap-2 mt-4">
    <!-- Tombol kembali ke daftar -->
    <a href="{{ url('/admin/dashboard/pelamar') }}" class="btn-custom back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelamar
    </a>
    <a href="{{ url('/admin/dashboard/pelamar/bulanini') }}" class="btn-custom back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelamar Bulan Ini
    </a>
    <!-- Tombol edit pelamar -->
    <a href="{{ route('admin.applications.edit', $application->id) }}" class="btn-custom edit">
        <i class="fas fa-edit"></i> Edit Pelamar
    </a>
</div>

<script src="{{ asset('js/show.js') }}"></script>
@endsection
