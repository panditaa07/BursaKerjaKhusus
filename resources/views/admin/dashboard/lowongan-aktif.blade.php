@extends('layouts.dashboard')

@section('title', 'Lowongan Aktif')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">LOWONGAN AKTIF</h4>
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control" placeholder="Cari Lowongan">
            <span class="input-group-text">Total : {{ $lowongan->count() }}</span>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Lowongan Aktif</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-primary text-center">
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
                    @forelse($lowongan as $index => $l)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $l->perusahaan }}</td>
                            <td>{{ $l->no_hrd }}</td>
                            <td>{{ $l->alamat }}</td>
                            <td class="text-center">
                                <span class="badge bg-success">Aktif</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada lowongan aktif</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
