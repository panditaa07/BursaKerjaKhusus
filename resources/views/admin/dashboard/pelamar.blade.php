@extends('layouts.dashboard') 
@section('title', 'Daftar Pelamar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Kelolapengguna.css') }}">
<link rel="stylesheet" href="{{ asset('css/table-admin.css') }}">


<div class="container mx-auto px-4 py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-2">DAFTAR PELAMAR</h4>
            {{-- Tombol kembali --}}
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

{{-- Search + tombol cari + total --}}
<form method="GET" action="{{ route('admin.dashboard.pelamar') }}">
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
                placeholder="Cari Pelamar..." 
                value="{{ request('search') }}"
            >
        </div>

        {{-- Tombol Cari --}}
        <button class="btn-cari" type="submit">
            <i class="bi bi-search"></i> Cari
        </button>

        {{-- Total --}}
        <span class="btn-total">
            <i class="bi bi-list-ul"></i> Total: {{ $pelamar->total() }}
        </span>
    </div>
</form>


    </div>

    <!-- Table -->
    <div class="container table-section table-responsive table-container">
        
            <table class="table-dashboard mb-0 text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Perusahaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelamar as $p)
                        <tr>
                            <td>{{ ($pelamar->currentPage() - 1) * $pelamar->perPage() + $loop->iteration }}</td>
                            <td>{{ $p->user->name ?? 'N/A' }}</td>
                            <td>{{ $p->user->email ?? 'N/A' }}</td>
                            <td>{{ $p->user->phone ?? '-' }}</td>
                            <td>{{ $p->jobPost->company->name ?? 'N/A' }}</td>
                            <td>
                                @if($p->status == 'accepted')
                                    <span class="badge bg-success">Terima</span>
                                @elseif($p->status == 'rejected')
                                    <span class="badge bg-danger">Tolak</span>
                                @elseif($p->status == 'interview')
                                    <span class="badge bg-dark">Wawancara</span>
                                @elseif(in_array($p->status, ['test1','test2']))
                                    <span class="badge bg-primary">Proses</span>
                                @elseif($p->status == 'submitted')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td class="aksi">
                                <a href="{{ route('admin.applications.show', $p->id) }}"
                            class="btn btn-primary d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-detail">
                                <i class="fas fa-eye"></i><span>Lihat</span>
                            </a>

                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.applications.edit', $p->id) }}"
                            class="btn btn-warning d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-edit">
                                <i class="fas fa-edit"></i><span>Edit</span>
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.applications.destroy', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-danger d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i><span>Hapus</span>
                                </button>
                            </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada pelamar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        
    </div>
               {{-- Pagination Next & Previous --}}
<div class="d-flex justify-content-center mt-3">
    <div class="btn-group" role="group" aria-label="Pagination">
        {{-- Tombol Previous --}}
        @if ($pelamar->onFirstPage())
            <button class="btn btn-outline-secondary" disabled>Previous</button>
        @else
            <a href="{{ $pelamar->previousPageUrl() }}" class="btn btn-primary">Previous</a>
        @endif

        {{-- Tombol Next --}}
        @if ($pelamar->hasMorePages())
            <a href="{{ $pelamar->nextPageUrl() }}" class="btn btn-primary">Next</a>
        @else
            <button class="btn btn-outline-secondary" disabled>Next</button>
        @endif
    </div>
</div>
</div>
@endsection
