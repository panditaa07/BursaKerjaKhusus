@extends('layouts.dashboard')

@section('title', 'Verifikasi Akun')

@section('content')

<link rel="stylesheet" href="{{ asset('css/verifikasi.css') }}">
<link rel="stylesheet" href="{{ asset('css/Kelolapengguna.css') }}">

<div class="container mx-auto px-4 py-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="h1 mb-4 page-title">Verifikasi Akun</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pending Users</h6>
        </div>
        <div class="card-body">
            <div class="container table-responsive table-section">
                <table class="table-dashboard mb=0 text-center" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingUsers as $user)
                            <tr>
                                <td data-label="Nama">{{ $user->name }}</td>
                                <td data-label="Email">{{ $user->email }}</td>
                                <td data-label="Role">{{ $user->role->name }}</td>
                                <td data-label="Tanggal Daftar">{{ $user->created_at->format('d M Y') }}</td>
                                <td data-label="Aksi">
                                    <form action="{{ route('admin.verifications.users.approve', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.verifications.users.reject', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No pending users.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pending Companies</h6>
        </div>
        <div class="card-body">
            <div class="container table-responsive table-section">
                <table class="table-dashboard mb=0 text-center" id="companiesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingCompanies as $company)
                            <tr>
                                <td data-label="Nama">{{ $company->name }}</td>
                                <td data-label="Email">{{ $company->email }}</td>
                                <td data-label="Tanggal Daftar">{{ $company->created_at->format('d M Y') }}</td>
                                <td data-label="Aksi">
                                    <form action="{{ route('admin.verifications.companies.approve', $company) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.verifications.companies.reject', $company) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No pending companies.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection