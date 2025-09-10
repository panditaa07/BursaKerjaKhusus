@extends('layouts.dashboard')

@section('title', 'Total Pelamar')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">TOTAL PELAMAR</h4>
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control" placeholder="Cari Pelamar">
            <span class="input-group-text">Total Pelamar : {{ $pelamar->count() }}</span>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Pelamar</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Hp</th>
                        <th>Perusahaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelamar as $index => $p)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->no_hp }}</td>
                            <td>{{ $p->perusahaan }}</td>
                            <td class="text-center">
                                @if($p->status == 'Diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($p->status == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($p->status == 'Wawancara')
                                    <span class="badge bg-warning text-dark">Wawancara</span>
                                @elseif($p->status == 'Menunggu')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @else
                                    <span class="badge bg-info">Tes</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
