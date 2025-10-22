@extends('layouts.dashboard')

@section('title', 'Tambah Lowongan Kerja')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/tambahlowongancom.css') }}?v={{ time() }}">
@endpush

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
          {{-- Flash success --}}
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i>
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          {{-- Errors --}}
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-triangle me-2"></i>
              <strong>Terjadi kesalahan:</strong>
              <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form method="POST" action="{{ route('company.jobs.store') }}">
            @csrf
            <input type="hidden" name="from" value="{{ request('from', 'all') }}">

            {{-- Informasi Dasar --}}
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
                <input
                  type="text"
                  id="title"
                  name="title"
                  class="form-control @error('title') is-invalid @enderror"
                  value="{{ old('title') }}"
                  placeholder="Contoh: Software Engineer, Marketing Manager, dll"
                  required
                >
                @error('title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="location" class="form-label fw-bold">Lokasi Kerja</label>
                <input
                  type="text"
                  id="location"
                  name="location"
                  class="form-control @error('location') is-invalid @enderror"
                  value="{{ old('location') }}"
                  placeholder="Contoh: Jakarta, Bandung, Remote"
                >
                @error('location')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="employment_type" class="form-label fw-bold">Tipe Pekerjaan</label>
                <select
                  id="employment_type"
                  name="employment_type"
                  class="form-select @error('employment_type') is-invalid @enderror"
                >
                  <option value="">Pilih Tipe Pekerjaan</option>
                  <option value="full-time"  {{ old('employment_type') == 'full-time'  ? 'selected' : '' }}>Full-time</option>
                  <option value="part-time"  {{ old('employment_type') == 'part-time'  ? 'selected' : '' }}>Part-time</option>
                  <option value="contract"   {{ old('employment_type') == 'contract'   ? 'selected' : '' }}>Contract</option>
                  <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                  <option value="freelance"  {{ old('employment_type') == 'freelance'  ? 'selected' : '' }}>Freelance</option>
                </select>
                @error('employment_type')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="industry_id" class="form-label fw-bold">
                  Industri <span class="text-danger">*</span>
                </label>
                <select
                  id="industry_id"
                  name="industry_id"
                  class="form-select @error('industry_id') is-invalid @enderror"
                  required
                >
                  <option value="">Pilih Industri</option>
                  @foreach($industries as $industry)
                    <option value="{{ $industry->id }}" {{ old('industry_id') == $industry->id ? 'selected' : '' }}>
                      {{ $industry->name }}
                    </option>
                  @endforeach
                </select>
                @error('industry_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="salary" class="form-label fw-bold">Rentang Gaji</label>
                <input
                  type="text"
                  id="salary"
                  name="salary"
                  class="form-control @error('salary') is-invalid @enderror"
                  value="{{ old('salary') }}"
                  placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000"
                >
                @error('salary')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Opsional. Kosongkan jika tidak ingin menampilkan informasi gaji.</div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="deadline" class="form-label fw-bold">Deadline Lamaran</label>
                <input
                  type="date"
                  id="deadline"
                  name="deadline"
                  class="form-control @error('deadline') is-invalid @enderror"
                  value="{{ old('deadline') }}"
                >
                @error('deadline')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Opsional. Kosongkan jika tidak ada batas waktu.</div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="vacancies" class="form-label fw-bold">
                  Jumlah Lowongan <span class="text-danger">*</span>
                </label>
                <input
                  type="number"
                  id="vacancies"
                  name="vacancies"
                  class="form-control @error('vacancies') is-invalid @enderror"
                  value="{{ old('vacancies', 1) }}"
                  min="1"
                  required
                >
                @error('vacancies')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            {{-- Deskripsi & Persyaratan --}}
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
                <textarea
                  id="description"
                  name="description"
                  rows="6"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Jelaskan secara detail tentang pekerjaan ini, tanggung jawab, dan ekspektasi..."
                  required
                >{{ old('description') }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Deskripsikan detail posisi, tanggung jawab, dan ekspektasi kandidat.</div>
              </div>

              <div class="col-md-12 mb-3">
                <label for="requirements" class="form-label fw-bold">Persyaratan & Kualifikasi</label>
                <textarea
                  id="requirements"
                  name="requirements"
                  rows="4"
                  class="form-control @error('requirements') is-invalid @enderror"
                  autocomplete="off"
                  placeholder=""
                >{{ old('requirements') }}</textarea>
                @error('requirements')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Opsional. Cantumkan persyaratan & kualifikasi yang dibutuhkan.</div>
              </div>
            </div>

            {{-- Aksi --}}
            <div class="row">
              <div class="col-12">
                <hr class="my-4">
                <div class="d-flex justify-content-between align-items-center gap-3">
                  <a href="{{ url()->previous() }}" class="btn btn-secondary flex-shrink-0">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                  </a>
                  <button type="submit" class="btn btn-primary flex-shrink-0">
                    <i class="fas fa-save me-2"></i>Simpan Lowongan
                  </button>
                </div>
              </div>
            </div>

          </form>
        </div> {{-- /card-body --}}
      </div> {{-- /card --}}
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Set minimal tanggal deadline = besok
    var deadlineInput = document.getElementById('deadline');
    if (deadlineInput) {
      var t = new Date();
      t.setDate(t.getDate() + 1);
      var min = t.toISOString().split('T')[0];
      deadlineInput.setAttribute('min', min);
    }

    // Auto-resize textarea
    document.querySelectorAll('textarea').forEach(function (ta) {
      function grow(){ ta.style.height='auto'; ta.style.height = ta.scrollHeight + 'px'; }
      ta.addEventListener('input', grow);
      grow();
    });
  });
</script>
@endpush
