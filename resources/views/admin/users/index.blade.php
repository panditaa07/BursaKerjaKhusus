@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kelolapengguna.css') }}">
<link rel="stylesheet" href="{{ asset('css/table-admin.css?v=2') }}">

<div class="container mx-auto px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Kelola Pengguna</h2>
            <div>
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-kembali rounded">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
      

      {{-- Form Filter & Search --}}
<form method="GET" action="{{ route('admin.users.index') }}"
      class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

    {{-- Search box --}}
    <div class="input-group" style="max-width: 400px;">
        <span class="input-group-text bg-white">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" name="search" class="form-control"
               placeholder="Cari nama atau email" value="{{ request('search') }}">
        <button type="submit" class="btn btn-cari">Cari
        </button>

        {{-- Reset hanya untuk pencarian (seperti di Kelola Pelamar) --}}
        @if(request('search'))
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif
    </div>

    {{-- Role filter --}}
    <div class="d-flex align-items-center gap-2">
        <div class="input-group" style="max-width: 300px;">
            <span class="input-group-text bg-white">Role</span>
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                <option value="company" {{ request('role') == 'company' ? 'selected' : '' }}>Company</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
            <button type="submit" class="btn btn-filter">Filter</button>
        </div>

      {{-- Reset semua filter (muncul jika ada search atau role) --}}
@if(request('search') || request('role'))
  <a href="{{ route('admin.users.index') }}" class="btn-reset-all text-decoration-none">
    <i class="fas fa-undo-alt"></i>
    <span>Reset Semua</span>
  </a>
@endif
    </div>
</form>

    {{-- Form Filter & Search --}}
    <form method="GET" action="{{ route('admin.users.index') }}" 
   

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Data Users --}}
    @if($users->isEmpty())
        <div class="alert alert-info">Tidak ada pengguna untuk ditampilkan.</div>
    @else
    
     <!-- Table -->
    <div class="container table-section table-responsive">
        
            <table class="table-dashboard mb-0 text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Kategori</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="status-badge {{ $user->role->name == 'company' ? 'status-warning' : 'status-info' }}">
                                    {{ ucfirst($user->role->name) }}
                                </span>
                            </td>
                            <td>
                                @if($user->role->name == 'company')
                                    {{ $user->job_posts_count > 0 ? 'Sudah Membuat Lowongan' : 'Belum Membuat Lowongan' }}
                                @elseif($user->role->name == 'user')
                                    {{ $user->applications_count > 0 ? 'Sudah Melamar' : 'Belum Melamar' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                <td class="text-center aksi">
                                   <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-detail">
                                    <i class=""></i><span>Lihat</span>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-edit">
                                    <i class=""></i><span>Edit</span>
                                </a>
                                @if ($user->role->name == 'user' && $user->cover_letter_path)
                                        <a href="{{ route('admin.users.download_cover_letter', $user) }}" class="table-btn download">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    @endif
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center gap-1 rounded-pill px-2 py-1 fw-bold btn-delete" onclick="return confirm('Yakin hapus loker ini?')">
                                        <i class=""></i><span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
    </div>
    @endif


<div class="d-flex justify-content-center mt-3">
    <div class="btn-group" role="group" aria-label="Pagination">
        {{-- Tombol Previous --}}
        @if ($users->onFirstPage())
            <button class="btn btn-outline-secondary" disabled>Previous</button>
        @else
            <a href="{{ $users->previousPageUrl() }}" class="btn btn-kembali">Previous</a>
        @endif

        {{-- Tombol Next --}}
        @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="btn btn-kembali">Next</a>
        @else
            <button class="btn btn-outline-secondary" disabled>Next</button>
        @endif
    </div>  
@endsection
