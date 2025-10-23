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
<div class="d-flex justify-content-between align-items-start align-items-md-center mb-3 gap-3 flex-wrap">

  {{-- 🔍 PENCARIAN --}}

    <form method="GET" action="{{ route('admin.job-posts.index') }}" class="d-inline">
   <div class="d-flex align-items-center gap-2">
  <div class="input-group shadow-sm" style="max-width: 400px;">
    <span class="input-group-text bg-white">
      <i class="fas fa-search"></i>
    </span>
    <input type="text" name="search" class="form-control"
           placeholder="Cari lowongan..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Cari</button>
  </div>

  @if(request('search'))
    <a href="{{ route('admin.job-posts.index', array_filter(request()->except('search'))) }}"
       class="btn btn-reset d-flex align-items-center justify-content-center gap-2">
      <i class="fas fa-times"></i> Reset
    </a>
  @endif
</div>

    </form>

    {{-- Tombol tambah lowongan --}}
    <a href="{{ route('admin.job-posts.create') }}" class="btn btn-primary mt-2 me-2 fw-bold">
      + Tambah Lowongan
    </a>
  </div>

  {{-- ⚙️ FILTER STATUS + RESET SEMUA --}}
  <div class="d-flex align-items-center gap-3">
    <form method="GET" action="{{ route('admin.job-posts.index') }}" class="d-inline">
      <div class="input-group shadow-sm">
        <span class="input-group-text bg-white">Status</span>
        <select name="status" class="form-select">
          <option value="">Semua Lowongan</option>
          <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Lowongan Aktif</option>
          <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Lowongan Tidak Aktif</option>
        </select>
        <button type="submit" class="btn btn-primary px-4 fw-bold">Filter</button>

        {{-- Tombol Reset khusus filter --}}
        @if(request('status') !== null && request('status') !== '')
          <a href="{{ route('admin.job-posts.index', array_filter(request()->except('status'))) }}"
             class="btn btn-reset px-4">
            <i class="fas fa-times me-2"></i> Reset
          </a>
        @endif
      </div>
    </form>

 {{-- Tombol Reset Semua (disamakan dengan Kelola Pengguna) --}}
@if(request('search') || request('status'))
  <a href="{{ route('admin.job-posts.index') }}" class="btn-reset-all text-decoration-none d-inline-flex align-items-center justify-content-center gap-2">
    <i class="fas fa-undo-alt"></i>
    <span>Reset Semua</span>
  </a>
@endif

  </div>
</div>

<br>
             <!-- Table -->
    <div class="container table-section table-responsive">
        
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
                                    <a href="{{ route('admin.job-posts.show', $job->id) }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-detail">
                                    <i class=""></i><span>Lihat</span>
                                </a>
                                <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="btn btn-warning d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-edit">
                                    <i class=""></i><span>Edit</span>
                                </a>
                                <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-delete" onclick="return confirm('Yakin hapus loker ini?')">
                                        <i class=""></i><span>Hapus</span>
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
