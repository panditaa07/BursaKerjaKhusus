@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/kelolalowongankerjacom.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container-fluid kelola-lowongan">

    {{-- Header + tombol tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="page-title mb-0">Semua Lowongan</h2>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <span class="me-3 total-lowongan">Total Lowongan: {{ $jobs->total() }}</span>
            <a href="{{ route('company.jobs.create') }}?from=all" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Lowongan
            </a>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="mb-4 search-bar">
        <form method="GET" action="{{ route('company.jobs.all') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari lowongan berdasarkan judul, lokasi, atau tipe..."
                       value="{{ request('search') }}">
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

    {{-- Tabel --}}
    <div class="table-responsive lowongan-wrapper">
        <table class="company-applications-table compact">
            <colgroup>
                <col style="width:5%">    {{-- NO --}}
                <col style="width:22%">   {{-- JUDUL --}}
                <col style="width:14%">   {{-- LOKASI --}}
                <col style="width:10%">   {{-- TIPE --}}
                <col style="width:12%">   {{-- GAJI --}}
                <col style="width:12%">   {{-- STATUS --}}
                <col style="width:12%">   {{-- DEADLINE --}}
                <col style="width:13%">   {{-- AKSI --}}
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th>JUDUL</th>
                    <th>LOKASI</th>
                    <th>TIPE</th>
                    <th>GAJI</th>
                    <th>STATUS</th>
                    <th>DEADLINE</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    {{-- NO --}}
                    <td class="text-center fw-bold text-muted">
                        {{ $loop->iteration + ($jobs->currentPage() - 1) * $jobs->perPage() }}
                    </td>

                    {{-- JUDUL tanpa deskripsi --}}
                    <td class="text-start fw-bold">
                        {{ $job->title }}
                    </td>

                    {{-- LOKASI --}}
                    <td>{{ $job->location ?? '-' }}</td>

                    {{-- TIPE --}}
                   <td>
  @php $type = trim($job->employment_type ?? ''); @endphp
  @if($type !== '')
    <span class="badge badge-type">{{ $type }}</span>
  @else
    <span class="text-muted">-</span>
  @endif
</td>


                    {{-- GAJI --}}
                    <td>{{ $job->salary ?? '-' }}</td>

                    {{-- STATUS --}}
                    <td>
                        <span class="badge-status
                            @if($job->status == 'active') badge-success
                            @elseif($job->status == 'inactive') badge-secondary
                            @else badge-warning @endif">
                            {{ ucfirst($job->status ?? 'draft') }}
                        </span>
                    </td>

                    {{-- DEADLINE --}}
                    <td>
                        @if($job->deadline)
                            {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($job->deadline)->diffForHumans() }}</small>
                        @else
                            -
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">
                        <div class="aksi-wrapper">
                            <a href="{{ route('company.jobs.show', $job->id) }}" class="action-text view">Lihat</a>
                            <a href="{{ route('company.jobs.edit', $job->id) }}?from=all" class="action-text edit">Edit</a>
                            <form action="{{ route('company.jobs.destroy', $job->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-text delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fas fa-briefcase fa-3x mb-3"></i><br>
                        Belum ada lowongan kerja.
                        <br><a href="{{ route('company.jobs.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus"></i> Buat Lowongan Pertama
                        </a>
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