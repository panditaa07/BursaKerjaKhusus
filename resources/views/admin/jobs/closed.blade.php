@extends('layouts.dashboard')
@section('title', 'Daftar Lowongan Kerja Ditutup')

@section('content')
<div class="container mx-auto px-4 py-4">
    <h1 class="h3 mb-4">Daftar Lowongan Kerja Ditutup</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>NO</th>
                    <th>PERUSAHAAN</th>
                    <th>NO.HRD</th>
                    <th>ALAMAT</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobPosts as $index => $job)
                <tr>
                    <td>{{ $jobPosts->firstItem() + $index }}</td>
                    <td>{{ $job->company->name ?? '-' }}</td>
                    <td>{{ $job->company->phone ?? '-' }}</td>
                    <td>{{ $job->company->address ?? '-' }}</td>
                    <td>
                        <span class="badge badge-secondary">
                            {{ ucfirst($job->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.job-posts.show', $job->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus lowongan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada lowongan yang ditutup.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $jobPosts->links() }}
    </div>
</div>
@endsection