@extends('layouts.dashboard')

@section('title', 'Lowongan Tidak Aktif')

@section('content')
<div class="container">
   <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">LOWONGAN TIDAK AKTIF</h4>
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control" placeholder="Cari Lowongan">
            <span class="input-group-text">Total : {{ $lowongan->count() }}</span>
        </div>
    </div>
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
                    @forelse ($lowongan as $index => $lowongan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lowongan->perusahaan }}</td>
                            <td>{{ $lowongan->no_hrd }}</td>
                            <td>{{ $lowongan->alamat }}</td>
                            <td>
                                <span class="badge bg-danger">Tidak Aktif</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
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
