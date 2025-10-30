@extends('layouts.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/editlowonganadmin.css') }}">
@endpush

@section('content')
<div class="container mx-auto px-4 py-4">
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

                    <form method="POST" action="{{ route('admin.job-posts.update', $jobPost) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="from" value="{{ request('from', 'all') }}">
                        <input type="hidden" name="company_id" value="{{ $jobPost->company_id }}">

                        <!-- Basic Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
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
                                       value="{{ old('title', $jobPost->title) }}"
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
                                       value="{{ old('location', $jobPost->location) }}"
                                       placeholder="Contoh: Jakarta, Bandung, Remote"
                                       required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="employment_type" class="form-label fw-bold">Jenis Pekerjaan <span class="text-danger">*</span></label>
                                <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type" required>
                                    <option value="">-- Pilih Tipe Pekerjaan --</option>
                                    <option value="full_time" {{ old('employment_type', $jobPost->employment_type) == 'full_time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part_time" {{ old('employment_type', $jobPost->employment_type) == 'part_time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="internship" {{ old('employment_type', $jobPost->employment_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                                    <option value="freelance" {{ old('employment_type', $jobPost->employment_type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
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
                                       value="{{ old('vacancies', $jobPost->vacancies) }}"
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
                                        <option value="{{ $industry->id }}" {{ old('industry_id', $jobPost->industry_id) == $industry->id ? 'selected' : '' }}>{{ $industry->name }}</option>
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
                                <input type="text"
                                       class="form-control gaji-input @error('min_salary') is-invalid @enderror"
                                       id="min_salary"
                                       name="min_salary"
                                       value="{{ old('min_salary', $jobPost->min_salary) }}"
                                       placeholder="Contoh: 5000000"
                                       inputmode="numeric"
                                       pattern="[0-9]*">
                                @error('min_salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="max_salary" class="form-label fw-bold">Gaji Maksimum</label>
                                <input type="text"
                                       class="form-control gaji-input @error('max_salary') is-invalid @enderror"
                                       id="max_salary"
                                       name="max_salary"
                                       value="{{ old('max_salary', $jobPost->max_salary) }}"
                                       placeholder="Contoh: 7000000"
                                       inputmode="numeric"
                                       pattern="[0-9]*">
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
                                       value="{{ old('deadline', $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('Y-m-d') : '') }}"
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
                                    <option value="active" {{ old('status', $jobPost->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $jobPost->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
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
                                    <i class="fas fa-file-alt me-2"></i>Deskripsi Pekerjaan
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
                                          required>{{ old('description', $jobPost->description) }}</textarea>
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
                                          placeholder="• Pendidikan minimal S1 Teknik Informatika&#10;• Pengalaman minimal 2 tahun&#10;• Menguasai PHP dan Laravel&#10;• Memiliki kemampuan komunikasi yang baik">{{ old('requirements', $jobPost->requirements) }}</textarea>
                                @error('requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Opsional. Cantumkan persyaratan dan kualifikasi yang dibutuhkan untuk posisi ini.</div>
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