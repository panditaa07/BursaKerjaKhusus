@extends('layouts.dashboard')
@section('title', 'User Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Welcome User</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="h4 mb-4">Lowongan Terbaru</h2>
        </div>
    </div>

    <div class="row">
        @foreach($latestJobs as $job)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                @if($job->company_logo)
                <img src="{{ asset('storage/' . $job->company_logo) }}" class="card-img-top" alt="{{ $job->company->name }}" style="height: 200px; object-fit: cover;">
                @else
                <img src="https://via.placeholder.com/1000x200?text=No+Image" class="card-img-top" alt="{{ $job->company->name }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $job->title }}</h5>
                    <p class="card-text text-muted">{{ $job->company->name }}</p>
                    <p class="text-muted small">📍 {{ $job->location }}</p>
                    <p class="text-muted small">💰 {{ $job->salary }}</p>
                    <p class="text-muted small">👥 {{ $job->vacancies }} orang, lulusan semua jurusan SMK</p>
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
