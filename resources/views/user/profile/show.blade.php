@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
<div class="container profile-container fade-in-row">

   {{-- HEADER PROFIL BARU (FOTO KIRI, INFO KANAN) --}}
<div class="profile-header">
    <div class="profile-content">
        {{-- FOTO PROFIL / AVATAR --}}
        <div class="avatar-large">
            @if(Auth::user()->profile_photo_path)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil">
            @else
                <span>{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
            @endif
        </div>

        {{-- INFO PROFIL --}}
        <div class="profile-details">
            <h1>{{ Auth::user()->name }}</h1>
            <p>{{ Auth::user()->short_profile ?? 'Pengguna BKK OPAT' }}</p>
            <p>📍 {{ Auth::user()->address ?? 'Alamat belum diisi' }}</p>
            <span class="status-badge">
                {{ Auth::user()->role->name === 'company' ? 'Perusahaan' : 'Pencari Kerja' }}
            </span>

            <div class="edit-btn-inline">
                <a href="{{ route('profile.edit') }}" class="btn-edit">
                    <i class="fas fa-pencil-alt"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>

    <div class="section">
    <h2>Informasi Pribadi</h2>
    <div class="info-grid">
        <div class="info-item"><span>Email:</span> {{ Auth::user()->email }}</div>
        <div class="info-item"><span>No. HP:</span> {{ Auth::user()->phone ?? '-' }}</div>

        @if(Auth::user()->role->name !== 'company')
            <div class="info-item"><span>NIK/NISN:</span> {{ Auth::user()->nisn ?? '-' }}</div>
            <div class="info-item"><span>Tanggal Lahir:</span> 
                {{ Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('d/m/Y') : '-' }}
            </div>
        @endif


        <div class="info-item">
            <span>Sosial Media:</span>
            <div class="social-buttons">
                @if(Auth::user()->facebook)
                    <a href="{{ Auth::user()->facebook }}" class="social-btn social-btn-facebook" target="_blank" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                @endif
                @if(Auth::user()->instagram)
                    <a href="{{ Auth::user()->instagram }}" class="social-btn social-btn-instagram" target="_blank" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif
                @if(Auth::user()->linkedin)
                    <a href="{{ Auth::user()->linkedin }}" class="social-btn social-btn-linkedin" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                @endif
                @if(Auth::user()->twitter)
                    <a href="{{ Auth::user()->twitter }}" class="social-btn social-btn-twitter" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                @endif
                @if(Auth::user()->tiktok)
                    <a href="{{ Auth::user()->tiktok }}" class="social-btn social-btn-tiktok" target="_blank" title="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                @endif
            </div>
        </div>

        @if(Auth::user()->portfolio_link)
    <div class="info-item">
        <span>Portofolio:</span> 
        <a href="{{ Auth::user()->portfolio_link }}" target="_blank" class="portfolio-text-link">
            Portofolio
        </a>
    </div>
@endif

{{-- DOKUMEN LANGSUNG DI SINI --}}
<div class="info-item full-width no-gap-top">
    <h3>Dokumen</h3>

    @if(Auth::user()->role->name !== 'company')
        <div class="info-item">
            <span>CV:</span>
            @if(Auth::user()->cv_path)
                <a href="{{ asset('storage/' . Auth::user()->cv_path) }}" target="_blank" class="btn-cv">
                    <i class="fas fa-file-pdf"></i> Lihat CV
                </a>
            @else
                Belum diunggah
            @endif
        </div>

        <div class="info-item">
            <span>Surat Lamaran:</span>
            @if(Auth::user()->cover_letter_path)
                <a href="{{ asset('storage/cover_letter_files/' . Auth::user()->cover_letter_path) }}" target="_blank" class="btn-cv">
                    <i class="fas fa-file-alt"></i> Lihat Surat Lamaran
                </a>
            @else
                Belum diunggah
            @endif
        </div>
    @endif
</div>

{{-- TOMBOL KEMBALI --}}
<div class="back-btn-inline">
    <a href="{{ route(match(auth()->user()->role ?? 'user') {
        'admin' => 'admin.dashboard.index',
        'company' => 'company.dashboard.index',
        default => 'user.dashboard.index'
    }) }}" class="btn-back">Kembali</a>
</div>
<script src="{{ asset('js/profile.js') }}"></script>
@endsection
