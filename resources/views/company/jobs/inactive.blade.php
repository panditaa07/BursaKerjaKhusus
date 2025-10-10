@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelolalowongankerjacom.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lowongan Tidak Aktif</h2>
        <div class="d-flex align-items-center">
            <span class="mr-3">Total Lowongan: {{ $jobs->total() }}</span>
            <a href="{{ route('company.jobs.create') }}?from=inactive" class="btn btn-primary">Tambah Lowongan</a>
        </div>
    </div>



    <!-- Search Bar -->
    <div class="mb-4">
        <form method="GET" action="{{ route('company.jobs.inactive') }}" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Cari Lowongan" value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary ml-2">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th class="text-center" width="60">NO</th>
                    <th>JUDUL</th>
                    <th>LOKASI</th>
                    <th>TIPE</th>
                    <th>GAJI</th>
                    <th>STATUS</th>
                    <th>DEADLINE</th>
                    <th class="text-center" width="150">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td class="text-center text-muted fw-bold">{{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}</td>
                    <td>
                        <div class="fw-bold">{{ $job->title }}</div>
                        <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                    </td>
                    <td>{{ $job->location ?? '-' }}</td>
                    <td>
                        <span class="badge bg-info">{{ $job->type ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $job->salary ?? '-' }}</td>
                    <td>
                        <span class="badge
                            @if($job->status == 'active') badge-success
                            @elseif($job->status == 'inactive') badge-secondary
                            @else badge-warning @endif">
                            {{ ucfirst($job->status ?? 'draft') }}
                        </span>
                    </td>
                    <td>
                        @if($job->deadline)
                            {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                            @if(\Carbon\Carbon::parse($job->deadline)->isPast())
                                <br><small class="text-danger">Deadline berlalu</small>
                            @else
                                <br><small class="text-muted">{{ \Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</small>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('company.jobs.show', $job->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('company.jobs.edit', $job->id) }}?from=inactive" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('company.jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from" value="inactive">
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-briefcase fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada lowongan tidak aktif</p>
                            <p class="mb-0">
                                <a href="{{ route('company.jobs.create') }}?from=inactive" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Buat Lowongan Baru
                                </a>
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($jobs->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection
