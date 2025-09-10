@extends('layouts.dashboard')

@section('title', 'Lowongan Aktif')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><strong>Loker Tidak Aktif</strong></h3>
        <div>Total Loker Ditutup: {{ $total }}</div>
    </div>

    <input type="text" class="form-control mb-3" placeholder="Cari Lowongan">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-circle text-danger"></i> Daftar Lowongan Tidak Aktif
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
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
                    @forelse ($lowongans as $index => $lowongan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lowongan->perusahaan }}</td>
                            <td>{{ $lowongan->no_hrd }}</td>
                            <td>{{ $lowongan->alamat }}</td>
                            <td>
                                <span class="badge bg-danger">Tidak Aktif</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada lowongan tidak aktif</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
