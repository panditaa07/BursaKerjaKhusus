@extends('layouts.dashboard') 

@section('title', 'Daftar Pelamar Bulan Ini')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Kelolapengguna.css') }}">
<link rel="stylesheet" href="{{ asset('css/table-admin.css?v=2') }}">


<div class="container mx-auto px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-2 page-title">DAFTAR PELAMAR BULAN INI</h4>
            {{-- Tombol kembali --}}
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-kembali btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        
{{-- Search + tombol cari + total --}}
<form method="GET" action="{{ route('admin.dashboard.pelamar.bulanini') }}">
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
    <div class="container table-section table-responsive table-responsive1">
        
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
                                    <span class="badge" style="background-color:#0c632f;">Terima</span> {{-- Hijau terang --}}
                                @elseif($p->status == 'rejected')
                                    <span class="badge" style="background-color:#bb1425;">Tolak</span> {{-- Merah tua --}}
                                @elseif($p->status == 'interview')
                                    <span class="badge" style="background-color:#4B2E05;">Wawancara</span> {{-- Ungu gelap --}}
                                @elseif(in_array($p->status, ['test1','test2']))
                                    <span class="badge" style="background-color:#0d469d; color:#fff;">Proses</span> {{-- Biru cyan --}}
                                @elseif($p->status == 'submitted')
                                    <span class="badge" style="background-color:#EAB308; color:#000;">Menunggu</span> {{-- Kuning keemasan --}}
                                @else
                                    <span class="badge bg-light text-dark">{{ $p->status }}</span>
                                @endif
                            </td>
                           <td class="aksi text-center align-middle">
    <div class="aksi-wrapper d-flex flex-wrap justify-content-center gap-2">
        <!-- Tombol Lihat -->
        <a href="{{ route('admin.applications.show', $p->id) }}"
           class="btn btn-primary rounded-pill px-3 py-1 fw-bold">
            Lihat
        </a>

        <!-- Tombol Edit -->
        <a href="{{ route('admin.applications.edit', $p->id) }}"
           class="btn btn-warning rounded-pill px-3 py-1 fw-bold">
            Edit
        </a>

        <!-- Tombol Hapus -->
        <form action="{{ route('admin.applications.destroy', $p->id) }}" method="POST" class="d-inline">
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
                                <td colspan="10" class="text-center">Belum ada pelamar</td>
                            </tr>
                    @endforelse
                </tbody>
            </table>
        
    </div>

    <div class="d-flex justify-content-center mt-3">
    <div class="btn-group" role="group" aria-label="Pagination">
        {{-- Tombol Previous --}}
        @if ($pelamar->onFirstPage())
            <button class="btn btn-outline-secondary" disabled>Previous</button>
        @else
            <a href="{{ $pelamar->previousPageUrl() }}" class="btn btn-kembali">Previous</a>
        @endif

        {{-- Tombol Next --}}
        @if ($pelamar->hasMorePages())
            <a href="{{ $pelamar->nextPageUrl() }}" class="btn btn-kembali">Next</a>
        @else
            <button class="btn btn-outline-secondary" disabled>Next</button>
        @endif
    </div>
</div>

        </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            const query = e.target.value;
            const url = new URL(window.location.href);
            url.searchParams.set('search', query);
            window.location.href = url.toString();
        }
    });
</script>
@endsection
