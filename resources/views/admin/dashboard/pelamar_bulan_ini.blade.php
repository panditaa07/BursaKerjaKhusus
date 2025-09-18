@extends('layouts.dashboard')

@section('title', 'Daftar Pelamar Bulan Ini')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">DAFTAR PELAMAR BULAN INI</h4>
        <div class="input-group" style="width: 300px;">
            <input type="text" id="search" class="form-control" placeholder="Cari Pelamar" value="{{ request('search') }}">
            <span class="input-group-text">Total : {{ $pelamar->total() }}</span>
        </div>
    </div>
    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Pelamar Bulan Ini</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Perusahaan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
        <tbody>
            @foreach($pelamar as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->user->email }}</td>
                <td>{{ $p->user->phone ?? '-' }}</td>
                <td>{{ $p->jobPost->company?->name ?? '-' }}</td>
                <td class="text-center">
                    @if($p->status == 'accepted')
                        <span class="badge bg-success">Terima</span>
                    @elseif($p->status == 'rejected')
                        <span class="badge bg-danger">Tolak</span>
                    @elseif($p->status == 'interview')
                        <span class="badge bg-primary">Wawancara</span>
                    @elseif($p->status == 'test1')
                        <span class="badge bg-primary">Test</span>
                    @elseif($p->status == 'test2')
                        <span class="badge bg-primary">Test</span>
                    @elseif($p->status == 'submitted')
                        <span class="badge bg-secondary">Menunggu</span>
                    @else
                        <span class="badge bg-light text-dark">{{ $p->status }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.applications.show', $p->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.applications.edit', $p->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.applications.destroy', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="_redirect_to" value="{{ url()->full() }}">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $pelamar->links() }}
</div>

<script>
    document.getElementById('search').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            const query = e.target.value;
            const url = new URL(window.location.href);
            url.searchParams.set('search', query);
            window.location.href = url.toString();
        }
    });
</script>
@endsection
