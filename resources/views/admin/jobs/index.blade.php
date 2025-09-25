@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Kelola Data Lowongan Kerja</h2>
        <a href="{{ route('admin.job-posts.create') }}" class="btn btn-add-job">+ Tambah Lowongan</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table modern-table">
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
                                    @if($job->status == 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.job-posts.show', $job->id) }}" class="table-btn view">
        <i class="bi bi-eye"></i>
    </a>
                                    <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="table-btn edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                                        <button type="submit" class="table-btn delete" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
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