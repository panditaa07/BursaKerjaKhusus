@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/daftarlowongan.css') }}">
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

      <div class="pagination-custom">
    <ul class="pagination">
        {{-- Tombol Previous --}}
        @if ($jobs->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $jobs->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
        @endif

        {{-- Tombol Next --}}
        @if ($jobs->hasMorePages())
            <li class="page-item">
                <a class="page-link active" href="{{ $jobs->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
    </ul>
</div>


<script src="{{ asset('js/daftarlowongan.js') }}"></script>
@endsection
