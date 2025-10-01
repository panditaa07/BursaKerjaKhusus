@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
     <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Kelola Data Lowongan Kerja</h2>
                <a href="{{ route('admin.job-posts.create') }}" class="btn btn-add-job">+ Tambah Lowongan</a>
            </div>

            <!-- Search and Filter -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="search-box">
                    <form method="GET" action="{{ route('admin.job-posts.index') }}" class="d-inline">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Cari Lowongan" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="filter-box">
                    <form method="GET" action="{{ route('admin.job-posts.index') }}" class="d-inline">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light text-muted">Status</span>
                            <select name="status" class="form-select">
                                <option value="">Semua</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table modern-table">
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
                                <td>
                                    <a href="{{ route('admin.job-posts.show', $job->id) }}" class="table-btn view">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="table-btn edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" class="d-inline">
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
                                <td colspan="7" class="text-center">Belum ada lowongan kerja</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Custom -->
            <div class="d-flex justify-content-center mt-3">
                <nav>
                    <ul class="pagination">

                        {{-- Tombol Previous --}}
                        @if ($jobPosts->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link bg-primary text-white" href="{{ $jobPosts->previousPageUrl() }}" rel="prev">Previous</a>
                            </li>
                        @endif

                        {{-- Tombol Next --}}
                        @if ($jobPosts->hasMorePages())
                            <li class="page-item">
                                <a class="page-link bg-primary text-white" href="{{ $jobPosts->nextPageUrl() }}" rel="next">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>
@endsection
