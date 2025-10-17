@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelolalowongankerjacom.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container-fluid">

    {{-- Header atas --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Lowongan Tidak Aktif</h2>
        <div class="d-flex align-items-center gap-2">
            <span>Total Lowongan: {{ $jobs->total() }}</span>
            <a href="{{ route('company.jobs.create') }}?from=inactive" class="btn btn-primary">
                Tambah Lowongan
            </a>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="mb-4">
        <form method="GET" action="{{ route('company.jobs.inactive') }}" class="d-flex align-items-center">
            <input type="text" name="search" class="form-control me-2" 
                   placeholder="Cari Lowongan..." value="{{ request('search') }}">
            <button type="submit" class="btn-secondary">Cari</button>
        </form>
    </div>

    {{-- === Tabel Lowongan Tidak Aktif === --}}
    <div class="table-responsive">
        <table class="company-applications-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Judul</th>
                    <th>Lokasi</th>
                    <th>Tipe</th>
                    <th>Gaji</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td>{{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}</td>
                    <td>
                        <div class="fw-bold">{{ $job->title }}</div>
                        <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                    </td>
                    <td>{{ $job->location ?? '-' }}</td>
                    <td>
                        <span class="badge-status badge-warning">{{ $job->type ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $job->salary ?? '-' }}</td>
                    <td>
                        @if($job->status == 'active')
                            <span class="badge-status badge-success">Aktif</span>
                        @elseif($job->status == 'inactive')
                            <span class="badge-status badge-secondary">Nonaktif</span>
                        @else
                            <span class="badge-status badge-warning">{{ ucfirst($job->status ?? 'draft') }}</span>
                        @endif
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
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('company.jobs.show', $job->id) }}" 
                               class="action-mini view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('company.jobs.edit', $job->id) }}?from=inactive" 
                               class="action-mini edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('company.jobs.destroy', $job->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from" value="inactive">
                                <button type="submit" class="action-mini delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <div>
                            <i class="fas fa-briefcase fa-3x mb-3"></i>
                            <p class="mb-1">Belum ada lowongan tidak aktif</p>
                            <a href="{{ route('company.jobs.create') }}?from=inactive" class="btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Buat Lowongan Baru
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($jobs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $jobs->links() }}
    </div>
    @endif
</div>
@endsection
