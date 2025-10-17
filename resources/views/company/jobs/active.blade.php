@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelolalowongankerjacom.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container-fluid">

    {{-- === HEADER HALAMAN === --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Lowongan Aktif</h2>
        <div class="d-flex align-items-center">
            <span class="mr-3">Total Lowongan: {{ $jobs->total() }}</span>
            <a href="{{ route('company.jobs.create') }}?from=active" class="btn btn-primary">
                Tambah Lowongan
            </a>
        </div>
    </div>

    {{-- === PENCARIAN === --}}
    <div class="mb-4">
        <form method="GET" action="{{ route('company.jobs.active') }}" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Cari Lowongan" value="{{ request('search') }}">
            <button type="submit" class="btn-secondary ml-2">Cari</button>
        </form>
    </div>

    {{-- === TABEL LOWONGAN === --}}
    <div class="table-responsive">
        <table class="company-applications-table">
            <thead>
                <tr>
                    <th width="60">NO</th>
                    <th>JUDUL</th>
                    <th>LOKASI</th>
                    <th>TIPE</th>
                    <th>GAJI</th>
                    <th>STATUS</th>
                    <th>DEADLINE</th>
                    <th width="150">AKSI</th>
                </tr>
            </thead>

            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td>{{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}</td>
                    <td class="text-start">
                        <div class="fw-bold">{{ $job->title }}</div>
                        <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                    </td>
                    <td>{{ $job->location ?? '-' }}</td>
                    <td>
                        <span class="badge-status badge-info">{{ $job->type ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $job->salary ?? '-' }}</td>
                    <td>
                        <span class="badge-status 
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

                    {{-- === TOMBOL AKSI === --}}
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('company.jobs.show', $job->id) }}" class="action-mini view" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('company.jobs.edit', $job->id) }}?from=active" class="action-mini edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('company.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from" value="active">
                                <button type="submit" class="action-mini delete" title="Hapus">
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
                            <p class="mb-1">Belum ada lowongan aktif</p>
                            <a href="{{ route('company.jobs.create') }}?from=active" class="btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Buat Lowongan
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- === PAGINATION === --}}
    @if($jobs->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection
