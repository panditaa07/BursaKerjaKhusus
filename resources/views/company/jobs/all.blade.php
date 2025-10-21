@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelolalowongankerjacom.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container-fluid kelola-lowongan">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Semua Lowongan</h2>
        <div class="d-flex align-items-center">
            <span class="me-3 total-lowongan">Total Lowongan: {{ $jobs->total() }}</span>
            <a href="{{ route('company.jobs.create') }}?from=all" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Lowongan
            </a>
        </div>
    </div>

    {{-- Search Bar dengan Reset --}}
    <div class="mb-4 search-bar">
        <form method="GET" action="{{ route('company.jobs.all') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari lowongan berdasarkan judul, lokasi, atau tipe..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search me-2"></i>Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('company.jobs.all') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="company-applications-table">
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
                    <td class="text-center text-muted fw-bold" data-label="NO">
                        {{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}
                    </td>

                    <td data-label="JUDUL">
                        <div class="fw-bold">{{ $job->title }}</div>
                        <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                    </td>

                    <td data-label="LOKASI">{{ $job->location ?? '-' }}</td>

                    <td data-label="TIPE">
                        <span class="badge bg-info">{{ $job->type ?? 'N/A' }}</span>
                    </td>

                    <td data-label="GAJI">{{ $job->salary ?? '-' }}</td>

                    <td data-label="STATUS">
                        <span class="badge-status
                            @if($job->status == 'active') badge-success
                            @elseif($job->status == 'inactive') badge-secondary
                            @else badge-warning @endif">
                            {{ ucfirst($job->status ?? 'draft') }}
                        </span>
                    </td>

                    <td data-label="DEADLINE">
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

                    {{-- AKSI - disamakan dengan dashboard (kotak putih + border berwarna) --}}
                    <td class="text-center" data-label="AKSI">
                        <div class="btn-group" role="group">
                            {{-- Lihat --}}
                            <a href="{{ route('company.jobs.show', $job->id) }}" 
                            class="action-mini view" title="Lihat">
                            <i class="fas fa-eye"></i>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('company.jobs.edit', $job->id) }}?from=all" 
                            class="action-mini edit" title="Edit">
                            <i class="fas fa-pen"></i>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('company.jobs.destroy', $job->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from" value="all">
                                <button type="submit" class="action-mini delete" title="Hapus">
                                <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 empty-state">
                        <div class="text-muted">
                            <i class="fas fa-briefcase fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada lowongan kerja</p>
                            <p class="mb-0 mt-2">
                                <a href="{{ route('company.jobs.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Buat Lowongan Pertama
                                </a>
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($jobs->hasPages())
        <div class="d-flex justify-content-center mt-4 pagination-wrapper">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection