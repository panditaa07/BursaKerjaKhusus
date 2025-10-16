@extends('layouts.dashboard')

@section('title', 'Detail Lowongan Kerja')

{{-- Panggil CSS --}}
@section('css')
<link rel="stylesheet" href="{{ asset('css/detailpengguna.css') }}">
@endsection

@section('content')
<div class="detail-pengguna-page">
    <h1>Detail Lowongan Kerja</h1>
    <div class="d-flex gap-2 mb-3">
        @if(request('from') == 'kelola')
            <a href="{{ route('admin.job-posts.index') }}" class="btn-custom back">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @elseif($jobPost->status == 'active')
            <a href="{{ route('admin.dashboard.lowongan-aktif') }}" class="btn-custom back">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @else
            <a href="{{ route('admin.dashboard.lowongan-tidak-aktif') }}" class="btn-custom back">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @endif
        <a href="{{ route('admin.job-posts.edit', $jobPost->id) }}?from={{ request('from') }}" class="btn btn-custom edit">
            <i class="fas fa-edit"></i> Edit Lowongan
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Data Umum</h3>
        </div>
        <div class="card-body">
            <p><strong>Judul:</strong> {{ $jobPost->title }}</p>
            <p><strong>Lokasi:</strong> {{ $jobPost->location }}</p>
            <p><strong>Tipe Pekerjaan:</strong> {{ $jobPost->employment_type }}</p>
            <p><strong>Gaji:</strong> {{ $jobPost->salary ?: 'Tidak ditentukan' }}</p>
            <p><strong>Status:</strong>
                <span class="status-badge
                    @if(in_array($jobPost->status, ['Accepted'])) status-aktif
                    @elseif(in_array($jobPost->status, ['Rejected'])) status-nonaktif
                    @else status-nonaktif @endif">
                    {{ $jobPost->status }}
                </span>
            </p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Informasi Tambahan</h3>
        </div>
        <div class="card-body">
            <p><strong>Perusahaan:</strong> {{ $jobPost->company->name ?? 'N/A' }}</p>
            <p><strong>Industri:</strong> {{ $jobPost->industry->name ?? 'N/A' }}</p>
            <p><strong>Jumlah Lowongan:</strong> {{ $jobPost->vacancies }}</p>
            <p><strong>Deadline:</strong> {{ $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('d/m/Y') : 'N/A' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Deskripsi</h3>
        </div>
        <div class="card-body">
            <p>{{ $jobPost->description }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Persyaratan</h3>
        </div>
        <div class="card-body">
            <p>{{ $jobPost->requirements }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h3>Pelamar ({{ $jobPost->applications()->count() }})</h3>
        </div>
        <div class="card-body">
            @if($jobPost->applications()->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobPost->applications as $application)
                            <tr>
                                <td>{{ $application->user->name ?? 'N/A' }}</td>
                                <td>{{ $application->user->email ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-badge
                                        @if($application->status == 'pending') status-nonaktif
                                        @elseif($application->status == 'accepted') status-aktif
                                        @else status-nonaktif @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Belum ada pelamar untuk lowongan ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection

{{-- Panggil JS --}}
@section('scripts')
<script src="{{ asset('js/detail.js') }}"></script>
@endsection
