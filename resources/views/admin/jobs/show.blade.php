@extends('layouts.dashboard')

@section('title', 'Detail Lowongan Kerja')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detaillowonganadmin.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="icon-container me-3">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

   <!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard.index') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>

        @if (request('from') == 'aktif')
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard.lowongan-aktif') }}">Lowongan Aktif</a>
            </li>
        @elseif (request('from') == 'tidakaktif')
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard.lowongan-tidak-aktif') }}">Lowongan Tidak Aktif</a>
            </li>
        @elseif (request('from') == 'kelola')
            <li class="breadcrumb-item">
                <a href="{{ route('admin.job-posts.index') }}">Kelola Lowongan</a>
            </li>
        @else
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
            </li>
        @endif

        <li class="breadcrumb-item active">Detail Lowongan</li>
    </ol>
</nav>

    <!-- Header dengan Tombol Aksi -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">
            <i class="fas fa-briefcase"></i>
            Detail Lowongan Kerja
        </h2>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Enhanced Main Card -->
            <div class="card enhanced-card floating-element">
                <div class="card-body p-4">
                    
                    <!-- Enhanced Header Section - Fixed Layout -->
                    <div class="enhanced-header mb-5">
                        <!-- Company Info Grid -->
                        <div class="company-header-grid">
                            <!-- Logo -->
                            <div class="company-logo-main">
                                @if($jobPost->company && $jobPost->company->logo)
                                    <img src="{{ asset('storage/' . $jobPost->company->logo) }}" 
                                         alt="Logo Perusahaan" 
                                         class="rounded"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-building text-primary fa-3x"></i>
                                @endif
                            </div>
                            
                            <!-- Company Details -->
                            <div class="company-details">
                                <h1 class="company-name">{{ $jobPost->company->name ?? 'N/A' }}</h1>
                                
                                <div class="company-contact-info">
                                    <div class="contact-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $jobPost->company->address ?? 'N/A' }}</span>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $jobPost->company->user->email ?? 'N/A' }}</span>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-phone"></i>
                                        <span>{{ $jobPost->company->phone ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Job Title Section -->
                        
                        <!-- Profile Photo Section -->
                    
                    </div>

                    <!-- Section Divider -->
                    <div class="section-divider"></div>

                    <!-- Enhanced Job Details Grid -->
                    <div class="info-grid-enhanced mb-5">
                        <!-- Informasi Umum -->
                        <div class="info-card-enhanced card-shadow">
                            <h5 class="mb-4">
                                <div class="icon-container d-inline-flex me-3">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                Informasi Umum
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="150">Lokasi:</td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        {{ $jobPost->location }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tipe Pekerjaan:</td>
                                    <td>
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        {{ $jobPost->employment_type }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jumlah Lowongan:</td>
                                    <td>
                                        <i class="fas fa-users text-primary me-2"></i>
                                        {{ $jobPost->vacancies }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Deadline:</td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        {{ $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('d/m/Y') : 'N/A' }}
                                        @if($jobPost->deadline)
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $deadline = \Carbon\Carbon::parse($jobPost->deadline);
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
                                        <i class="fas fa-money-bill text-primary me-2"></i>
                                        @if($jobPost->min_salary || $jobPost->max_salary)
                                            Rp {{ number_format((float)($jobPost->min_salary ?: 0)) }} - Rp {{ number_format((float)($jobPost->max_salary ?: 0)) }}
                                        @else
                                            Tidak ditentukan
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Detail Tambahan -->
                        <div class="info-card-enhanced card-shadow">
                            <h5 class="mb-4">
                                <div class="icon-container d-inline-flex me-3">
                                    <i class="fas fa-list"></i>
                                </div>
                                Detail Tambahan
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted" width="150">Industri:</td>
                                    <td>
                                        <i class="fas fa-industry text-primary me-2"></i>
                                        {{ $jobPost->industry->name ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Total Pelamar:</td>
                                    <td>
                                        <i class="fas fa-users text-primary me-2"></i>
                                        {{ $jobPost->applications->count() }} pelamar
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status:</td>
                                    <td>
                                        <span class="badge-enhanced
                                            @if(in_array($jobPost->status, ['active'])) bg-success
                                            @elseif(in_array($jobPost->status, ['inactive'])) bg-danger
                                            @else bg-warning @endif">
                                            <i {{ in_array($jobPost->status, ['active']) ? 'check' : 'pause' }} me-1"></i>
                                            {{ ucfirst($jobPost->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Dibuat:</td>
                                    <td>
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        {{ $jobPost->created_at ? \Carbon\Carbon::parse($jobPost->created_at)->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Enhanced Content Sections -->
                    @if($jobPost->description)
                    <div class="info-card-enhanced mb-4 card-shadow">
                        <h5 class="mb-4">
                            <div class="icon-container d-inline-flex me-3">
                                <i class="fas fa-tasks"></i>
                            </div>
                            Jobdesk / Tugas Pekerjaan
                        </h5>
                        <div class="alert-light-enhanced">
                            {!! nl2br(e($jobPost->description)) !!}
                        </div>
                    </div>
                    @endif

                    @if($jobPost->requirements)
                    <div class="info-card-enhanced mb-4 card-shadow">
                        <h5 class="mb-4">
                            <div class="icon-container d-inline-flex me-3">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            Persyaratan
                        </h5>
                        <div class="alert-light-enhanced">
                            {!! nl2br(e($jobPost->requirements)) !!}
                        </div>
                    </div>
                    @endif

                    @if($jobPost->berkas_lamaran)
                    <div class="info-card-enhanced mb-4 card-shadow">
                        <h5 class="mb-4">
                            <div class="icon-container d-inline-flex me-3">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            Berkas Lamaran
                        </h5>
                        <div class="alert-light-enhanced">
                            {!! nl2br(e($jobPost->berkas_lamaran)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- Enhanced Applicants Section -->
                    <div class="applicant-table-enhanced mt-5">
                        <div class="applicant-header-enhanced">
                            <h5>
                                <i class="fas fa-users me-2"></i>
                                Pelamar ({{ $jobPost->applications->count() }})
                            </h5>
                        </div>
                        
                        <div class="p-4">
                            @if($jobPost->applications->count() > 0)
                                <div class="table-responsive">
                                    <table class="table-applicants">
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
                                                    <td data-label="Nama">
                                                        <div class="d-flex align-items-center">
                                                            @if($application->user->profile_photo_path)
                                                                <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}"
                                                                     alt="Avatar" class="rounded-circle me-2"
                                                                     style="width:32px;height:32px;object-fit:cover;">
                                                            @else
                                                                <div class="avatar-pill me-2">
                                                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                            {{ $application->user->name }}
                                                        </div>
                                                    </td>
                                                    <td data-label="Email">{{ $application->user->email }}</td>
                                                    <td data-label="Status">
                                                        @php
                                                            $statusMap = [
                                                                'submitted' => ['label' => 'Menunggu', 'class' => 'status-wait', 'icon' => 'fa-circle'],
                                                                'pending' => ['label' => 'Menunggu', 'class' => 'status-wait', 'icon' => 'fa-circle'],
                                                                'reviewed' => ['label' => 'Menunggu', 'class' => 'status-wait', 'icon' => 'fa-circle'],
                                                                'test1' => ['label' => 'Test 1', 'class' => 'status-test1', 'icon' => 'fa-circle'],
                                                                'test2' => ['label' => 'Test 2', 'class' => 'status-test2', 'icon' => 'fa-circle'],
                                                                'interview' => ['label' => 'Interview','class' => 'status-interview', 'icon' => 'fa-circle'],
                                                                'accepted' => ['label' => 'Terima', 'class' => 'status-accepted', 'icon' => 'fa-circle'],
                                                                'rejected' => ['label' => 'Tolak', 'class' => 'status-rejected', 'icon' => 'fa-circle'],
                                                            ];
                                                            $key = strtolower($application->status);
                                                            $cfg = $statusMap[$key] ?? ['label'=>ucfirst($application->status),'class'=>'status-neutral','icon'=>'fa-circle'];
                                                        @endphp
                                                        <span class="chip {{ $cfg['class'] }}" title="{{ $cfg['label'] }}">
                                                            <span class="chip-dot"></span>
                                                            <span class="chip-label">{{ $cfg['label'] }}</span>
                                                        </span>
                                                    </td>
                                                    <td data-label="Tanggal">{{ $application->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-state-enhanced">
                                    <i class="fas fa-users"></i>
                                    <h4 class="text-muted mb-3">Belum ada pelamar</h4>
                                    <p class="text-muted">Belum ada pelamar yang melamar lowongan ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <br>
            <div class="jd-actions d-flex flex-wrap align-items-center justify-content-start">
    {{-- Tombol Kembali Dinamis --}}
    @if (request('from') == 'aktif')
        <a href="{{ route('admin.dashboard.lowongan-aktif') }}" class="btn btn-outline-secondary jd-btn">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Lowongan Aktif
        </a>
    @elseif (request('from') == 'tidakaktif')
        <a href="{{ route('admin.dashboard.lowongan-tidak-aktif') }}" class="btn btn-outline-secondary jd-btn">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Lowongan Tidak Aktif
        </a>
    @elseif (request('from') == 'kelola')
        <a href="{{ route('admin.job-posts.index') }}" class="btn btn-outline-secondary jd-btn">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Kelola Lowongan
        </a>
    @else
        <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-secondary jd-btn">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    @endif
</div>

        </div>
        
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Additional inline styles for better appearance */
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('job-detail');
        
        // Add smooth scrolling for better user experience
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endpush