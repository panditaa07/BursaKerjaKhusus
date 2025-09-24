@extends('layouts.dashboard')

@section('title', 'Detail Pelamar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detail Pelamar</h1>
        <a href="{{ route('company.pelamar.all') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Profile Photo Section -->
    <div class="mb-4 text-center">
        @if($application->user && $application->user->profile_photo_path)
            <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}"
                 alt="Foto Profil"
                 class="rounded-circle border"
                 style="width: 120px; height: 120px; object-fit: cover;">
        @else
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                 style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                {{ strtoupper(substr($application->user->name ?? 'N', 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="120">NIK/NISN:</td>
                                    <td>{{ $application->user ? $application->user->nisn ?? '-' : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Nama Lengkap:</td>
                                    <td>{{ $application->user ? $application->user->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>{{ $application->user ? $application->user->email : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">No. HP:</td>
                                    <td>{{ $application->user ? $application->user->phone ?? '-' : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="120">Tanggal Lahir:</td>
                                    <td>{{ $application->user && $application->user->birth_date ? \Carbon\Carbon::parse($application->user->birth_date)->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Alamat:</td>
                                    <td>{{ $application->user ? $application->user->address ?? '-' : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Profil:</td>
                                    <td>{{ $application->user ? $application->user->short_profile ?? '-' : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Informasi Lamaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="120">Lowongan:</td>
                                    <td>{{ $application->jobPost->title ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Perusahaan:</td>
                                    <td>{{ $application->jobPost->company->name ?? '-' }}</td>
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
                                    <td class="fw-bold" width="120">Status:</td>
                                    <td>
                                        @php
                                            $status = $application->status;
                                            $statusConfig = [
                                                'accepted' => ['label' => 'Diterima', 'class' => 'bg-success'],
                                                'rejected' => ['label' => 'Ditolak', 'class' => 'bg-danger'],
                                                'interview' => ['label' => 'Wawancara', 'class' => 'bg-primary'],
                                                'test1' => ['label' => 'Test 1', 'class' => 'bg-warning'],
                                                'test2' => ['label' => 'Test 2', 'class' => 'bg-warning'],
                                                'submitted' => ['label' => 'Menunggu', 'class' => 'bg-secondary'],
                                                'reviewed' => ['label' => 'Ditinjau', 'class' => 'bg-info'],
                                            ];
                                            $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-light'];
                                        @endphp
                                        <span class="badge {{ $currentStatus['class'] }} text-white px-3 py-2">
                                            {{ $currentStatus['label'] }}
                                        </span>
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
                    <div class="mt-3">
                        <h6 class="fw-bold">Deskripsi Lamaran:</h6>
                        <div class="border p-3 rounded bg-light">
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
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-file-download me-2"></i>Dokumen</h5>
                </div>
                <div class="card-body">
                    @if($application->cv_path)
                        <a href="{{ route('company.applications.download', $application->id) }}"
                           class="btn btn-success btn-sm w-100 mb-2" target="_blank">
                            <i class="fas fa-download me-2"></i>Download CV
                        </a>
                    @else
                        <p class="text-muted mb-2">CV tidak tersedia</p>
                    @endif

                    @if($application->cover_letter)
                        <a href="{{ asset('storage/' . $application->cover_letter) }}"
                           class="btn btn-info btn-sm w-100 mb-2" target="_blank">
                            <i class="fas fa-file-alt me-2"></i>Lihat Surat Lamaran
                        </a>
                    @endif

                    @if($application->cv_path)
                        <a href="{{ route('company.applications.preview', $application->id) }}"
                           class="btn btn-outline-primary btn-sm w-100" target="_blank">
                            <i class="fas fa-eye me-2"></i>Preview CV
                        </a>
                    @endif
                </div>
            </div>

            <!-- Social Media -->
            @if($application->user)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Sosial Media</h5>
                </div>
                <div class="card-body text-center">
                    @if($application->user->facebook || $application->user->instagram || $application->user->linkedin || $application->user->twitter || $application->user->tiktok)
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            @if($application->user->facebook)
                                <a href="{{ $application->user->facebook }}" target="_blank"
                                   class="btn btn-outline-primary btn-sm" title="Facebook">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            @endif
                            @if($application->user->instagram)
                                <a href="{{ $application->user->instagram }}" target="_blank"
                                   class="btn btn-outline-danger btn-sm" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if($application->user->linkedin)
                                <a href="{{ $application->user->linkedin }}" target="_blank"
                                   class="btn btn-outline-primary btn-sm" title="LinkedIn">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            @endif
                            @if($application->user->twitter)
                                <a href="{{ $application->user->twitter }}" target="_blank"
                                   class="btn btn-outline-info btn-sm" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if($application->user->tiktok)
                                <a href="{{ $application->user->tiktok }}" target="_blank"
                                   class="btn btn-outline-dark btn-sm" title="TikTok">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                            @endif
                        </div>
                    @else
                        <p class="text-muted">Tidak ada sosial media</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Status Update -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Baru:</label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>Ditinjau</option>
                                <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Wawancara</option>
                                <option value="test1" {{ $application->status == 'test1' ? 'selected' : '' }}>Test 1</option>
                                <option value="test2" {{ $application->status == 'test2' ? 'selected' : '' }}>Test 2</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .gap-2 > * {
        margin: 0.25rem;
    }
    .table-borderless td {
        padding: 0.5rem 0;
        border: none;
    }
    .card {
        transition: box-shadow 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
