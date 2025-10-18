@extends('layouts.dashboard')

@section('title', 'Edit Lowongan Kerja')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detailpengguna.css') }}">
@endsection

@section('content')
<div class="detail-pengguna-page">
    <h1>Edit Lowongan Kerja</h1>
    <div class="d-flex gap-2 mb-3">
        @if(request('from') == 'kelola')
            <a href="{{ route('admin.job-posts.index') }}" class="btn-custom back">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @elseif($jobPost->status == 'active')
            <a href="{{ route('admin.dashboard.lowongan-aktif') }}" class="btn-custom back">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @elseif($jobPost->status == 'inactive')
            <a href="{{ route('admin.dashboard.lowongan-tidak-aktif') }}" class="btn-custom back">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        @endif
        <a href="{{ route('admin.job-posts.show', $jobPost->id) }}?from={{ request('from') }}" class="btn btn-custom back">
            <i class="fas fa-eye"></i> Lihat Detail
        </a>
    </div>

    <form id="jobForm" method="POST" action="{{ route('admin.job-posts.update', $jobPost) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="card mb-4">
            <div class="card-header">
                <h3>Informasi Lowongan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label"><strong>Judul:</strong></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $jobPost->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label"><strong>Lokasi:</strong></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                   id="location" name="location" value="{{ old('location', $jobPost->location) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="employment_type" class="form-label"><strong>Tipe Pekerjaan:</strong></label>
                            <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type" required>
                                <option value="">Pilih Tipe</option>
                                <option value="Full-time" {{ old('employment_type', $jobPost->employment_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="Part-time" {{ old('employment_type', $jobPost->employment_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="Contract" {{ old('employment_type', $jobPost->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="Internship" {{ old('employment_type', $jobPost->employment_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                            @error('employment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="salary" class="form-label"><strong>Gaji:</strong></label>
                            <input type="text" class="form-control @error('salary') is-invalid @enderror"
                                   id="salary" name="salary" value="{{ old('salary', $jobPost->salary) }}">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label"><strong>Status:</strong></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $jobPost->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $jobPost->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="deadline" class="form-label"><strong>Deadline:</strong></label>
                            <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                   id="deadline" name="deadline" value="{{ old('deadline', $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('Y-m-d') : '') }}" required>
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Detail Tambahan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_id" class="form-label"><strong>Perusahaan:</strong></label>
                            <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id" required>
                                <option value="">Pilih Perusahaan</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $jobPost->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="industry_id" class="form-label"><strong>Industri:</strong></label>
                            <select class="form-select @error('industry_id') is-invalid @enderror" id="industry_id" name="industry_id" required>
                                <option value="">Pilih Industri</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}" {{ old('industry_id', $jobPost->industry_id) == $industry->id ? 'selected' : '' }}>
                                        {{ $industry->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('industry_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="vacancies" class="form-label"><strong>Jumlah Lowongan:</strong></label>
                    <input type="number" class="form-control @error('vacancies') is-invalid @enderror"
                           id="vacancies" name="vacancies" value="{{ old('vacancies', $jobPost->vacancies) }}" required min="1">
                    @error('vacancies')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="company_logo" class="form-label"><strong>Logo Perusahaan:</strong></label>
                    <input type="file" class="form-control @error('company_logo') is-invalid @enderror"
                           id="company_logo" name="company_logo" accept="image/*">
                    @if($jobPost->company_logo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $jobPost->company_logo) }}" alt="Logo" class="img-thumbnail" style="max-width: 100px;">
                            <small class="text-muted">Logo saat ini</small>
                        </div>
                    @endif
                    @error('company_logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Deskripsi</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4" required>{{ old('description', $jobPost->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Persyaratan</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <textarea class="form-control @error('requirements') is-invalid @enderror"
                              id="requirements" name="requirements" rows="4" required>{{ old('requirements', $jobPost->requirements) }}</textarea>
                    @error('requirements')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Informasi Lowongan</h3>
            </div>
            <div class="card-body">
                <p><strong>Created:</strong> {{ $jobPost->created_at->format('d M Y H:i') }}</p>
                <p><strong>Last Updated:</strong> {{ $jobPost->updated_at->format('d M Y H:i') }}</p>
                <p><strong>ID:</strong> {{ $jobPost->id }}</p>
                <p><strong>Total Pelamar:</strong> {{ $jobPost->applications()->count() }}</p>
            </div>
        </div>

        <div class="d-flex gap-2 mb-3">
            <button type="submit" class="btn btn-custom edit">
                <i class="fas fa-save"></i> Update Lowongan
            </button>
        </div>
    </form>
</div>
@endsection

{{-- Panggil JS --}}
@section('scripts')
<script src="{{ asset('js/detail.js') }}"></script>
@endsection
