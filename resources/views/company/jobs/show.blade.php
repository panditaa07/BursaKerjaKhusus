@extends('layouts.dashboard')

@section('title', 'Detail Lowongan Kerja')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('company.dashboard.index') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('company.jobs.all') }}">Kelola Lowongan</a>
            </li>
            <li class="breadcrumb-item active">Detail Lowongan</li>
        </ol>
    </nav>

    <!-- Header with Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-briefcase text-primary"></i>
            Detail Lowongan Kerja
        </h2>
        <div>
            <a href="{{ route('company.jobs.edit', $job) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit Lowongan
            </a>
            <form method="POST" action="{{ route('company.jobs.toggle-status', $job) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn
                    @if($job->status === 'active')
                        btn-secondary
                    @else
                        btn-success
                    @endif"
                    onclick="return confirm('Apakah Anda yakin ingin mengubah status lowongan ini?')">
                    <i class="fas fa-{{ $job->status === 'active' ? 'pause' : 'play' }}"></i>
                    @if($job->status === 'active') Nonaktifkan @else Aktifkan @endif
                </button>
            </form>
            <form method="POST" action="{{ route('company.jobs.destroy', $job) }}" class="d-inline ms-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Tindakan ini tidak dapat dibatalkan.')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Header Perusahaan -->
                    <div class="border-bottom pb-4 mb-4">
                        <h4 class="card-title mb-3">
                            <i class="fas fa-building text-primary"></i>
                            Informasi Perusahaan
                        </h4>
                        <div class="d-flex align-items-center">
                            @if($job->company_logo)
                                <img src="{{ asset('storage/' . $job->company_logo) }}" alt="Logo Perusahaan" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-building text-muted fa-2x"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $job->company->name ?? 'N/A' }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $job->company->address ?? 'N/A' }}
                                </p>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-envelope"></i>
                                    {{ $job->company->user->email ?? 'N/A' }}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-phone"></i>
                                    {{ $job->company->phone ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Judul Posisi Lowongan -->
                    <div class="mb-4">
                        <h4 class="card-title mb-3">
                            <i class="fas fa-briefcase text-success"></i>
                            {{ $job->title }}
                        </h4>
                    </div>

                    <!-- Informasi Umum -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">
                                <i class="fas fa-info-circle text-primary"></i>
                                Informasi Umum
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="150">Lokasi:</td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                        {{ $job->location }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tipe Pekerjaan:</td>
                                    <td>
                                        <i class="fas fa-clock text-muted"></i>
                                        {{ $job->employment_type }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jumlah Lowongan:</td>
                                    <td>
                                        <i class="fas fa-users text-muted"></i>
                                        {{ $job->vacancies }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status:</td>
                                    <td>
                                        <span class="badge
                                            @if(in_array($job->status, ['active'])) bg-success
                                            @elseif(in_array($job->status, ['inactive'])) bg-danger
                                            @else bg-warning @endif">
                                            <i class="fas fa-{{ in_array($job->status, ['active']) ? 'check' : 'pause' }}"></i>
                                            {{ ucfirst($job->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Dibuat:</td>
                                    <td>
                                        <i class="fas fa-calendar text-muted"></i>
                                        {{ $job->created_at ? \Carbon\Carbon::parse($job->created_at)->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Deadline:</td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-muted"></i>
                                        {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') : 'N/A' }}
                                        @if($job->deadline)
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $deadline = \Carbon\Carbon::parse($job->deadline);
                                                $diff = $now->diff($deadline);
                                                $remaining = '';
                                                if ($deadline->isPast()) {
                                                    $remaining = '<br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Deadline telah berlalu</small>';
                                                } else {
                                                    $remaining = '<br><small class="text-muted"><i class="fas fa-clock"></i> Sisa waktu: ' . $diff->d . ' Hari ' . $diff->h . ' Jam ' . $diff->i . ' Menit</small>';
                                                }
                                            @endphp
                                            {!! $remaining !!}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Rentang Gaji:</td>
                                    <td>
                                        <i class="fas fa-money-bill text-muted"></i>
                                        @if($job->min_salary || $job->max_salary)
                                            Rp {{ number_format((float)($job->min_salary ?: 0)) }} - Rp {{ number_format((float)($job->max_salary ?: 0)) }}
                                        @else
                                            Tidak ditentukan
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="mb-3">
                                <i class="fas fa-list text-primary"></i>
                                Detail Tambahan
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="150">Industri:</td>
                                    <td>
                                        <i class="fas fa-industry text-muted"></i>
                                        {{ $job->industry->name ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Total Pelamar:</td>
                                    <td>
                                        <i class="fas fa-users text-muted"></i>
                                        <a href="{{ route('company.pelamar.all') }}" class="text-decoration-none">
                                            {{ $job->applications->count() }} pelamar
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Jobdesk / Tugas Pekerjaan -->
                    @if($job->description)
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-tasks text-primary"></i>
                            Jobdesk / Tugas Pekerjaan
                        </h5>
                        <div class="alert alert-light">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Persyaratan -->
                    @if($job->requirements)
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-clipboard-list text-primary"></i>
                            Persyaratan
                        </h5>
                        <div class="alert alert-light">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Berkas Lamaran -->
                    @if($job->berkas_lamaran)
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-file-alt text-primary"></i>
                            Berkas Lamaran
                        </h5>
                        <div class="alert alert-light">
                            {!! nl2br(e($job->berkas_lamaran)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Pelamar -->
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-users text-primary"></i>
                            Pelamar ({{ $job->applications->count() }})
                        </h5>
                        @if($job->applications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($job->applications as $application)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($application->user->profile_photo_path)
                                                            <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                <span class="text-white fw-bold">{{ strtoupper(substr($application->user->name, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        {{ $application->user->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $application->user->email }}</td>
                                                <td>
                                                    <span class="badge
                                                        @if($application->status == 'pending') bg-warning
                                                        @elseif($application->status == 'accepted') bg-success
                                                        @elseif($application->status == 'rejected') bg-danger
                                                        @else bg-secondary @endif">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('company.applications.show.company', $application->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pelamar</h5>
                                <p class="text-muted">Belum ada pelamar yang melamar lowongan ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }

    .badge {
        font-size: 0.75rem;
    }

    .alert-light {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #495057;
    }
</style>
@endpush
