@extends('layouts.dashboard')

@section('title', 'Detail Pengguna')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edituser.css') }}">
<div class="container">
    <h1>Detail Pengguna</h1>
    @include('components.back-button')

    <div class="card mb-4">
        <div class="card-header">
            <h3>Data Umum</h3>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>No HP:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $user->address ?? '-' }}</p>
            <p><strong>NIK/NISN:</strong> {{ $user->nisn ?? '-' }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') : '-' }}</p>
            <p><strong>Status:</strong> {{ $user->deleted_at ? 'Nonaktif' : 'Aktif' }}</p>
            <p><strong>Tanggal Daftar:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
            <p><strong>Terakhir Login:</strong> {{ $user->last_login_at ?? '-' }}</p>
        </div>
    </div>

    @if($user->role->name === 'company')
    <div class="card mb-4">
        <div class="card-header">
            <h3>Data Perusahaan</h3>
        </div>
        <div class="card-body">
            <p><strong>Nama Perusahaan:</strong> {{ $user->company->name ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $user->company->address ?? '-' }}</p>
            <p><strong>No. Telp:</strong> {{ $user->company->phone ?? '-' }}</p>
            <p><strong>Email Kontak:</strong> {{ $user->company->email ?? '-' }}</p>
            <p><strong>Industri:</strong> {{ $user->company->industry->name ?? '-' }}</p>
            <p><strong>Logo:</strong><br>
                @if($user->company->logo)
                    <img src="{{ asset('storage/' . $user->company->logo) }}" alt="Logo" style="max-width: 150px;">
                @else
                    -
                @endif
            </p>
            <p><strong>Jumlah Lowongan:</strong> {{ $user->job_posts_count ?? 0 }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Lowongan Perusahaan</h3>
        </div>
        <div class="card-body">
            @if($user->jobPosts->isEmpty())
                <p>Belum ada lowongan.</p>
            @else
                <ul>
                    @foreach($user->jobPosts as $job)
                        <li>{{ $job->title }} ({{ ucfirst($job->status) }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    @elseif($user->role->name === 'user')
    <div class="card mb-4">
        <div class="card-header">
            <h3>Foto Profil</h3>
        </div>
        <div class="card-body">
            <p>
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto Profil" style="max-width: 150px;">
                @else
                    -
                @endif
            </p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Berkas</h3>
        </div>
        <div class="card-body">
            <p><strong>CV:</strong>
                @if($user->cv_path)
                    <a href="{{ asset('storage/' . $user->cv_path) }}" target="_blank" download>Download CV</a>
                @else
                    Tidak ada CV
                @endif
            </p>
            <p><strong>Surat Lamaran:</strong>
                @if($user->applications->isNotEmpty())
                    <ul>
                        @foreach($user->applications as $application)
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

    <div class="card mb-4">
        <div class="card-header">
            <h3>Riwayat Lamaran</h3>
        </div>
        <div class="card-body">
            @if($user->applications->isEmpty())
                <p>Belum ada riwayat lamaran.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul Lowongan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->applications as $application)
                        <tr>
                            <td>{{ $application->jobPost->title ?? '-' }}</td>
                            <td>{{ ucfirst($application->status) }}</td>
                            <td>{{ $application->created_at->format('d-m-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @endif
</div>
<script src="{{ asset('js/detail.js') }}"></script>
@endsection
