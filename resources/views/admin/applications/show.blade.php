@extends('layouts.dashboard')
@section('title', 'Detail Pelamar')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Detail Pelamar</h1>

    <!-- Profile Photo Section -->
    <div class="mb-4 text-center">
        <img src="{{ $application->user && $application->user->profile_photo_path ? asset('storage/' . $application->user->profile_photo_path) : asset('images/default-avatar.png') }}"
             alt="Foto Profil"
             class="rounded-circle"
             style="width: 100px; height: 100px; object-fit: cover;">
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6>Informasi Pribadi</h6>
                    <p><strong>NIK/NISN:</strong> {{ $application->user ? $application->user->nisn : '-' }}</p>
                    <p><strong>Nama Lengkap:</strong> {{ $application->user ? $application->user->name : '-' }}</p>
                    <p><strong>Email:</strong> {{ $application->user ? $application->user->email : '-' }}</p>
                    <p><strong>Tanggal Lahir:</strong> {{ $application->user && $application->user->birth_date ? \Carbon\Carbon::parse($application->user->birth_date)->format('d M Y') : '-' }}</p>
                    <p><strong>No. HP:</strong> {{ $application->user ? $application->user->phone : '-' }}</p>
                    <p><strong>Alamat:</strong> {{ $application->user ? $application->user->address : '-' }}</p>
                    <p><strong>Profil Singkat:</strong> {{ $application->user ? $application->user->short_profile : '-' }}</p>
                    <p><strong>Link Sosial Media:</strong></p>
                    <p>
                        @if($application->user)
                            @if($application->user->facebook)
                                <a href="{{ $application->user->facebook }}" target="_blank" class="btn btn-sm btn-outline-primary me-1" title="Facebook">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            @endif
                            @if($application->user->instagram)
                                <a href="{{ $application->user->instagram }}" target="_blank" class="btn btn-sm btn-outline-danger me-1" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if($application->user->linkedin)
                                <a href="{{ $application->user->linkedin }}" target="_blank" class="btn btn-sm btn-outline-primary me-1" title="LinkedIn">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            @endif
                            @if($application->user->twitter)
                                <a href="{{ $application->user->twitter }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if($application->user->tiktok)
                                <a href="{{ $application->user->tiktok }}" target="_blank" class="btn btn-sm btn-outline-dark me-1" title="TikTok">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                            @endif
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <h6>Informasi Lamaran</h6>
                    <p><strong>Lowongan:</strong> {{ $application->jobPost->title ?? '-' }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge text-dark badge-{{ $application->status == 'pending' ? 'warning' : ($application->status == 'approved' ? 'success' : 'danger') }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </p>
                    <p><strong>Tanggal Melamar:</strong> 
                        @php
                            $appliedAt = $application->applied_at;
                            if (is_string($appliedAt)) {
                                $appliedAt = \Carbon\Carbon::parse($appliedAt);
                            }
                        @endphp
                        {{ $appliedAt ? $appliedAt->format('d M Y') : $application->created_at->format('d M Y') }}
                    </p>
                    <p><strong>Deskripsi Lamaran:</strong> {{ $application->description ?? 'Tidak ada deskripsi' }}</p>

                    @if($application->cv_path)
                        <p><strong>CV:</strong> <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank">Download CV</a></p>
                    @endif

                    @if($application->cover_letter)
                        <p><strong>Surat Lamaran:</strong> <a href="{{ asset('storage/' . $application->cover_letter) }}" target="_blank">Download Surat Lamaran</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('components.back-button')
</div>
@endsection
