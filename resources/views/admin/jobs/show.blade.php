@extends('layouts.dashboard')

@section('title', 'Detail Lowongan Kerja')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Detail Lowongan Kerja</h1>
            <div class="space-x-4">
                <a href="{{ route('admin.job-posts.edit', $jobPost) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Lowongan
                </a>
                <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <!-- Header Perusahaan -->
            <div class="border-b pb-6 mb-6">
                <h2 class="text-2xl font-semibold mb-4">Informasi Perusahaan</h2>
                <div class="flex items-center space-x-4">
                    @if($jobPost->company_logo)
                        <img src="{{ asset('storage/' . $jobPost->company_logo) }}" alt="Logo Perusahaan" class="w-16 h-16 object-cover rounded">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                            <span class="text-gray-500">Logo</span>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-bold">{{ $jobPost->company->name ?? 'N/A' }}</h3>
                        <p class="text-gray-600">{{ $jobPost->company->address ?? 'N/A' }}</p>
                        <p class="text-gray-600">{{ $jobPost->company->user->email ?? 'N/A' }}</p>
                        <p class="text-gray-600">{{ $jobPost->company->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Judul Posisi Lowongan -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold">{{ $jobPost->title }}</h2>
            </div>

            <!-- Informasi Umum -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Informasi Umum</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->location }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipe Pekerjaan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->employment_type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Lowongan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->vacancies }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if(in_array($jobPost->status, ['Accepted'])) bg-green-100 text-green-800
                                @elseif(in_array($jobPost->status, ['Rejected'])) bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $jobPost->status }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Posting</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->created_at ? \Carbon\Carbon::parse($jobPost->created_at)->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deadline</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('d/m/Y') : 'N/A' }}</p>
                            @if($jobPost->deadline)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $deadline = \Carbon\Carbon::parse($jobPost->deadline);
                                    $diff = $now->diff($deadline);
                                    $remaining = '';
                                    if ($deadline->isPast()) {
                                        $remaining = 'Deadline telah berlalu';
                                    } else {
                                        $remaining = 'Sisa waktu: ' . $diff->d . ' Hari ' . $diff->h . ' Jam ' . $diff->i . ' Menit';
                                    }
                                @endphp
                                <p class="mt-1 text-sm text-red-600">{{ $remaining }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rentang Gaji</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($jobPost->min_salary || $jobPost->max_salary)
                                    {{ $jobPost->min_salary ?: 'N/A' }} - {{ $jobPost->max_salary ?: 'N/A' }}
                                @else
                                    Tidak ditentukan
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-4">Detail Tambahan</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Industri</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->industry->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jobdesk / Tugas Pekerjaan -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Jobdesk / Tugas Pekerjaan</h3>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach(explode("\n", $jobPost->description) as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Persyaratan -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Persyaratan</h3>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach(explode("\n", $jobPost->requirements) as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Berkas Lamaran -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Berkas Lamaran</h3>
                @if($jobPost->berkas_lamaran)
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach(explode("\n", $jobPost->berkas_lamaran) as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ul>
                @else
                    <ul class="list-disc list-inside text-gray-700">
                        <li>CV (Curriculum Vitae)</li>
                        <li>Portofolio (jika ada)</li>
                        <li>Surat Keterangan (jika diperlukan)</li>
                        <li>Foto KTP</li>
                    </ul>
                @endif
            </div>

            <!-- Deskripsi Tambahan -->
            @if($jobPost->description)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Deskripsi Tambahan</h3>
                    <p class="text-gray-700">{{ $jobPost->description }}</p>
                </div>
            @endif

            <!-- Pelamar -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Pelamar ({{ $jobPost->applications()->count() }})</h3>
                @if($jobPost->applications()->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($jobPost->applications as $application)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $application->user->name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $application->user->email }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($application->status == 'accepted') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $application->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Belum ada pelamar untuk lowongan ini.</p>
                @endif
            </div>

        </div>

        <!-- Tombol Kembali di bawah -->
        <div class="text-center mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
