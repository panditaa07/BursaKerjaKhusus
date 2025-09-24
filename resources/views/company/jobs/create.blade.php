@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Lowongan Pekerjaan Baru
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

                    <form method="POST" action="{{ route('company.jobs.store') }}">
                        @csrf
                        <input type="hidden" name="from" value="{{ request('from', 'all') }}">

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
                                       value="{{ old('title') }}"
                                       placeholder="Contoh: Software Engineer, Marketing Manager, dll"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label fw-bold">Lokasi Kerja</label>
                                <input type="text"
                                       class="form-control @error('location') is-invalid @enderror"
                                       id="location"
                                       name="location"
                                       value="{{ old('location') }}"
                                       placeholder="Contoh: Jakarta, Bandung, Remote">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">Tipe Pekerjaan</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                    <option value="">Pilih Tipe Pekerjaan</option>
                                    <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                    <option value="freelance" {{ old('type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="salary" class="form-label fw-bold">Rentang Gaji</label>
                                <input type="text"
                                       class="form-control @error('salary') is-invalid @enderror"
                                       id="salary"
                                       name="salary"
                                       value="{{ old('salary') }}"
                                       placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000">
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Opsional. Kosongkan jika tidak ingin menampilkan informasi gaji.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="deadline" class="form-label fw-bold">Deadline Lamaran</label>
                                <input type="date"
                                       class="form-control @error('deadline') is-invalid @enderror"
                                       id="deadline"
                                       name="deadline"
                                       value="{{ old('deadline') }}">
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Opsional. Kosongkan jika tidak ada batas waktu.</div>
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
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Deskripsikan secara detail tentang posisi ini, tanggung jawab, dan apa yang diharapkan dari kandidat.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="requirements" class="form-label fw-bold">Persyaratan & Kualifikasi</label>
                                <textarea class="form-control @error('requirements') is-invalid @enderror"
                                          id="requirements"
                                          name="requirements"
                                          rows="4"
                                          placeholder="• Pendidikan minimal S1 Teknik Informatika&#10;• Pengalaman minimal 2 tahun&#10;• Menguasai PHP dan Laravel&#10;• Memiliki kemampuan komunikasi yang baik">{{ old('requirements') }}</textarea>
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
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Simpan Lowongan
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
