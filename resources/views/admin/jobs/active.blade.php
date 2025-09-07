@extends('layouts.dashboard')
@section('title', 'Daftar Lowongan Kerja Aktif')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Daftar Lowongan Kerja Aktif</h1>
    <form method="GET" action="{{ route('admin.job-posts.active') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari judul lowongan...">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>PERUSAHAAN</th>
                    <th>NO.HRD</th>
                    <th>ALAMAT</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobPosts as $jobPost)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jobPost->company->name ?? '-' }}</td>
                    <td>{{ $jobPost->company->phone ?? '-' }}</td>
                    <td>{{ $jobPost->company->address ?? '-' }}</td>
                    <td>
                        <span class="badge badge-success">{{ $jobPost->status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.job-posts.show', $jobPost->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('admin.job-posts.edit', $jobPost->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.job-posts.destroy', $jobPost->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus lowongan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $jobPosts->links() }}
</div>
@endsection
