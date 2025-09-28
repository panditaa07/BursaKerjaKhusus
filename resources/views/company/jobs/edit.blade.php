@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Lowongan Pekerjaan
                    </h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Company Logo Preview -->
                    <div class="text-center mb-3">
                        <img id="logoPreview" src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo Perusahaan" width="80" height="80" class="rounded shadow-sm mb-2">
                        <input type="file" name="logo" class="form-control" onchange="previewLogo(event)">
                    </div>

                    <form method="POST" action="{{ route('company.jobs.update', $job) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from" value="{{ request('from', 'all') }}">

                        <!-- Job Info Header -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Info:</strong> Mengedit lowongan kerja "{{ $job->title }}"
                                    <span class="badge bg-primary ms-2">{{ $job->applications->count() }} pelamar</span>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info Card -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Nama Perusahaan</label>
                                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name', $job->company->name) }}">
                                                @error('company_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Alamat Perusahaan</label>
                                                <input type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address', $job->company->address ?? '') }}">
                                                @error('company_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Tanggal Dibuat</label>
                                                <input type="datetime-local" class="form-control @error('created_at') is-invalid @enderror" name="created_at" value="{{ old('created_at', $job->created_at ? $job->created_at->format('Y-m-d\TH:i') : '') }}">
                                                @error('created_at')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label fw-bold">Total Pelamar</label>
                                                <input type="number" class="form-control @error('total_pelamar') is-invalid @enderror" name="total_pelamar" value="{{ old('total_pelamar', $job->total_pelamar ?? $job->applications->count()) }}" min="0">
                                                @error('total_pelamar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle text-primary me-2"></i>Informasi Dasar
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label fw-bold">
                                    Judul Pekerjaan <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $job->title) }}"
                                       placeholder="Contoh: Software Engineer, Marketing Manager, dll"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label fw-bold">Lokasi Kerja <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('location') is-invalid @enderror"
                                       id="location"
                                       name="location"
                                       value="{{ old('location', $job->location) }}"
                                       placeholder="Contoh: Jakarta, Bandung, Remote"
                                       required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="employment_type" class="form-label fw-bold">Jenis Pekerjaan <span class="text-danger">*</span></label>
                                <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type" required>
                                    <option value="">Pilih Jenis Pekerjaan</option>
                                    <option value="full-time" {{ old('employment_type', $job->employment_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ old('employment_type', $job->employment_type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ old('employment_type', $job->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ old('employment_type', $job->employment_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                                    <option value="freelance" {{ old('employment_type', $job->employment_type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                </select>
                                @error('employment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vacancies" class="form-label fw-bold">Jumlah Lowongan <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control @error('vacancies') is-invalid @enderror"
                                       id="vacancies"
                                       name="vacancies"
                                       value="{{ old('vacancies', $job->vacancies) }}"
                                       min="1"
                                       placeholder="Contoh: 1-10"
                                       required>
                                @error('vacancies')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="industry_id" class="form-label fw-bold">Kategori/Bidang Kerja <span class="text-danger">*</span></label>
                                <select class="form-select @error('industry_id') is-invalid @enderror" id="industry_id" name="industry_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}" {{ old('industry_id', $job->industry_id) == $industry->id ? 'selected' : '' }}>{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                                @error('industry_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="min_salary" class="form-label fw-bold">Gaji Minimum</label>
                                <input type="number"
                                       class="form-control gaji-input @error('min_salary') is-invalid @enderror"
                                       id="min_salary"
                                       name="min_salary"
                                       value="{{ old('min_salary', $job->min_salary) }}"
                                       min="0"
                                       placeholder="Contoh: 5000000"
                                       step="1">
                                @error('min_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="max_salary" class="form-label fw-bold">Gaji Maksimum</label>
                                <input type="number"
                                       class="form-control gaji-input @error('max_salary') is-invalid @enderror"
                                       id="max_salary"
                                       name="max_salary"
                                       value="{{ old('max_salary', $job->max_salary) }}"
                                       min="0"
                                       placeholder="Contoh: 7000000"
                                       step="1">
                                @error('max_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="deadline" class="form-label fw-bold">Deadline Lamaran <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control @error('deadline') is-invalid @enderror"
                                       id="deadline"
                                       name="deadline"
                                       value="{{ old('deadline', $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') : '') }}"
                                       required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Opsional. Kosongkan jika tidak ada batas waktu.</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="active" {{ old('status', $job->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $job->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Job Description Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-file-alt text-primary me-2"></i>Deskripsi Pekerjaan
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label fw-bold">
                                    Deskripsi Pekerjaan <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="6"
                                          placeholder="Jelaskan secara detail tentang pekerjaan ini, tanggung jawab, dan ekspektasi..."
                                          required>{{ old('description', $job->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Deskripsikan secara detail tentang posisi ini, tanggung jawab, dan apa yang diharapkan dari kandidat.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="requirements" class="form-label fw-bold">Kualifikasi/Persyaratan</label>
                                <textarea class="form-control @error('requirements') is-invalid @enderror"
                                          id="requirements"
                                          name="requirements"
                                          rows="4"
                                          placeholder="• Pendidikan minimal S1 Teknik Informatika&#10;• Pengalaman minimal 2 tahun&#10;• Menguasai PHP dan Laravel&#10;• Memiliki kemampuan komunikasi yang baik">{{ old('requirements', $job->requirements) }}</textarea>
                                @error('requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Opsional. Cantumkan persyaratan dan kualifikasi yang dibutuhkan untuk posisi ini.</div>
                            </div>
                        </div>

                        <!-- Berkas Lamaran Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-file-alt text-primary me-2"></i>Berkas Lamaran
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="berkas_lamaran" class="form-label fw-bold">Berkas yang Diperlukan</label>
                                <textarea class="form-control @error('berkas_lamaran') is-invalid @enderror"
                                          id="berkas_lamaran"
                                          name="berkas_lamaran"
                                          rows="3"
                                          placeholder="Contoh: CV, Surat Lamaran, Portofolio, Sertifikat">{{ old('berkas_lamaran', $job->berkas_lamaran) }}</textarea>
                                @error('berkas_lamaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Opsional. Sebutkan berkas-berkas yang harus diserahkan oleh pelamar.</div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <hr class="my-4">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set minimum date for deadline to tomorrow
    document.addEventListener('DOMContentLoaded', function() {
        const deadlineInput = document.getElementById('deadline');
        if (deadlineInput) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowStr = tomorrow.toISOString().split('T')[0];
            deadlineInput.setAttribute('min', tomorrowStr);
        }

        // Auto-resize textarea
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
    });
</script>
@endpush
