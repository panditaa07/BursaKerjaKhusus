@extends('layouts.dashboard')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        color: #222;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .job-list {
        max-width: 800px;
        margin: 0 auto;
        padding: 10px;
    }

    .job-card {
        background: #fff;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.2s ease;
    }

    .job-card:hover {
        transform: translateY(-3px);
    }

    .job-card h3 {
        margin: 0;
        color: #2c3e50;
        font-size: 1.2rem;
    }

    .job-card p {
        color: #555;
        font-size: 0.95rem;
        margin: 8px 0;
    }

    .job-card small {
        display: block;
        margin-bottom: 10px;
        color: #888;
    }

    .job-card a {
        text-decoration: none;
        background: #3498db;
        color: white;
        padding: 8px 14px;
        border-radius: 5px;
        font-size: 0.9rem;
        transition: background 0.2s ease;
    }

    .job-card a:hover {
        background: #217dbb;
    }

    .empty-message {
        text-align: center;
        color: #666;
        font-size: 1rem;
    }
</style>

<div class="job-list">
    <h2>Daftar Lowongan Kerja</h2>

    @if($jobs->isEmpty())
        <p class="empty-message">Tidak ada lowongan tersedia.</p>
    @else
        @foreach($jobs as $job)
            <div class="job-card">
                <h3>{{ $job->title }}</h3>
                <p>{{ Str::limit($job->description, 100) }}</p>
                <small>Perusahaan: {{ $job->company->name }}</small>
                <a href="{{ route('jobs.show', $job->id) }}">Lihat Detail</a>
            </div>
        @endforeach
    @endif
</div>
@endsection
