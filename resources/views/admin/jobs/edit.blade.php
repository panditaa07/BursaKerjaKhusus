@extends('layouts.dashboard')

@section('title', 'Edit Lowongan Kerja')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Edit Lowongan Kerja</h1>
            <a href="{{ route('admin.job-posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('admin.job-posts.update', $jobPost) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul Lowongan *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $jobPost->title) }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" required>
                    @error('title')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="company_id" class="block text-gray-700 text-sm font-bold mb-2">Perusahaan *</label>
                    <select id="company_id" name="company_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('company_id') border-red-500 @enderror" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $jobPost->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="industry_id" class="block text-gray-700 text-sm font-bold mb-2">Industri *</label>
                    <select id="industry_id" name="industry_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('industry_id') border-red-500 @enderror" required>
                        <option value="">Pilih Industri</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}" {{ old('industry_id', $jobPost->industry_id) == $industry->id ? 'selected' : '' }}>{{ $industry->name }}</option>
                        @endforeach
                    </select>
                    @error('industry_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi *</label>
                    <textarea id="description" name="description" rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" required>{{ old('description', $jobPost->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="requirements" class="block text-gray-700 text-sm font-bold mb-2">Persyaratan *</label>
                    <textarea id="requirements" name="requirements" rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('requirements') border-red-500 @enderror" required>{{ old('requirements', $jobPost->requirements) }}</textarea>
                    @error('requirements')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="vacancies" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Lowongan *</label>
                        <input type="number" id="vacancies" name="vacancies" value="{{ old('vacancies', $jobPost->vacancies) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('vacancies') border-red-500 @enderror" required min="1">
                        @error('vacancies')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="deadline" class="block text-gray-700 text-sm font-bold mb-2">Deadline *</label>
                        <input type="date" id="deadline" name="deadline" value="{{ old('deadline', $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('deadline') border-red-500 @enderror" required>
                        @error('deadline')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi *</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $jobPost->location) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" required>
                        @error('location')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employment_type" class="block text-gray-700 text-sm font-bold mb-2">Tipe Pekerjaan *</label>
                        <select id="employment_type" name="employment_type"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('employment_type') border-red-500 @enderror" required>
                            <option value="">Pilih Tipe</option>
                            <option value="Full-time" {{ old('employment_type', $jobPost->employment_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('employment_type', $jobPost->employment_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="Contract" {{ old('employment_type', $jobPost->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Internship" {{ old('employment_type', $jobPost->employment_type) == 'Internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        @error('employment_type')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="salary" class="block text-gray-700 text-sm font-bold mb-2">Gaji</label>
                        <input type="text" id="salary" name="salary" value="{{ old('salary', $jobPost->salary) }}" placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('salary') border-red-500 @enderror">
                        @error('salary')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status *</label>
                        <select id="status" name="status"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror" required>
                            <option value="active" {{ old('status', $jobPost->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $jobPost->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="company_logo" class="block text-gray-700 text-sm font-bold mb-2">Logo Perusahaan</label>
                    <input type="file" id="company_logo" name="company_logo" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('company_logo') border-red-500 @enderror">
                    @if($jobPost->company_logo)
                        <p class="text-sm text-gray-600 mt-1">Logo saat ini: <img src="{{ asset('storage/' . $jobPost->company_logo) }}" alt="Logo" class="w-16 h-16 inline-block"></p>
                    @endif
                    @error('company_logo')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.job-posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
