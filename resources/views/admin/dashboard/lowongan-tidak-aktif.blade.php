@extends('layouts.dashboard')

@section('title', 'Lowongan Tidak Aktif')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Kelolapengguna.css') }}">
<link rel="stylesheet" href="{{ asset('css/table-admin.css') }}">
<div class="container mx-auto px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-2 page-title">LOWONGAN TIDAK AKTIF</h4>
            <br>
            {{-- Tombol kembali --}}
            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-kembali btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        
        {{-- Search box --}}
        {{-- Search + tombol cari + total lowongan --}}
<form method="GET" action="{{ route('admin.dashboard.lowongan-tidak-aktif') }}">
    <div class="search-box d-flex justify-content-end gap-2 align-items-center">

        {{-- Input Search --}}
        <div class="input-group" style="width: 300px;">
            <span class="input-group-text">
                <i class="bi bi-search"></i>
            </span>
            <input 
                type="text" 
                name="search"
                class="form-control" 
                placeholder="Cari Lowongan..." 
                value="{{ request('search') }}"
            >
        </div>

        {{-- Tombol Cari --}}
        <button class="btn-cari" type="submit">
            <i class="bi bi-search"></i> Cari
        </button>

        {{-- Total --}}
        <span class="btn-total">
            <i class="bi bi-list-ul"></i> Total: {{ $lowongan->total() }}
        </span>
    </div>
</form>
    </div>

    <!-- Table -->
    <div class="container table-section table-responsive table-responsive1">

            <table class="table-dashboard mb-0 text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Perusahaan</th>
                        <th>No HRD</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowongan as $index => $l)
                        <tr>
                            <td>{{ $lowongan->firstItem() + $index }}</td>
                            <td>{{ $l->company->name ?? 'N/A' }}</td>
                            <td>N/A</td>
                            <td>{{ $l->location ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-danger">Tidak Aktif</span>
                            </td>
                           <td class="aksi text-center align-middle">
    <div class="aksi-wrapper d-flex flex-wrap justify-content-center gap-2">
        <!-- Tombol Lihat -->
        <a href="{{ route('admin.job-posts.show', $l->id) }}?from=tidakaktif"
           class="btn btn-primary rounded-pill px-3 py-1 fw-bold">
            Lihat
        </a>

        <!-- Tombol Edit -->
        <a href="{{ route('admin.job-posts.edit', $l->id) }}"
           class="btn btn-warning rounded-pill px-3 py-1 fw-bold">
            Edit
        </a>

        <!-- Tombol Hapus -->
        <form action="{{ route('admin.job-posts.destroy', $l->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn btn-danger rounded-pill px-3 py-1 fw-bold"
                    onclick="return confirm('Yakin ingin menghapus?')">
                Hapus
            </button>
        </form>
    </div>
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada lowongan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        
    </div>

    <!-- Pagination -->
<div class="d-flex justify-content-center mt-3">
    <div class="btn-group" role="group" aria-label="Pagination">
        {{-- Tombol Previous --}}
        @if ($lowongan->onFirstPage())
            <button class="btn btn-outline-secondary" disabled>Previous</button>
        @else
            <a href="{{ $lowongan->previousPageUrl() }}" class="btn btn-kembali">Previous</a>
        @endif

        {{-- Tombol Next --}}
        @if ($lowongan->hasMorePages())
            <a href="{{ $lowongan->nextPageUrl() }}" class="btn btn-kembali">Next</a>
        @else
            <button class="btn btn-outline-secondary" disabled>Next</button>
        @endif
    </div>
</div>

</div>
@endsection
