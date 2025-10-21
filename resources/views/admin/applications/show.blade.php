@extends('layouts.dashboard')

@section('title', 'Detail Pelamar')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detailpelamarcom.css') }}">
@endpush

@section('content')
<div class="container mx-auto px-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h1 class="h3 mb-0">Detail Pelamar</h1>
        
        @if(request('from') == 'total')
            <a href="{{ route('admin.dashboard.pelamar') }}" class="btn-kembali">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke daftar pelamar
            </a>
        @elseif(request('from') == 'bulanini')
            <a href="{{ route('admin.dashboard.pelamar.bulanini') }}" class="btn-kembali">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke pelamar bulan ini
            </a>
        @else
            <a href="{{ route('admin.dashboard.index') }}" class="btn-kembali">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke dashboard
            </a>
        @endif
    </div>

    <!-- Profile Photo -->
    <div class="mb-4 text-center">
        @if($application->user && $application->user->profile_photo_path)
            <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}"
                 alt="Foto Profil"
                 class="rounded-circle border"
                 style="width: 32px; height: 32px; object-fit: cover;">
        @else
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                 style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                {{ strtoupper(substr($application->user->name ?? 'N', 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="row g-3">
        <!-- Personal Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Informasi Pribadi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="140">NIK/NISN:</td>
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
                                    <td class="fw-bold" width="140">Tanggal Lahir:</td>
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
                                                'submitted' => ['label' => 'Menunggu',  'class' => 'status-chip chip--submitted'],
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
                    <h5 class="mb-0"><i class="fas fa-file-download"></i> Dokumen</h5>
                </div>
                <div class="card-body">
                    @if($application->cover_letter_path || ($application->user && $application->user->cover_letter_path))
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn-doc primary flex-fill"
                                    onclick="window.open('{{ route('admin.users.preview_cover_letter', $application->user) }}', '_blank')">
                                <i class="fas fa-file-alt"></i> Lihat Surat Lamaran
                            </button>
                            <a href="{{ route('admin.users.download_cover_letter', $application->user) }}"
                               class="btn-doc secondary" target="_blank" download>
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    @else
                        <button type="button" class="btn-doc soft mb-2" onclick="showNoCoverLetterAlert()">
                            <i class="fas fa-file-alt"></i> Lihat Surat Lamaran
                        </button>
                    @endif

                    @if($application->cv_path || ($application->user && $application->user->cv_path))
                        <div class="d-flex gap-2">
                            <button type="button" class="btn-doc soft flex-fill"
                                    onclick="window.open('{{ route('admin.users.preview_cv', $application->user) }}', '_blank')">
                                <i class="fas fa-eye"></i> Preview CV
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Social Media & Portfolio -->
            @if($application->user)
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary">
                    <h5 class="mb-0"><i class="fas fa-share-alt"></i> Sosial Media & Portfolio</h5>
                </div>
                <div class="card-body text-center">
                    @if($application->user->portfolio_link || $application->user->facebook || $application->user->instagram || $application->user->linkedin || $application->user->twitter || $application->user->tiktok)
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            @if($application->user->portfolio_link)
                                <a href="{{ $application->user->portfolio_link }}" target="_blank"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-globe me-1"></i> Portfolio
                                </a>
                            @endif
                            @if($application->user->facebook)
                                <a href="{{ $application->user->facebook }}" target="_blank"
                                   class="btn btn-outline-primary btn-sm"><i class="fab fa-facebook"></i></a>
                            @endif
                            @if($application->user->instagram)
                                <a href="{{ $application->user->instagram }}" target="_blank"
                                   class="btn btn-outline-danger btn-sm"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if($application->user->linkedin)
                                <a href="{{ $application->user->linkedin }}" target="_blank"
                                   class="btn btn-outline-primary btn-sm"><i class="fab fa-linkedin"></i></a>
                            @endif
                            @if($application->user->twitter)
                                <a href="{{ $application->user->twitter }}" target="_blank"
                                   class="btn btn-outline-info btn-sm"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($application->user->tiktok)
                                <a href="{{ $application->user->tiktok }}" target="_blank"
                                   class="btn btn-outline-dark btn-sm"><i class="fab fa-tiktok"></i></a>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0">Tidak ada sosial media atau portfolio</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Status Update -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.applications.update', $application->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Baru:</label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Menunggu</option>
                                <option value="reviewed"  {{ $application->status == 'reviewed' ? 'selected' : '' }}>Ditinjau</option>
                                <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Wawancara</option>
                                <option value="test1"     {{ $application->status == 'test1' ? 'selected' : '' }}>Test 1</option>
                                <option value="test2"     {{ $application->status == 'test2' ? 'selected' : '' }}>Test 2</option>
                                <option value="accepted"  {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                <option value="rejected"  {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-update w-100">
                            <i class="fas fa-save me-2"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function showNoCoverLetterAlert() {
  alert('Pelamar tidak mencantumkan surat lamaran.');
}
</script>
@endsection