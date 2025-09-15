@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
<div class="container">
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
                    <p><strong>NIK/NISN:</strong> {{ Auth::user()->nisn ?? '-' }}</p>
                    <p><strong>Tanggal Lahir:</strong> {{ Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('d/m/Y') : '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Profil Singkat:</strong> {{ Auth::user()->short_profile ?? '-' }}</p>
                    <p><strong>Foto Profil:</strong><br>
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Foto Profil" style="max-width: 100px;">
                        @else
                            -
                        @endif
                    </p>
                    <p><strong>CV:</strong>
                        @if(Auth::user()->cv_path)
                            <a href="{{ Storage::url(Auth::user()->cv_path) }}" target="_blank">Lihat CV</a>
                        @else
                            Belum diunggah
                        @endif
                    </p>
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
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('profile.upload-cv') }}" class="btn btn-primary">Upload CV</a>
                <a href="{{ route(match(auth()->user()->role ?? 'user') { 'admin' => 'admin.dashboard.index', 'company' => 'company.dashboard.index', default => 'user.dashboard.index' }) }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
