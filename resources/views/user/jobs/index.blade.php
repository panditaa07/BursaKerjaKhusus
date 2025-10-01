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
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .job-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease;
    }

    .job-card:hover {
        transform: translateY(-5px);
    }

    .job-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .job-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .company-name {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .job-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #27ae60;
        margin-bottom: 8px;
    }

    .salary {
        color: #27ae60;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .job-location, .job-deadline {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .job-location i, .job-deadline i {
        margin-right: 6px;
        color: #888;
    }

    .badge-job-type {
        display: inline-block;
        background-color: #2ecc71;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .info-button {
        background-color: #2980b9;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 0.9rem;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s ease;
    }

    .info-button:hover {
        background-color: #1c5980;
    }
</style>

<div class="job-list">
    <h2>Daftar Lowongan Kerja</h2>

    @if($jobs->isEmpty())
        <p class="empty-message">Tidak ada lowongan tersedia.</p>
    @else
        @foreach($jobs as $job)
            <div class="job-card">
                <img src="{{ $job->company && $job->company->user && $job->company->user->profile_photo_path ? asset('storage/' . $job->company->user->profile_photo_path) : asset('images/logo-smk.png') }}" alt="Company Logo" class="job-image">
                <div class="job-content">
                    <div>
                        <div class="company-name">{{ $job->company?->name ?? 'N/A' }}</div>
                        <div class="job-title">{{ $job->title }}</div>
                        <div class="badge-job-type">{{ $job->employment_type }}</div>
                        @if($job->min_salary || $job->max_salary)
                            <div class="salary">
                                Rp {{ number_format((float)($job->min_salary ?? 0)) }} 
                                @if($job->min_salary && $job->max_salary)
                                    - Rp {{ number_format((float)$job->max_salary) }}
                                @endif
                            </div>
                        @endif
                        <div class="job-location">
                            <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                        </div>
                        @if($job->deadline)
                        <div class="job-deadline">
                            <i class="fas fa-clock"></i> Batas Lamaran: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('jobs.show', $job->id) }}" class="info-button" title="Lihat detail lowongan">Info</a>
                </div>
            </div>
        @endforeach
    @endif
</div>

@if($jobs->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $jobs->links() }}
    </div>
@endif
@endsection
