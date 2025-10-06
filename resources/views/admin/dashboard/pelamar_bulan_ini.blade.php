@extends('layouts.dashboard') 

@section('title', 'Daftar Pelamar Bulan Ini')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Kelolapengguna.css') }}">
<div class="container daftar-pelamar">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-2">DAFTAR PELAMAR BULAN INI</h4>
            {{-- Tombol kembali --}}
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-sm">
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

            <table class="table-responsive table-dashboard mb-0 text-center">
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
                    @foreach($pelamar as $p)
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
                                @elseif(in_array($p->status, ['interview','test1','test2']))
                                    <span class="badge bg-primary">Proses</span>
                                @elseif($p->status == 'submitted')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @else
                                    <span class="badge bg-light text-dark">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.applications.show', $p->id) }}" class="table-btn view"><i class="bi bi-eye" style="background-color: #3b82f6; border-radius: 12px; padding: 6px 12px; color: white; margin-right: 5px;"></i></a>
                                <a href="{{ route('admin.applications.edit', $p->id) }}" class="table-btn edit"><i class="bi bi-pencil" style="background-color: #facc15; border-radius: 12px; padding: 6px 12px; color: black; margin-right: 5px;"></i></a>
                                <form action="{{ route('admin.applications.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                    <button type="submit" class="table-btn delete" onclick="return confirm('Yakin ingin menghapus pelamar ini?')"><i class="bi bi-trash" style="background-color: #ef4444; border-radius: 12px; padding: 6px 12px; color: white; border: none;"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
