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
                    @forelse ($lowongan as $index => $l)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $l->company->name ?? 'N/A' }}</td>
                            <td>{{ 'N/A' }}</td>
                            <td>{{ $l->location ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-danger">Tidak Aktif</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.job-posts.show', $l->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.job-posts.edit', $l->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.job-posts.destroy', $l->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                                </form>
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
