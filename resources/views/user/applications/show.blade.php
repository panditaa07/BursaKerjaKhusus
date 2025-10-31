@extends('layouts.dashboard')

@section('title', 'Detail Lamaran')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/showdetaillamaran.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h1 class="h3 mb-0">Detail Lamaran</h1>
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
        <!-- Main Content - Full Width -->
        <div class="col-12">
            <!-- Company Information -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary">
                    <h5 class="mb-0"><i class="fas fa-building"></i> Informasi Perusahaan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">Nama Perusahaan:</td>
                                    <td>{{ $application->jobPost->company->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Industri:</td>
                                    <td>{{ $application->jobPost->industry->name ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">Alamat:</td>
                                    <td>{{ $application->jobPost->company->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email Kontak:</td>
                                    <td>{{ $application->jobPost->company->email ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">Telepon:</td>
                                    <td>{{ $application->jobPost->company->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Sosial Media:</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            @if($application->jobPost->company->linkedin)
                                                <a href="{{ $application->jobPost->company->linkedin }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                    <i class="fa-brands fa-linkedin"></i> LinkedIn
                                                </a>
                                            @endif
                                            @if($application->jobPost->company->social_media)
                                                <a href="{{ $application->jobPost->company->social_media }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                    <i class="fa-brands fa-instagram"></i> Instagram
                                                </a>
                                            @endif
                                            @if($application->jobPost->company->facebook)
                                                <a href="{{ $application->jobPost->company->facebook }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                    <i class="fa-brands fa-facebook"></i> Facebook
                                                </a>
                                            @endif
                                            @if($application->jobPost->company->twitter)
                                                <a href="{{ $application->jobPost->company->twitter }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                    <i class="fa-brands fa-twitter"></i> Twitter
                                                </a>
                                            @endif
                                            @if($application->jobPost->company->tiktok)
                                                <a href="{{ $application->jobPost->company->tiktok }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                    <i class="fa-brands fa-tiktok"></i> TikTok
                                                </a>
                                            @endif
                                            @if($application->jobPost->company->youtube)
                                                <a href="{{ $application->jobPost->company->youtube }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                    <i class="fa-brands fa-youtube"></i> YouTube
                                                </a>
                                            @endif
                                            @if(!$application->jobPost->company->linkedin && !$application->jobPost->company->social_media && !$application->jobPost->company->facebook && !$application->jobPost->company->twitter && !$application->jobPost->company->tiktok && !$application->jobPost->company->youtube)
                                                Belum ada sosial media
                                            @endif
                                        </div>
                                    </td>
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-6">
                            <!-- Documents Section - Moved Here -->
                            <div class="document-buttons-inline">
                                <label class="fw-bold mb-2 d-block">Dokumen</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @if($application->cover_letter_path)
                                        <a href="{{ route('user.applications.letter', $application->id) }}" target="_blank" class="btn-doc primary">
                                            <i class="fas fa-file-alt"></i> Lihat Surat Lamaran
                                        </a>
                                    @else
                                        <button type="button" class="btn-doc soft" disabled>
                                            <i class="fas fa-file-alt"></i> Tidak ada Surat Lamaran
                                        </button>
                                    @endif

                                    @if($application->cv_path)
                                        <a href="{{ route('user.applications.cv', $application->id) }}" target="_blank" class="btn-doc soft">
                                            <i class="fas fa-eye"></i> Lihat CV
                                        </a>
                                    @else
                                         <button type="button" class="btn-doc soft" disabled>
                                            <i class="fas fa-eye"></i> Tidak ada CV
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($application->description)
                    <div class="mt-3">
                        <h6 class="fw-bold mb-2">Deskripsi Lamaran:</h6>
                        <div class="inner">
                            {{ $application->description }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button at Bottom -->
    <div class="text-center mt-4 mb-4">
        <a href="{{ route('user.applications.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Lamaran
        </a>
    </div>
</div>

<script>
function showNoCoverLetterAlert() {
  alert('Anda tidak melampirkan surat lamaran.');
}
</script>
@endsection