@extends('layouts.dashboard')

@section('title', 'Lowongan Tidak Aktif')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">LOWONGAN TIDAK AKTIF</h4>
        <div class="input-group" style="width: 300px;">
            <span class="input-group-text">
                <i class="bi bi-search"></i>
            </span>
            <input 
                type="text" 
                id="search" 
                class="form-control" 
                placeholder="Cari Lowongan..."
                value="{{ request('search') }}"
            >
            <span class="input-group-text bg-success text-white fw-bold">
                Total : {{ $lowongan->count() }}
            </span>
        </div>
    </div>
            <table class="table modern-table mb-0 text-center">
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
                    @forelse ($lowongan as $index => $l)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $l->company->name ?? 'N/A' }}</td>
                            <td>N/A</td>
                            <td>{{ $l->location ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-danger">Tidak Aktif</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.job-posts.show', $l->id) }}" class="table-btn view"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.job-posts.edit', $l->id) }}" class="table-btn edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.job-posts.destroy', $l->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                    <button type="submit" class="table-btn delete" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada lowongan tidak aktif</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
