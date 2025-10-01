@extends('layouts.dashboard')

@section('title', 'Detail Lamaran - BKK OPAT')

@section('content')
@if(auth()->user()->role && auth()->user()->role->name === 'user')
<div class="bg-light min-vh-100 py-4">
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="card shadow-sm border-0 rounded-lg mb-4">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 text-primary">
                                <i class="fas fa-file-alt"></i>
                                Detail Lamaran
                            </h4>
                            <a href="{{ route('user.applications.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Application Details -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body p-4">
                        <!-- Job Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-briefcase"></i> Informasi Lowongan
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <h6 class="mb-2">{{ $application->jobPost->title }}</h6>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-building"></i>
                                        {{ $application->jobPost->company->name ?? 'Unknown Company' }}
                                    </p>
                                    <p class="mb-1 text-muted">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $application->jobPost->location ?? 'Lokasi tidak tersedia' }}
                                    </p>
                                    <p class="mb-0 text-muted">
                                        <i class="fas fa-money-bill-wave"></i>
                                        {{ $application->jobPost->salary ?? 'Gaji tidak tersedia' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Application Status -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-info-circle"></i> Status Lamaran
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    @if(in_array($application->status, ['submitted', 'test1', 'test2']))
                                        <span class="badge bg-primary fs-6 px-3 py-2">Proses</span>
                                    @elseif($application->status === 'interview')
                                        <span class="badge bg-primary fs-6 px-3 py-2">Wawancara</span>
                                    @elseif($application->status === 'accepted')
                                        <span class="badge bg-success fs-6 px-3 py-2">Diterima</span>
                                    @elseif($application->status === 'rejected')
                                        <span class="badge bg-danger fs-6 px-3 py-2">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary fs-6 px-3 py-2">{{ ucfirst($application->status) }}</span>
                                    @endif
                                    <p class="mt-2 mb-0 text-muted small">
                                        Tanggal melamar: {{ $application->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-file-upload"></i> Dokumen Lamaran
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    @if($application->cv_path)
                                        <p class="mb-2">
                                            <i class="fas fa-file-pdf text-danger"></i>
                                            CV: <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="text-decoration-none">Lihat CV</a>
                                        </p>
                                    @else
                                        <p class="mb-2 text-muted">
                                            <i class="fas fa-file-pdf text-muted"></i>
                                            CV: Tidak tersedia
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Cover Letter -->
                        @if($application->cover_letter)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-envelope"></i> Surat Lamaran
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ nl2br(e($application->cover_letter)) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Job Description -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-list-ul"></i> Deskripsi Pekerjaan
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    @if($application->jobPost->description)
                                        <p class="mb-0">{{ nl2br(e($application->jobPost->description)) }}</p>
                                    @else
                                        <p class="text-muted mb-0">Deskripsi tidak tersedia</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-file-alt"></i>
                            Detail Lamaran
                        </h4>
                    </div>
                    <div class="card-body">
                        <p>Halaman ini hanya untuk role USER.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
