@extends('layouts.dashboard')

@section('title', 'Lowongan Aktif')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-2">LOWONGAN AKTIF</h4>
            {{-- Tombol kembali --}}
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
       <form method="GET" action="{{ route('admin.dashboard.lowongan-aktif') }}">
            <div class="input-group search-box">
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
                <button class="btn btn-success" type="submit">Cari</button>
                <span class="input-group-text bg-success text-white fw-bold">
                    Total : {{ $lowongan->count() }}
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
                    @forelse($lowongan as $index => $l)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $l->company->name ?? 'N/A' }}</td>
                            <td>{{ 'N/A' }}</td>
                            <td>{{ $l->location ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.job-posts.show', $l->id) }}" class="table-btn view"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.job-posts.edit', $l->id) }}" class="table-btn edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.job-posts.destroy', $l->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                    <button type="submit" class="table-btn delete" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada lowongan aktif</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
