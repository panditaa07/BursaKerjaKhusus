@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Header with Back Button and Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-briefcase text-primary me-2"></i>Detail Lowongan Kerja
                </h2>
                <div class="d-flex gap-2">
                    @include('components.back-button')
                    <a href="{{ route('company.jobs.edit', $job) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Lowongan
                    </a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Job Title and Status -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="text-primary mb-2">{{ $job->title }}</h3>
                                    <div class="d-flex gap-2 mb-3">
                                        <span class="badge bg-info">{{ $job->type ?? 'N/A' }}</span>
                                        <span class="badge
                                            @if($job->status == 'active') bg-success
                                            @elseif($job->status == 'inactive') bg-secondary
                                            @else bg-warning @endif">
                                            {{ ucfirst($job->status ?? 'draft') }}
                                        </span>
                                        @if($job->deadline && \Carbon\Carbon::parse($job->deadline)->isPast())
                                            <span class="badge bg-danger">Deadline Berlalu</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">Dibuat: {{ $job->created_at->format('d/m/Y H:i') }}</small>
                                    @if($job->updated_at != $job->created_at)
                                        <br><small class="text-muted">Diupdate: {{ $job->updated_at->format('d/m/Y H:i') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-info-circle text-primary me-2"></i>Informasi Dasar
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Lokasi Kerja</label>
                                <p class="mb-0">{{ $job->location ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Tipe Pekerjaan</label>
                                <p class="mb-0">{{ $job->type ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Rentang Gaji</label>
                                <p class="mb-0">{{ $job->salary ?? 'Tidak ditentukan' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label class="fw-bold text-muted">Deadline Lamaran</label>
                                <p class="mb-0">
                                    @if($job->deadline)
                                        {{ \Carbon\Carbon::parse($job->deadline)->format('d F Y') }}
                                        @if(\Carbon\Carbon::parse($job->deadline)->isPast())
                                            <span class="badge bg-danger ms-2">Berlalu</span>
                                        @else
                                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</small>
                                        @endif
                                    @else
                                        Tidak ada batas waktu
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-file-alt text-primary me-2"></i>Deskripsi Pekerjaan
                            </h5>
                            <div class="bg-light p-3 rounded">
                                @if($job->description)
                                    <div class="job-description">
                                        {!! nl2br(e($job->description)) !!}
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Tidak ada deskripsi pekerjaan.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Requirements -->
                    @if($job->requirements)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-clipboard-list text-primary me-2"></i>Persyaratan & Kualifikasi
                            </h5>
                            <div class="bg-light p-3 rounded">
                                <div class="requirements">
                                    {!! nl2br(e($job->requirements)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Applicants Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="fas fa-users text-primary me-2"></i>Pelamar ({{ $job->applications ? $job->applications->count() : 0 }})
                            </h5>

                            @if($job->applications && $job->applications->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="60">No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No. HP</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th width="100">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($job->applications as $application)
                                            <tr>
                                                <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-wrapper me-2">
                                                            @if($application->user->profile_photo_path)
                                                                <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}"
                                                                     class="rounded-circle" width="32" height="32" alt="Avatar">
                                                            @else
                                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                                     style="width: 32px; height: 32px; font-size: 12px; font-weight: bold;">
                                                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span class="fw-bold">{{ $application->user->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $application->user->email }}</td>
                                                <td>{{ $application->user->phone ?? '-' }}</td>
                                                <td>
                                                    <span class="badge
                                                        @if($application->status == 'accepted') bg-success
                                                        @elseif($application->status == 'rejected') bg-danger
                                                        @elseif($application->status == 'interview') bg-info
                                                        @else bg-warning @endif">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('company.applications.show.company', $application->id) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada pelamar untuk lowongan ini</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-12">
                            <hr class="my-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('company.jobs.all') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                                    </a>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('company.applications.index') }}" class="btn btn-info">
                                        <i class="fas fa-users me-2"></i>Lihat Semua Pelamar
                                    </a>
                                    <a href="{{ route('company.jobs.edit', $job) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit Lowongan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .info-item {
        padding: 0.75rem 0;
    }

    .info-item label {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
        display: block;
    }

    .info-item p {
        font-size: 1rem;
        color: #333;
    }

    .job-description, .requirements {
        line-height: 1.6;
        white-space: pre-line;
    }

    .avatar-wrapper {
        display: inline-block;
    }

    .badge {
        font-size: 0.75rem;
    }
</style>
@endpush
