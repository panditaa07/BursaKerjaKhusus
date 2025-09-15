@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lowongan Pekerjaan</h2>
        <div class="d-flex align-items-center">
            <span class="mr-3">Loker Tersedia: {{ $totalLoker }}</span>
            <a href="{{ route('admin.job-posts.create') }}" class="btn btn-primary">Tambah Lowongan</a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <form method="GET" action="{{ route('admin.job-posts.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Cari Lowongan" value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary ml-2">Cari</button>
        </form>
    </div>

    <div class="row">
        @forelse($jobPosts as $job)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $job->title }}</h5>
                        <p class="card-text"><strong>Perusahaan:</strong> {{ $job->company?->name ?? '-' }}</p>
                        <p class="card-text"><strong>Gaji:</strong> {{ $job->min_salary ?? '-' }} - {{ $job->max_salary ?? '-' }}</p>
                        <p class="card-text"><strong>Lokasi:</strong> {{ $job->location }}</p>
                        @if($job->deadline)
                            <p class="card-text"><strong>Sisa Waktu:</strong> {{ \Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</p>
                        @endif
                        <div class="mt-auto">
                            <span class="badge badge-{{ $job->status == 'active' ? 'success' : 'secondary' }}">
                                {{ $job->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                            <div class="mt-3">
                                <a href="{{ route('admin.job-posts.show', $job->id) }}" class="btn btn-sm btn-primary">Info</a>
                                <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center">Belum ada lowongan kerja</div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $jobPosts->links() }}
    </div>
</div>
@endsection
