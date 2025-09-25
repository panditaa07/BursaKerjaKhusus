@extends('layouts.dashboard')

@section('title', 'Edit Lowongan Kerja')

@section('content')
<link rel="stylesheet" href="{{ asset('css/editlowongan.css') }}">
<div class="progress-bar" id="progressBar"></div>
    
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="header flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold"><i class="fas fa-edit"></i> Edit Lowongan Kerja</h1>
            <a href="{{ route('admin.job-posts.index') }}" class="btn btn-secondary bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="form-container bg-white rounded-lg shadow-md p-6">
            <form id="jobForm" method="POST" action="{{ route('admin.job-posts.update', $jobPost) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Judul --}}
                <div class="form-group mb-4">
                    <label for="title">Judul Lowongan <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" id="title" name="title" value="{{ old('title', $jobPost->title) }}" required placeholder=" ">
                        <div class="floating-label">Contoh: Frontend Developer</div>
                        <i class="fas fa-briefcase input-icon"></i>
                    </div>
                    @error('title')
                        <div class="error-message text-red-500 text-xs italic">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Perusahaan --}}
                <div class="form-group mb-4">
                    <label for="company_id">Perusahaan <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select id="company_id" name="company_id" required>
                            <option value="">Pilih Perusahaan</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id', $jobPost->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-building input-icon"></i>
                    </div>
                    @error('company_id')
                        <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Industri --}}
                <div class="form-group mb-4">
                    <label for="industry_id">Industri <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select id="industry_id" name="industry_id" required>
                            <option value="">Pilih Industri</option>
                            @foreach($industries as $industry)
                                <option value="{{ $industry->id }}" {{ old('industry_id', $jobPost->industry_id) == $industry->id ? 'selected' : '' }}>
                                    {{ $industry->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-industry input-icon"></i>
                    </div>
                    @error('industry_id')
                        <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group mb-4">
                    <label for="description">Deskripsi <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <textarea id="description" name="description" required>{{ old('description', $jobPost->description) }}</textarea>
                        <i class="fas fa-align-left input-icon"></i>
                    </div>
                    @error('description')
                        <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Persyaratan --}}
                <div class="form-group mb-4">
                    <label for="requirements">Persyaratan <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <textarea id="requirements" name="requirements" required>{{ old('requirements', $jobPost->requirements) }}</textarea>
                        <i class="fas fa-list-check input-icon"></i>
                    </div>
                    @error('requirements')
                        <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jumlah & Deadline --}}
                <div class="form-row grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="vacancies">Jumlah Lowongan <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input type="number" id="vacancies" name="vacancies" value="{{ old('vacancies', $jobPost->vacancies) }}" required min="1" placeholder=" ">
                            <div class="floating-label">Jumlah posisi tersedia</div>
                            <i class="fas fa-users input-icon"></i>
                        </div>
                        @error('vacancies')
                            <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input type="date" id="deadline" name="deadline" value="{{ old('deadline', $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('Y-m-d') : '') }}" required>
                            <i class="fas fa-calendar input-icon"></i>
                        </div>
                        @error('deadline')
                            <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Lokasi & Tipe --}}
                <div class="form-row grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="location">Lokasi <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input type="text" id="location" name="location" value="{{ old('location', $jobPost->location) }}" required placeholder=" ">
                            <div class="floating-label">Kota atau remote</div>
                            <i class="fas fa-map-marker-alt input-icon"></i>
                        </div>
                        @error('location')
                            <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="employment_type">Tipe Pekerjaan <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <select id="employment_type" name="employment_type" required>
                                <option value="">Pilih Tipe</option>
                                <option value="Full-time" {{ old('employment_type', $jobPost->employment_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="Part-time" {{ old('employment_type', $jobPost->employment_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="Contract" {{ old('employment_type', $jobPost->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="Internship" {{ old('employment_type', $jobPost->employment_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                            <i class="fas fa-clock input-icon"></i>
                        </div>
                        @error('employment_type')
                            <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Gaji & Status --}}
                <div class="form-row grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="salary">Gaji</label>
                        <div class="input-wrapper">
                            <input type="text" id="salary" name="salary" value="{{ old('salary', $jobPost->salary) }}" placeholder=" ">
                            <div class="floating-label">Rp 5.000.000 - Rp 7.000.000</div>
                            <i class="fas fa-money-bill-wave input-icon"></i>
                        </div>
                        @error('salary')
                            <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <select id="status" name="status" required>
                                <option value="active" {{ old('status', $jobPost->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $jobPost->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <i class="fas fa-toggle-on input-icon"></i>
                        </div>
                        @error('status')
                            <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Logo --}}
                <div class="form-group mb-4">
                    <label for="company_logo">Logo Perusahaan</label>
                    <div class="file-upload">
                        <input type="file" id="company_logo" name="company_logo" accept="image/*">
                        <div class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Klik untuk upload logo atau drag & drop</span>
                        </div>
                    </div>
                    @if($jobPost->company_logo)
                        <div class="current-logo mt-2">
                            <img src="{{ asset('storage/' . $jobPost->company_logo) }}" alt="Logo" class="w-16 h-16 inline-block">
                            <span>Logo saat ini</span>
                        </div>
                    @endif
                    @error('company_logo')
                        <div class="error-message text-red-500 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="form-actions flex justify-end space-x-4">
                    <a href="{{ route('admin.job-posts.index') }}" class="btn btn-cancel bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/editlowongan.js') }}"></script>
@endsection
