@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="container profile-container fade-in-row">

    {{-- HEADER PROFIL --}}
    <div class="profile-header">
        <div class="profile-top">
            {{-- FOTO PROFIL / AVATAR --}}
            <div class="avatar">
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                @endif
            </div>

            <div class="profile-info text-center">
                <h1>{{ Auth::user()->name }}</h1>
                <p>{{ Auth::user()->short_profile ?? 'Pengguna BKK OPAT' }}</p>
                <p>📍 {{ Auth::user()->address ?? 'Alamat belum diisi' }}</p>
                <span class="status-badge">
                    {{ Auth::user()->role->name === 'company' ? 'Perusahaan' : 'Pencari Kerja' }}
                </span>
            </div>

            <div class="edit-btn">
                <a href="{{ route('profile.edit') }}" class="btn-edit">
                    <i class="fas fa-pencil-alt"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    {{-- INFORMASI PROFIL --}}
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
            <div class="info-item"><span>LinkedIn:</span>
                {!! Auth::user()->linkedin ? '<a href="' . Auth::user()->linkedin . '" target="_blank">' . Auth::user()->linkedin . '</a>' : '-' !!}
            </div>
            <div class="info-item"><span>Portfolio:</span>
                {!! Auth::user()->portfolio_link ? '<a href="' . Auth::user()->portfolio_link . '" target="_blank">' . Auth::user()->portfolio_link . '</a>' : '-' !!}
            </div>
            <div class="info-item"><span>Instagram:</span>
                {!! Auth::user()->instagram ? '<a href="' . Auth::user()->instagram . '" target="_blank">' . Auth::user()->instagram . '</a>' : '-' !!}
            </div>
            <div class="info-item"><span>Facebook:</span>
                {!! Auth::user()->facebook ? '<a href="' . Auth::user()->facebook . '" target="_blank">' . Auth::user()->facebook . '</a>' : '-' !!}
            </div>
            <div class="info-item"><span>Twitter:</span>
                {!! Auth::user()->twitter ? '<a href="' . Auth::user()->twitter . '" target="_blank">' . Auth::user()->twitter . '</a>' : '-' !!}
            </div>
            <div class="info-item"><span>TikTok:</span>
                {!! Auth::user()->tiktok ? '<a href="' . Auth::user()->tiktok . '" target="_blank">' . Auth::user()->tiktok . '</a>' : '-' !!}
            </div>
        </div>
    </div>

    {{-- FILE & DOKUMEN --}}
    <div class="section">
        <h2>Dokumen</h2>

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

        @if(Auth::user()->role->name === 'company')
        <div class="info-item">
            <span>Logo Perusahaan:</span><br>
            @if(Auth::user()->company && Auth::user()->company->logo)
                <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo Perusahaan" class="company-logo">
            @else
                <span class="text-muted">Belum ada logo perusahaan.</span>
            @endif
        </div>
        @endif
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="back-btn">
        <a href="{{ route(match(auth()->user()->role ?? 'user') {
            'admin' => 'admin.dashboard.index',
            'company' => 'company.dashboard.index',
            default => 'user.dashboard.index'
        }) }}" class="btn-back">Kembali</a>
    </div>
</div>

<script src="{{ asset('js/profile.js') }}"></script>
@endsection
