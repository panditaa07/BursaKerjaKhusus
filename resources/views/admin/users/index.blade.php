@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kelolapengguna.css') }}">
<link rel="stylesheet" href="{{ asset('css/table-admin.css?v=2') }}">

<div class="container mx-auto px-2 px-md-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-3">
        <h2 class="page-title">Kelola Pengguna</h2>
        <div>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-kembali rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Form Filter & Search --}}
    <form method="GET" action="{{ route('admin.users.index') }}" 
          class="d-flex flex-column flex-lg-row justify-content-between align-items-stretch align-items-lg-center gap-3 mb-4">

        {{-- Search box --}}
        <div class="input-group search-group flex-grow-1">
            <span class="input-group-text bg-white">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" name="search" class="form-control"
                   placeholder="Cari nama atau email" value="{{ request('search') }}">
            <button type="submit" class="btn btn-cari">Cari</button>

            {{-- Reset hanya untuk pencarian --}}
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-reset">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </div>

        {{-- Role filter --}}
        <div class="d-flex align-items-center gap-2 filter-group flex-grow-1">
            <div class="input-group flex-grow-1">
                <span class="input-group-text bg-white">Role</span>
                <select name="role" class="form-select">
                    <option value="">Semua Role</option>
                    <option value="company" {{ request('role') == 'company' ? 'selected' : '' }}>Company</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                <button type="submit" class="btn btn-filter">Filter</button>
            </div>

            {{-- Reset semua filter --}}
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="btn-reset-all text-decoration-none">
                    <i class="fas fa-undo-alt"></i>
                    <span class="d-none d-md-inline">Reset Semua</span>
                </a>
            @endif
        </div>
    </form>

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
        <!-- Table Section -->
        <div class="table-responsive table-section">
            <!-- Desktop Table -->
            <div class="d-none d-lg-block">
                <table class="table-dashboard mb-0 text-center">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th class="th-name">Nama</th>
                            <th class="th-email">Email</th>
                            <th class="th-role">Role</th>
                            <th class="th-category">Kategori</th>
                            <th class="th-date">Tanggal Daftar</th>
                            <th class="th-action text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td class="td-name">{{ $user->name }}</td>
                                <td class="td-email">{{ $user->email }}</td>
                                <td>
                                    <span class="status-badge {{ $user->role->name == 'company' ? 'status-warning' : 'status-info' }}">
                                        {{ ucfirst($user->role->name) }}
                                    </span>
                                </td>
                                <td class="td-category">
                                    @if($user->role->name == 'company')
                                        {{ $user->job_posts_count > 0 ? 'Sudah Membuat Lowongan' : 'Belum Membuat Lowongan' }}
                                    @elseif($user->role->name == 'user')
                                        {{ $user->applications_count > 0 ? 'Sudah Melamar' : 'Belum Melamar' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="td-date">{{ $user->created_at->format('d-m-Y') }}</td>
                                <td class="aksi text-center align-middle">
                                    <div class="aksi-wrapper d-flex flex-wrap justify-content-center gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                           class="btn btn-primary rounded-pill px-3 py-1 fw-bold btn-action">
                                            Lihat
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="btn btn-warning rounded-pill px-3 py-1 fw-bold btn-action">
                                            Edit
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger rounded-pill px-3 py-1 fw-bold btn-action"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="d-block d-lg-none">
                @foreach($users as $index => $user)
                    <div class="card user-card mb-3">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="user-name mb-0">{{ $user->name }}</h6>
                                        <span class="status-badge {{ $user->role->name == 'company' ? 'status-warning' : 'status-info' }} mobile-badge">
                                            {{ ucfirst($user->role->name) }}
                                        </span>
                                    </div>
                                    <p class="user-email mb-2">
                                        <i class="fas fa-envelope me-2 text-muted"></i>
                                        {{ $user->email }}
                                    </p>
                                </div>

                                <div class="col-6">
                                    <small class="text-muted d-block">Kategori</small>
                                    <span class="user-category small fw-semibold">
                                        @if($user->role->name == 'company')
                                            {{ $user->job_posts_count > 0 ? 'Sudah Buat Lowongan' : 'Belum Buat Lowongan' }}
                                        @elseif($user->role->name == 'user')
                                            {{ $user->applications_count > 0 ? 'Sudah Melamar' : 'Belum Melamar' }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>

                                <div class="col-6">
                                    <small class="text-muted d-block">Tanggal Daftar</small>
                                    <span class="user-date small fw-semibold">{{ $user->created_at->format('d-m-Y') }}</span>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="aksi-wrapper d-flex justify-content-center gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                           class="btn btn-primary rounded-pill px-3 py-1 fw-bold btn-action-mobile">
                                            Lihat
                                        </a>

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="btn btn-warning rounded-pill px-3 py-1 fw-bold btn-action-mobile">
                                            Edit
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger rounded-pill px-3 py-1 fw-bold btn-action-mobile"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <div class="btn-group" role="group" aria-label="Pagination">
                {{-- Tombol Previous --}}
                @if ($users->onFirstPage())
                    <button class="btn btn-outline-secondary pagination-btn" disabled>Previous</button>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="btn btn-kembali pagination-btn">Previous</a>
                @endif

                {{-- Tombol Next --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="btn btn-kembali pagination-btn">Next</a>
                @else
                    <button class="btn btn-outline-secondary pagination-btn" disabled>Next</button>
                @endif
            </div>  
        </div>
    @endif
</div>

<script src="{{ asset('js/kelolapengguna.js') }}"></script>
@endsection