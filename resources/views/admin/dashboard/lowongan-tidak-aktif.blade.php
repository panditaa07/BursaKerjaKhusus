@extends('layouts.dashboard')

@section('title', 'Lowongan Tidak Aktif')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">LOWONGAN TIDAK AKTIF</h4>
        <div class="search-box">
            <form method="GET" action="{{ route('admin.dashboard.lowongan-tidak-aktif') }}" class="d-inline">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-light text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control" placeholder="Cari Lowongan" value="{{ request('keyword') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <span class="input-group-text total-box fw-bold bg-success text-white">
                        Total : {{ $lowongan->total() }}
                    </span>
                </div>
            </form>
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $lowongan->links() }}
            </div>
        </div>
    </div>
</div>


@endsection
