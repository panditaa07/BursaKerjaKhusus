@extends('layouts.dashboard')

@section('title', 'Detail Lowongan Kerja')

{{-- Panggil CSS --}}
@section('css')
<link rel="stylesheet" href="{{ asset('css/detaillowongankerja.css') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Detail Lowongan Kerja</h1>
            <div class="space-x-4">
                <a href="{{ route('admin.dashboard.lowongan-aktif') }}" class="bg-blue-600 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Lowongan Aktif
                </a>
                <a href="{{ route('admin.dashboard.lowongan-tidak-aktif') }}" class="bg-blue-600 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Lowongan Tidak Aktif
                </a>
                
                <a href="{{ route('admin.job-posts.edit', $jobPost->id) }}" class="bg-blue-600 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit"></i> Edit Lowongan
                </a>
            </div>

        </div>

        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Informasi Lowongan</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->location }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipe Pekerjaan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->employment_type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gaji</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->salary ?: 'Tidak ditentukan' }}</p>
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
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">Detail Tambahan</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Perusahaan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->company->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Industri</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->industry->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Lowongan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->vacancies }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deadline</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->deadline ? \Carbon\Carbon::parse($jobPost->deadline)->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Deskripsi</h2>
                <p class="text-gray-700">{{ $jobPost->description }}</p>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Persyaratan</h2>
                <p class="text-gray-700">{{ $jobPost->requirements }}</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Pelamar ({{ $jobPost->applications()->count() }})</h2>
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
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">{{ $application->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $application->user->email ?? 'N/A' }}</td>
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
    </div>
</div>
@endsection

{{-- Panggil JS --}}
@section('scripts')
<script src="{{ asset('js/detaillowongankerja.js') }}"></script>
@endsection
