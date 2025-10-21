@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Kelolapengguna.css') }}">
<link rel="stylesheet" href="{{ asset('css/table-admin.css') }}">

     <div class="container mx-auto px-4 py-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Kelola Lowongan Kerja</h2>
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary rounded">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Search and Filter -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="search-box w-55">
                    <form method="GET" action="{{ route('admin.job-posts.index') }}" class="d-inline">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Cari Lowongan" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                    <a href="{{ route('admin.job-posts.create') }}" class="btn btn-primary mt-2 me-2">+ Tambah Lowongan</a>
                </div>
                <div class="filter-box">
                    <form method="GET" action="{{ route('admin.job-posts.index') }}" class="d-inline">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light text-muted">Status</span>
                            <select name="status" class="form-select">
                                <option value="">Semua Lowongan</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Lowongan Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Lowongan Tidak Aktif</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

             <!-- Table -->
    <div class="container table-section table-responsive table-container">
        
            <table class="table-dashboard mb-0 text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Pekerjaan</th>
                        <th>Perusahaan</th>
                        <th>Lokasi</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     @forelse($jobPosts as $index => $job)
                            <tr>
                                <td>{{ $jobPosts->firstItem() + $index }}</td>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->company->name ?? '-' }}</td>
                                <td>{{ $job->location }}</td>
                                <td>{{ $job->employment_type }}</td>
                                <td>
                                    @if($job->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="aksi">
                                    <a href="{{ route('admin.job-posts.show', $job->id) }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 rounded-pill px-3 py-2 fw-bold btn-detail">
                                    <i class="fas fa-eye"></i><span>Lihat</span>
                                </a>
                                <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="btn btn-warning d-flex align-items-center justify-content-center gap-2 rounded-pill px-3 py-2 fw-bold btn-edit">
                                    <i class="fas fa-edit"></i><span>Edit</span>
                                </a>
                                <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center gap-2 rounded-pill px-3 py-2 fw-bold btn-delete" onclick="return confirm('Yakin hapus loker ini?')">
                                        <i class="fas fa-trash"></i><span>Hapus</span>
                                    </button>
                                </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada lowongan kerja</td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        
    </div>
        </div>
    

<div class="d-flex justify-content-center mt-3">
    <div class="btn-group" role="group" aria-label="Pagination">
        {{-- Tombol Previous --}}
        @if ($jobPosts->onFirstPage())
            <button class="btn btn-outline-secondary" disabled>Previous</button>
        @else
            <a href="{{ $jobPosts->previousPageUrl() }}" class="btn btn-primary">Previous</a>
        @endif

        {{-- Tombol Next --}}
        @if ($jobPosts->hasMorePages())
            <a href="{{ $jobPosts->nextPageUrl() }}" class="btn btn-primary">Next</a>
        @else
            <button class="btn btn-outline-secondary" disabled>Next</button>
        @endif
    </div>
@endsection
