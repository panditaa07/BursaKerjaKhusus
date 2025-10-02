@extends('layouts.dashboard') 

@section('title', 'Daftar Pelamar Bulan Ini')

@section('content')
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
        <form method="GET" action="{{ route('admin.dashboard.pelamar') }}">
    <div class="input-group search-box" style="width: 380px;" align-items="right">
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
        <button class="btn btn-success" type="submit">Cari</button>
        <span class="input-group-text bg-success text-white fw-bold">
            Total : {{ $pelamar->total() }}
        </span>
    </div>
</form>
    </div>

            <table class="table modern-table mb-0 text-center">
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
                            <td>{{ $loop->iteration }}</td>
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
                                <a href="{{ route('admin.applications.show', $p->id) }}" class="table-btn view"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.applications.edit', $p->id) }}" class="table-btn edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.applications.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                    <button type="submit" class="table-btn delete" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
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
