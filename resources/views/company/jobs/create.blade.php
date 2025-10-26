@extends('layouts.dashboard')

@section('title', 'Tambah Lowongan Kerja')

@stack('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/tambahlowongancom.css') }}?v={{ time() }}">

@section('content')
<div class="title-wrapper text-center mb-8">
    <h2 class="page-title">
        <i class="fas fa-briefcase"></i> Tambah Lowongan Kerja
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md p-6 job-form-container mx-auto px-4 py-4">
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

    <form method="POST" action="{{ route('company.jobs.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="from" value="{{ request('from', 'all') }}">

        {{-- Judul Lowongan --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-briefcase mr-2 text-blue-500"></i> Judul Lowongan 
            </label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                required>
            @error('title')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Industri --}}
        <div class="mb-4">
            <label for="industry_id" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-gears mr-2 text-blue-500"></i> Industri 
            </label>
            <select id="industry_id" name="industry_id"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('industry_id') border-red-500 @enderror"
                required>
                <option value="">Pilih Industri</option>
                @foreach($industries as $industry)
                    <option value="{{ $industry->id }}" {{ old('industry_id') == $industry->id ? 'selected' : '' }}>
                        {{ $industry->name }}
                    </option>
                @endforeach
            </select>
            @error('industry_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-file-lines mr-2 text-blue-500"></i> Deskripsi 
            </label>
            <textarea id="description" name="description" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Persyaratan --}}
        <div class="mb-4">
            <label for="requirements" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-list-check mr-2 text-blue-500"></i> Persyaratan 
            </label>
            <textarea id="requirements" name="requirements" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('requirements') border-red-500 @enderror"
                required>{{ old('requirements') }}</textarea>
            @error('requirements')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lokasi --}}
        <div class="mb-4">
            <label for="location" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-location-dot mr-2 text-blue-500"></i> Lokasi 
            </label>
            <input type="text" id="location" name="location" value="{{ old('location') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror"
                required>
            @error('location')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tipe Pekerjaan --}}
        <div class="mb-4">
            <label for="employment_type" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fas fa-clock mr-2 text-blue-500"></i> Tipe Pekerjaan
            </label>
            <select id="employment_type" name="employment_type"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('employment_type') border-red-500 @enderror"
                required>
                <option value="">-- Pilih Tipe Pekerjaan --</option>
                <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full-time</option>
                <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part-time</option>
                <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                <option value="freelance" {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
            </select>
            @error('employment_type')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah Lowongan --}}
        <div class="mb-4">
            <label for="vacancies" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-users mr-2 text-blue-500"></i> Jumlah Lowongan 
            </label>
            <input type="number" id="vacancies" name="vacancies" value="{{ old('vacancies') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('vacancies') border-red-500 @enderror"
                required min="1">
            @error('vacancies')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deadline --}}
        <div class="mb-4">
            <label for="deadline" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-calendar-days mr-2 text-blue-500"></i> Deadline 
            </label>
            <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('deadline') border-red-500 @enderror"
                required>
            @error('deadline')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gaji --}}
        <div class="mb-4">
            <label for="salary" class="block text-gray-700 text-sm font-bold mb-2 flex items-center">
                <i class="fa-solid fa-money-bill-wave mr-2 text-blue-500"></i> Gaji
            </label>
            <input type="text" id="salary" name="salary" value="{{ old('salary') }}"
                placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('salary') border-red-500 @enderror">
            @error('salary')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-actions flex items-center space-x-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow inline-flex items-center">
                <i class="fa-solid fa-save mr-2"></i> Simpan Lowongan
            </button>
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a> 
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelector(".page-title")?.classList.add("show");
        document.querySelector(".job-form-container")?.classList.add("show");
        
        // Set minimum date for deadline to tomorrow
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