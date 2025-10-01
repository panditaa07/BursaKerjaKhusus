@extends('layouts.dashboard')
@section('title', 'Daftar Pelamar')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Daftar Pelamar</h1>
    

    <form method="GET" action="{{ route('admin.applications.all') }}" class="mb-3">
        <div class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau email pelamar...">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="modern-table table-hover">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>NO.HP</th>
                    <th>PERUSAHAAN</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $application->user?->name ?? '-' }}</td>
                    <td>{{ $application->user?->email ?? '-' }}</td>
                    <td>{{ $application->user?->phone ?? '-' }}</td>
                    <td>{{ $application->jobPost->company->name ?? '-' }}</td>
                    <td>
                        <span class="badge 
                            @if(in_array($application->status, ['submitted','test1','test2'])) badge-warning
                            @elseif($application->status === 'interview') badge-info
                            @elseif($application->status === 'accepted') badge-success
                            @else badge-danger
                            @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('admin.applications.edit', $application->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.applications.destroy', $application->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus aplikasi ini?')">
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

    {{ $applications->links() }}
</div>
@endsection