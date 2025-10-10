@extends('layouts.dashboard')

<link href="{{ asset('css/kelolalowongankerjacom.css') }}" rel="stylesheet">

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold">Kelola Lowongan Kerja</h2>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted">Total Lowongan: <strong>{{ $jobs->total() }}</strong></span>
            <a href="{{ route('company.jobs.create') }}?from=all" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Lowongan
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <form method="GET" action="{{ route('company.jobs.all') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari Lowongan..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
    </div>

    <!-- Tabel Lowongan -->
    <div class="table-responsive">
        <table class="table table-card">
            <thead>
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
                    <td class="text-center text-muted fw-bold">
                        {{ $loop->iteration + ($jobs instanceof \Illuminate\Pagination\LengthAwarePaginator ? ($jobs->currentPage() - 1) * $jobs->perPage() : 0) }}
                    </td>
                    <td>
                        <div class="fw-bold">{{ $job->title }}</div>
                        <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                    </td>
                    <td>{{ $job->location ?? '-' }}</td>
                    <td><span class="badge-status badge-info">{{ $job->type ?? 'N/A' }}</span></td>
                    <td>{{ $job->salary ?? '-' }}</td>
                    <td>
                        @if($job->status == 'active')
                            <span class="badge-status badge-success">Active</span>
                        @elseif($job->status == 'inactive')
                            <span class="badge-status badge-danger">Inactive</span>
                        @else
                            <span class="badge-status badge-warning">{{ ucfirst($job->status ?? 'Draft') }}</span>
                        @endif
                    </td>
                    <td>
                        @if($job->deadline)
                            <i class="fas fa-calendar-alt text-muted me-1"></i>
                            {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                            <br>
                            @if(\Carbon\Carbon::parse($job->deadline)->isPast())
                                <small class="text-danger">Deadline berlalu</small>
                            @else
                                <small class="text-muted">{{ \Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</small>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <!-- Lihat -->
                            <a href="{{ route('company.jobs.show', $job->id) }}"
                               class="action-btn view" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Edit -->
                            <a href="{{ route('company.jobs.edit', $job->id) }}?from=all"
                               class="action-btn edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Delete -->
                            <form action="{{ route('company.jobs.destroy', $job->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Hapus">
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
                            <p class="mb-0">Belum ada lowongan kerja</p>
                            <a href="{{ route('company.jobs.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus"></i> Buat Lowongan Pertama
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($jobs instanceof \Illuminate\Pagination\LengthAwarePaginator && $jobs->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection
