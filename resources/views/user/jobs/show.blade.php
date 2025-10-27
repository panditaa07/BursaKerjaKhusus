@extends('layouts.dashboard')

@section('title', 'Detail Lowongan Kerja')

@section('content')
<link rel="stylesheet" href="{{ asset('css/detail-lowongan.css') }}">
<link rel="stylesheet" href="{{ asset('css/detaillowongancomp.css') }}?v={{ time() }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Detail Lowongan Kerja</h4>
                </div>
                <div class="card-body">
                    @if($job->status !== 'active')
                        <div class="alert alert-info">
                            Lowongan ini saat ini tidak aktif. Silakan lihat lowongan aktif lainnya.
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-8">
                            <div class="job-detail">
                                <div class="job-header mb-4">
                                    <h3 class="job-title">{{ $job->title }}</h3>
                                    <div class="job-meta">
                                        <span class="badge badge-primary">{{ $job->employment_type }}</span>
                                        <span class="text-muted">•</span>
                                        <span>{{ $job->location }}</span>
                                        <span class="text-muted">•</span>
                                        <span>Diposting {{ $job->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                {{-- ...lanjutan kode kamu tetap sama --}}


                                <div class="company-info mb-4">
                                    <h5>Informasi Perusahaan</h5>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $job->company->user && $job->company->user->profile_photo_path ? asset('storage/' . $job->company->user->profile_photo_path) : asset('images/logo-smk.png') }}"
                                             alt="Company Logo" class="company-logo me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <h6 class="mb-1">{{ $job->company->name }}</h6>
                                            <p class="text-muted mb-0">{{ $job->company->address ?? 'Alamat tidak tersedia' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Job Details Grid -->
                                <div class="info-grid-enhanced mb-5">
                                    <!-- Informasi Umum -->
                                    <div class="info-card-enhanced">
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
                                                    {{ $job->location }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tipe Pekerjaan:</td>
                                                <td>
                                                    <i class="fas fa-clock text-primary me-2"></i>
                                                    {{ $job->employment_type }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Jumlah Lowongan:</td>
                                                <td>
                                                    <i class="fas fa-users text-primary me-2"></i>
                                                    {{ $job->vacancies }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Deadline:</td>
                                                <td>
                                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
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
                                                    <i class="fas fa-money-bill text-primary me-2"></i>
                                                    @if($job->min_salary || $job->max_salary)
                                                        Rp {{ number_format((float)($job->min_salary ?: 0)) }} - Rp {{ number_format((float)($job->max_salary ?: 0)) }}
                                                    @else
                                                        Tidak ditentukan
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Detail Tambahan -->
                                    <div class="info-card-enhanced">
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
                                                    {{ $job->industry->name ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Total Pelamar:</td>
                                                <td>
                                                    <i class="fas fa-users text-primary me-2"></i>
                                                    {{ $job->applications->count() }} pelamar
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Status:</td>
                                                <td>
                                                    <span class="badge-enhanced
                                                        @if(in_array($job->status, ['active'])) bg-success
                                                        @else bg-danger @endif">
                                                        <i class="fas fa-{{ in_array($job->status, ['active']) ? 'check' : 'times' }} me-1"></i>
                                                        {{ $job->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Tanggal Dibuat:</td>
                                                <td>
                                                    <i class="fas fa-calendar text-primary me-2"></i>
                                                    {{ $job->created_at ? \Carbon\Carbon::parse($job->created_at)->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="job-description mb-4">
                                    <h5>Deskripsi Pekerjaan</h5>
                                    <div class="description-content">
                                        {!! nl2br(e($job->description)) !!}
                                    </div>
                                </div>

                                @if($job->requirements)
                                <div class="job-requirements mb-4">
                                    <h5>Kualifikasi</h5>
                                    <div class="requirements-content">
                                        {!! nl2br(e($job->requirements)) !!}
                                    </div>
                                </div>
                                @endif

                                @if($job->berkas_lamaran)
                                <div class="application-requirements mb-4">
                                    <h5>Berkas Lamaran</h5>
                                    <div class="requirements-content">
                                        {!! nl2br(e($job->berkas_lamaran)) !!}
                                    </div>
                                </div>
                                @endif

                                <!-- Sosial Media Perusahaan -->
                                <div class="company-social-media mb-4">
                                    <h5>Sosial Media Perusahaan</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if($job->company->linkedin)
                                            <a href="{{ $job->company->linkedin }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                <i class="fa-brands fa-linkedin"></i> LinkedIn
                                            </a>
                                        @endif
                                        @if($job->company->social_media)
                                            <a href="{{ $job->company->social_media }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                <i class="fa-brands fa-instagram"></i> Instagram
                                            </a>
                                        @endif
                                        @if($job->company->facebook)
                                            <a href="{{ $job->company->facebook }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                <i class="fa-brands fa-facebook"></i> Facebook
                                            </a>
                                        @endif
                                        @if($job->company->twitter)
                                            <a href="{{ $job->company->twitter }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                <i class="fa-brands fa-twitter"></i> Twitter
                                            </a>
                                        @endif
                                        @if($job->company->tiktok)
                                            <a href="{{ $job->company->tiktok }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                <i class="fa-brands fa-tiktok"></i> TikTok
                                            </a>
                                        @endif
                                        @if($job->company->youtube)
                                            <a href="{{ $job->company->youtube }}" target="_blank" style="color: #6C4F3D; text-decoration: none;">
                                                <i class="fa-brands fa-youtube"></i> YouTube
                                            </a>
                                        @endif
                                        @if(!$job->company->linkedin && !$job->company->social_media && !$job->company->facebook && !$job->company->twitter && !$job->company->tiktok && !$job->company->youtube)
                                            Belum ada sosial media
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="apply-section">
                                <div class="card">
                                    <div class="card-body text-center">
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if(session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <h5 class="card-title">Ingin Melamar?</h5>
                                        <p class="card-text">Kirim lamaran Anda untuk lowongan ini</p>
                                        {{-- Application form modal trigger --}}
                                        <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#applyModal">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Lamar Sekarang
                                        </button>
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $job->applications->count() }} pelamar
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="share-section mt-3">
                                    <h6>Bagikan Lowongan</h6>
                                    <div class="share-buttons">
                                        <a href="https://wa.me/?text={{ urlencode('Lihat lowongan kerja: ' . $job->title . ' - ' . route('jobs.show', $job->id)) }}"
                                           class="btn btn-success btn-sm me-2" target="_blank">
                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                        </a>
                                        <button class="btn btn-primary btn-sm" onclick="copyToClipboard()">
                                            <i class="fas fa-copy"></i> Salin Link
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
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
</div>

<!-- Application Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Kirim Lamaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="job_post_id" value="{{ $job->id }}">
                    <div class="mb-3">
                        <label for="cv" class="form-label">Upload CV (Opsional)</label>
                        <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" accept=".pdf">
                        @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: PDF. Maksimal 2MB.</div>
                    </div>
                    <div class="mb-3">
                        <label for="cover_letter_file" class="form-label">Upload Surat Lamaran (Opsional)</label>
                        <input type="file" class="form-control @error('cover_letter_file') is-invalid @enderror" id="cover_letter_file" name="cover_letter_file" accept=".pdf">
                        @error('cover_letter_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: PDF. Maksimal 2MB.</div>
                    </div>
                    <div class="mb-3">
                        <label for="cover_letter" class="form-label">Surat Lamaran (Opsional)</label>
                        <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter" rows="4" placeholder="Tulis surat lamaran Anda di sini..."></textarea>
                        @error('cover_letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyToClipboard() {
    const url = '{{ route("jobs.show", $job->id) }}';
    navigator.clipboard.writeText(url).then(function() {
        alert('Link berhasil disalin!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>

<style>
.job-title {
    color: var(--primary);
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.job-meta {
    color: var(--gray-600);
    font-size: 0.9rem;
}

.company-logo {
    border: 2px solid var(--gray-200);
}

.description-content, .requirements-content {
    line-height: 1.6;
    color: var(--gray-700);
}

.detail-item {
    margin-bottom: 1rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--gray-100);
}

.detail-item:last-child {
    border-bottom: none;
}

.apply-section .card {
    box-shadow: var(--shadow-lg);
    border: none;
}

.share-buttons .btn {
    margin-bottom: 0.5rem;
}

.badge-primary {
    background: var(--primary);
}

.badge-success {
    background: var(--success);
}

.badge-secondary {
    background: var(--gray-500);
}
</style>
<script src="{{ asset('js/detail-lowongan.js') }}"></script>
@endsection
