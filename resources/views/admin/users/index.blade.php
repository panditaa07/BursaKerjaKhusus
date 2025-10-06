@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kelolapengguna.css') }}">

<div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Kelola Pengguna</h2>
            <div>
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary rounded">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

    {{-- Form Filter & Search --}}
    <form method="GET" action="{{ route('admin.users.index') }}" 
          class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

        <!-- Search box -->
        <div class="input-group" style="max-width: 400px;">
            <span class="input-group-text bg-white">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" name="search" class="form-control" 
                   placeholder="Cari nama atau email" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>

        <!-- Role filter -->
        <div class="input-group" style="max-width: 300px;">
            <span class="input-group-text bg-white">Role</span>
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                <option value="company" {{ request('role') == 'company' ? 'selected' : '' }}>Company</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
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
    <div class="table-container">
        <table class="table-dashboard">
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
                            <a href="{{ route('admin.users.show', $user) }}" class="table-btn view">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="table-btn edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-btn delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                {{-- Tombol Previous --}}
                @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link bg-primary text-white" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                @endif

                {{-- Tombol Next --}}
                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link bg-primary text-white" href="{{ $users->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection
