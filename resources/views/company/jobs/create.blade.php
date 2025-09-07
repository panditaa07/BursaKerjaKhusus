@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Tambah Lowongan Pekerjaan Baru</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('company.jobs.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Judul Pekerjaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="requirements" class="form-label">Persyaratan</label>
                            <textarea class="form-control @error('requirements') is-invalid @enderror" 
                                      id="requirements" name="requirements" rows="3">{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="location" class="form-label">Lokasi</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location') }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">Tipe Pekerjaan</label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                        <option value="">Pilih Tipe</option>
                                        <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                        <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                        <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="salary" class="form-label">Gaji</label>
                                    <input type="text" class="form-control @error('salary') is-invalid @enderror" 
                                           id="salary" name="salary" value="{{ old('salary') }}" 
                                           placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000">
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="deadline" class="form-label">Deadline Lamaran</label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                           id="deadline" name="deadline" value="{{ old('deadline') }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Lowongan
                            </button>
                            <a href="{{ route('company.jobs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
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
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tomorrowStr = tomorrow.toISOString().split('T')[0];
        document.getElementById('deadline').setAttribute('min', tomorrowStr);
    });
</script>
@endpush
