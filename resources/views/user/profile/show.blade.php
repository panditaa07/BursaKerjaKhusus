@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')

<div class="container profile-container fade-in-row">
    <h1>Profil Saya</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Informasi Profil</h3>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-pencil-alt me-1"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>No. HP:</strong> {{ Auth::user()->phone ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ Auth::user()->address ?? '-' }}</p>
                    @if(Auth::user()->role->name !== 'company')
                    <p><strong>NIK/NISN:</strong> {{ Auth::user()->nisn ?? '-' }}</p>
                    @endif
                    @if(Auth::user()->role->name !== 'company')
                    <p><strong>Tanggal Lahir:</strong> {{ Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('d/m/Y') : '-' }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <p><strong>Profil Singkat:</strong> {{ Auth::user()->short_profile ?? '-' }}</p>
                    <p><strong>Portfolio:</strong> {!! Auth::user()->portfolio_link ? '<a href="' . Auth::user()->portfolio_link . '" target="_blank">' . Auth::user()->portfolio_link . '</a>' : '-' !!}</p>
                    <p><strong>LinkedIn:</strong> {!! Auth::user()->linkedin ? '<a href="' . Auth::user()->linkedin . '" target="_blank">' . Auth::user()->linkedin . '</a>' : '-' !!}</p>
                    <p><strong>Instagram:</strong> {!! Auth::user()->instagram ? '<a href="' . Auth::user()->instagram . '" target="_blank">' . Auth::user()->instagram . '</a>' : '-' !!}</p>
                    <p><strong>Facebook:</strong> {!! Auth::user()->facebook ? '<a href="' . Auth::user()->facebook . '" target="_blank">' . Auth::user()->facebook . '</a>' : '-' !!}</p>
                    <p><strong>Twitter:</strong> {!! Auth::user()->twitter ? '<a href="' . Auth::user()->twitter . '" target="_blank">' . Auth::user()->twitter . '</a>' : '-' !!}</p>
                    <p><strong>TikTok:</strong> {!! Auth::user()->tiktok ? '<a href="' . Auth::user()->tiktok . '" target="_blank">' . Auth::user()->tiktok . '</a>' : '-' !!}</p>
                    <p><strong>Foto Profil:</strong><br>
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil" style="max-width: 100px;">
                        @else
                            -
                        @endif
                    </p>
                    @if(Auth::user()->role->name === 'company')
                    <p><strong>Logo Perusahaan:</strong><br>
                        @if(Auth::user()->company && Auth::user()->company->logo)
                            <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo Perusahaan" style="max-width: 100px;">
                        @else
                            <span class="text-muted">Belum ada logo perusahaan yang diunggah.</span>
                        @endif
                    </p>
                    @endif
                    @if(Auth::user()->role->name !== 'company')
                    <p><strong>CV:</strong>
                        @if(Auth::user()->cv_path)
                           <a href="{{ asset('storage/' . Auth::user()->cv_path) }}" 
                            target="_blank" 
                            class="btn btn-cv btn-sm text-white mt-1">
                                <i class="fas fa-file-pdf me-1"></i> Lihat CV
                            </a>

                        @else
                            Belum diunggah
                        @endif
                    </p>
                    @endif
                    @if(Auth::user()->role->name !== 'company')
                    <p><strong>Surat Lamaran:</strong>
                        @if(Auth::user()->applications->isNotEmpty())
                            <ul>
                                @foreach(Auth::user()->applications as $application)
                                    @if($application->cover_letter_path)
                                        <li><a href="{{ asset('storage/' . $application->cover_letter_path) }}" target="_blank" download>Surat Lamaran untuk {{ $application->jobPost->title }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            Tidak ada surat lamaran
                        @endif
                    </p>
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route(match(auth()->user()->role ?? 'user') { 'admin' => 'admin.dashboard.index', 'company' => 'company.dashboard.index', default => 'user.dashboard.index' }) }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/editprofile-user.js') }}"></script>
@endsection