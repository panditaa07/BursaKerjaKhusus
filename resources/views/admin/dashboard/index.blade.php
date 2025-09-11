@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Welcome Admin</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('admin.dashboard.pelamar') }}" style="text-decoration: none;">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pelamar
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $statistics['total_pelamar'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
        <div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('admin.dashboard.pelamar.bulanini') }}" style="text-decoration: none;">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pelamar Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $statistics['pelamar_bulan_ini'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

        <div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('admin.dashboard.lowongan-aktif') }}" style="text-decoration: none;">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase text-uppercase mb-1">
                            Lowongan Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $statistics['lowongan_aktif'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

        <div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('admin.dashboard.lowongan-tidak-aktif') }}" style="text-decoration: none;">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase text-warning mb-1">
                            Lowongan Tidak Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $statistics['lowongan_tidak_aktif'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

    <!-- Daftar Pelamar Terbaru -->
    <div class="container">
        <h3 class="mb-3">Daftar Pelamar Terbaru</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Hp</th>
                    <th>Perusahaan</th>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftar_pelamar_terbaru as $index => $app)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $app->user->name ?? '-' }}</td>
                        <td>{{ $app->user->email ?? '-' }}</td>
                        <td>-</td>
                        <td>{{ $app->jobPost->company->name ?? '-' }}</td>
                        <td>{{ $app->jobPost->title ?? '-' }}</td>
                        <td>{{ $app->status ?? '-' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">👁</a>
                            <a href="#" class="btn btn-sm btn-danger">🗑</a>
                            <a href="#" class="btn btn-sm btn-warning">✏️</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada pelamar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <br><br>

    {{-- Loker Terbaru --}}
    <div class="container">
        <h3 class="mb-3">Loker Terbaru</h3>
        <table class="table table-bordered">
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
                @forelse($loker_terbaru as $index => $job)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $job->company->name ?? '-' }}</td>
                        <td>-</td>
                        <td>{{ $job->location ?? '-' }}</td>
                        <td>
                            <span class="badge bg-success">Aktif</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">👁</a>
                            <a href="#" class="btn btn-sm btn-danger">🗑</a>
                            <a href="#" class="btn btn-sm btn-warning">✏️</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada loker aktif</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <br><br>

    <!-- Tabel Lowongan tidak aktif -->
    <div class="container">
        <h3 class="mb-3">Loker Tidak Aktif</h3>
        <table class="table table-bordered">
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
                @forelse($loker_tidak_aktif as $index => $job)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $job->company->name ?? '-' }}</td>
                        <td>-</td>
                        <td>{{ $job->location ?? '-' }}</td>
                        <td>
                            <span class="badge bg-danger">Tidak Aktif</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">👁</a>
                            <a href="#" class="btn btn-sm btn-danger">🗑</a>
                            <a href="#" class="btn btn-sm btn-warning">✏️</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada loker tidak aktif</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
