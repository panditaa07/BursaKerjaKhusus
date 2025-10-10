@extends('layouts.dashboard')

@section('title', 'Detail Lowongan Kerja')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detaillowongancomp.css') }}?v={{ time() }}">
@endsection

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

  <!-- Header dengan Tombol Aksi (termasuk tombol Kembali) -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">
            <i class="fas fa-briefcase text-primary"></i>
            Detail Lowongan Kerja
        </h2>

        <div class="jd-actions d-flex gap-2 flex-wrap">
            <!-- Tombol Kembali -->
            <button type="button" class="btn btn-back" onclick="history.back()">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </button>

            <!-- Edit Lowongan -->
            <a href="{{ route('company.jobs.edit', $job) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Lowongan
            </a>

            <!-- Aktif/Nonaktif -->
            <form method="POST" action="{{ route('company.jobs.toggle-status', $job) }}" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn {{ $job->status === 'active' ? 'btn-secondary' : 'btn-success' }}"
                    onclick="return confirm('Apakah Anda yakin ingin mengubah status lowongan ini?')">
                    <i class="fas fa-{{ $job->status === 'active' ? 'pause' : 'play' }}"></i>
                    {{ $job->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>

            <!-- Hapus -->
            <form method="POST" action="{{ route('company.jobs.destroy', $job) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
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
                            @if($job->company && $job->company->logo)
                                <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo Perusahaan" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
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

                        <!-- Company Profile Photo -->
                        <div class="mt-3 text-center">
                            <h6 class="mb-2">
                                <i class="fas fa-user-circle text-primary"></i>
                                Foto Profil Perusahaan
                            </h6>
                            @if($job->company && $job->company->user && $job->company->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $job->company->user->profile_photo_path) }}"
                                     alt="Foto Profil {{ $job->company->name }}"
                                     class="rounded-circle border"
                                     style="width: 100px; height: 100px; object-fit: cover; border-width: 3px !important; border-color: #dee2e6 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            @else
                                <div class="rounded-circle border bg-light d-inline-flex align-items-center justify-content-center"
                                     style="width: 100px; height: 100px; border-width: 3px !important; border-color: #dee2e6 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <i class="fas fa-user text-muted fa-2x"></i>
                                </div>
                            @endif
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

           {{-- Pelamar --}}
<div class="mb-4">
  <h5 class="mb-3">
    <i class="fas fa-users text-primary"></i>
    Pelamar ({{ $job->applications->count() }})
  </h5>

  @if($job->applications->count() > 0)
    <div class="table-responsive">
      <table class="table-applicants">
        <thead>
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
              {{-- NAMA --}}
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

              {{-- EMAIL --}}
              <td data-label="Email">{{ $application->user->email }}</td>

             {{-- STATUS --}}
<td data-label="Status">
  @php
    $statusMap = [
      'submitted' => ['label' => 'Menunggu', 'class' => 'status-wait',      'icon' => 'fa-circle'],
      'pending'   => ['label' => 'Menunggu', 'class' => 'status-wait',      'icon' => 'fa-circle'],
      'reviewed'  => ['label' => 'Menunggu', 'class' => 'status-wait',      'icon' => 'fa-circle'],
      'test1'     => ['label' => 'Test 1',   'class' => 'status-test1',     'icon' => 'fa-circle'],
      'test2'     => ['label' => 'Test 2',   'class' => 'status-test2',     'icon' => 'fa-circle'],
      'interview' => ['label' => 'Interview','class' => 'status-interview', 'icon' => 'fa-circle'],
      'accepted'  => ['label' => 'Terima',   'class' => 'status-accepted',  'icon' => 'fa-circle'],
      'rejected'  => ['label' => 'Tolak',    'class' => 'status-rejected',  'icon' => 'fa-circle'],
    ];

    $key   = strtolower($application->status);
    $cfg   = $statusMap[$key] ?? ['label'=>ucfirst($application->status),'class'=>'status-neutral','icon'=>'fa-circle'];
  @endphp

  <span class="chip {{ $cfg['class'] }}" title="{{ $cfg['label'] }}">
    <span class="chip-dot"></span>
    <span class="chip-label">{{ $cfg['label'] }}</span>
  </span>
</td>
              {{-- TANGGAL --}}
              <td data-label="Tanggal">{{ $application->created_at->format('d/m/Y') }}</td>

              {{-- AKSI --}}
              <td class="text-center" data-label="Aksi">
                <a href="{{ route('company.applications.show.company', $application->id) }}"
   class="btn-icon btn-view" title="Lihat Detail">
   <i class="fas fa-eye"></i>
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

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.body.classList.add('job-detail');
  });
</script>
@endpush

@endpush
