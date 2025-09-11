@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelola Data Lowongan Kerja</h2>
        <a href="{{ route('admin.job-posts.create') }}" class="btn btn-primary">Tambah Lowongan</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Pekerjaan</th>
                            <th>Perusahaan</th>
                            <th>Lokasi</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobPosts as $index => $job)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->company->name ?? '-' }}</td>
                                <td>{{ $job->location }}</td>
                                <td>{{ $job->employment_type }}</td>
                                <td>
                                    <span class="badge badge-{{ $job->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $job->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada lowongan kerja</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
