@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/detail-lowongan.css') }}">
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

                                <div class="job-details mb-4">
                                    <h5>Detail Lowongan</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <strong>Jenis Pekerjaan:</strong> {{ $job->employment_type }}
                                            </div>
                                            <div class="detail-item">
                                                <strong>Lokasi:</strong> {{ $job->location }}
                                            </div>
                                            @if($job->min_salary || $job->max_salary)
                                            <div class="detail-item">
                                                <strong>Gaji:</strong>
                                                @if($job->min_salary && $job->max_salary)
                                                    Rp {{ number_format((float)$job->min_salary) }} - Rp {{ number_format((float)$job->max_salary) }}
                                                @elseif($job->min_salary)
                                                    Minimum Rp {{ number_format((float)$job->min_salary) }}
                                                @elseif($job->max_salary)
                                                    Maximum Rp {{ number_format((float)$job->max_salary) }}
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-item">
                                                <strong>Jumlah Lowongan:</strong> {{ $job->vacancies }} orang
                                            </div>
                                            @if($job->deadline)
                                            <div class="detail-item">
                                                <strong>Batas Lamaran:</strong> {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                                            </div>
                                            @endif
                                            <div class="detail-item">
                                                <strong>Status:</strong>
                                                <span class="badge {{ $job->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                                    {{ $job->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($job->berkas_lamaran)
                                <div class="application-requirements mb-4">
                                    <h5>Berkas Lamaran</h5>
                                    <div class="requirements-content">
                                        {!! nl2br(e($job->berkas_lamaran)) !!}
                                    </div>
                                </div>
                                @endif
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
                        <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" accept=".pdf,.doc,.docx">
                        @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: PDF, DOC, DOCX. Maksimal 2MB.</div>
                    </div>
                    <div class="mb-3">
                        <label for="cover_letter_file" class="form-label">Upload Surat Lamaran (Opsional)</label>
                        <input type="file" class="form-control @error('cover_letter_file') is-invalid @enderror" id="cover_letter_file" name="cover_letter_file" accept=".pdf,.doc,.docx">
                        @error('cover_letter_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: PDF, DOC, DOCX. Maksimal 2MB.</div>
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
