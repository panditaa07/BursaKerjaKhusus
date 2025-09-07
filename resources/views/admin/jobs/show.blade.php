@extends('layouts.app')

@section('title', 'Detail Lowongan Kerja')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Detail Lowongan Kerja</h1>
            <div class="space-x-4">
                <a href="{{ route('company.admin.job-posts.edit', $jobPost) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            <a href="{{ route('company.admin.job-posts.all') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
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
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gaji</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->salary ?: 'Tidak ditentukan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($jobPost->status == 'active') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $jobPost->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Terakhir Diupdate</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $jobPost->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">Deskripsi & Persyaratan</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <div class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-md">
                                {!! nl2br(e($jobPost->description)) !!}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Persyaratan</label>
                            <div class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-md">
                                {!! nl2br(e($jobPost->requirements)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
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
    </div>
</div>
@endsection
