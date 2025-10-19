@extends('layouts.dashboard')

@section('title', 'Detail Lamaran')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detailpelamarcom.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h1 class="h3 mb-0">Detail Lamaran</h1>
        <a href="{{ route('user.applications.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Lamaran
        </a>
    </div>

    <!-- Company Logo -->
    <div class="mb-4 text-center">
        @if($application->jobPost->company && $application->jobPost->company->logo)
            <img src="{{ asset('storage/' . $application->jobPost->company->logo) }}"
                 alt="Logo Perusahaan"
                 class="rounded-circle border"
                 style="width: 120px; height: 120px; object-fit: cover;">
        @else
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                 style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                <i class="fas fa-building"></i>
            </div>
        @endif
    </div>

    <div class="row g-3">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Company Information -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary">
                    <h5 class="mb-0"><i class="fas fa-building"></i> Informasi Perusahaan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">Nama Perusahaan:</td>
                                    <td>{{ $application->jobPost->company->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Industri:</td>
                                    <td>{{ $application->jobPost->industry->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Website:</td>
                                    <td>
                                        @if($application->jobPost->company->website)
                                            <a href="{{ $application->jobPost->company->website }}" target="_blank">{{ $application->jobPost->company->website }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">Alamat:</td>
                                    <td>{{ $application->jobPost->company->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email Kontak:</td>
                                    <td>{{ $application->jobPost->company->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Telepon:</td>
                                    <td>{{ $application->jobPost->company->phone ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Information -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-info">
                    <h5 class="mb-0"><i class="fas fa-file-alt"></i> Informasi Lamaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">Lowongan:</td>
                                    <td>{{ $application->jobPost->title ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Lamar:</td>
                                    <td>{{ $application->created_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">Status:</td>
                                    <td>
                                        @php
                                            $status = $application->status;
                                            $statusConfig = [
                                                'accepted'  => ['label' => 'Diterima',  'class' => 'status-chip chip--accepted'],
                                                'rejected'  => ['label' => 'Ditolak',   'class' => 'status-chip chip--rejected'],
                                                'interview' => ['label' => 'Wawancara', 'class' => 'status-chip chip--interview'],
                                                'test1'     => ['label' => 'Test 1',    'class' => 'status-chip chip--test1'],
                                                'test2'     => ['label' => 'Test 2',    'class' => 'status-chip chip--test2'],
                                                'submitted' => ['label' => 'Terkirim',  'class' => 'status-chip chip--submitted'],
                                                'reviewed'  => ['label' => 'Ditinjau',  'class' => 'status-chip chip--review'],
                                            ];
                                            $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'status-chip chip--submitted'];
                                        @endphp
                                        <span class="{{ $currentStatus['class'] }}"><span class="dot"></span>{{ $currentStatus['label'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">ID Lamaran:</td>
                                    <td>#{{ $application->id }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($application->description)
                    <div class="mt-2">
                        <h6 class="fw-bold mb-2">Deskripsi Lamaran:</h6>
                        <div class="inner">
                            {{ $application->description }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Documents -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success">
                    <h5 class="mb-0"><i class="fas fa-file-download"></i> Dokumen Terkirim</h5>
                </div>
                <div class="card-body">
                    @if($application->cover_letter_path)
                        <a href="{{ asset('storage/' . $application->cover_letter_path) }}" target="_blank" class="btn-doc primary mb-2 w-100">
                            <i class="fas fa-file-alt"></i> Lihat Surat Lamaran
                        </a>
                    @else
                        <button type="button" class="btn-doc soft mb-2 w-100" disabled>
                            <i class="fas fa-file-alt"></i> Tidak ada Surat Lamaran
                        </button>
                    @endif

                    @if($application->cv_path)
                        <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="btn-doc soft w-100">
                            <i class="fas fa-eye"></i> Lihat CV
                        </a>
                    @else
                         <button type="button" class="btn-doc soft w-100" disabled>
                            <i class="fas fa-eye"></i> Tidak ada CV
                        </button>
                    @endif
                </div>
            </div>
            
            {{-- Social Media & Status Update cards are removed --}}
        </div>
    </div>
</div>

<script>
function showNoCoverLetterAlert() {
  alert('Anda tidak melampirkan surat lamaran.');
}
</script>
@endsection