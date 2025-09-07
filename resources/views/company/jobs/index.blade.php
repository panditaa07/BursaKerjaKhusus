@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Daftar Lowongan Kerja</h2>
    <a href="{{ route('company.jobs.create') }}" class="btn btn-primary mb-3">+ Tambah Lowongan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Perusahaan</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->title }}</td>
                <td>{{ $job->company ? $job->company->name : 'N/A' }}</td>
                <td>{{ Str::limit($job->description, 50) }}</td>
                <td>{{ $job->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
