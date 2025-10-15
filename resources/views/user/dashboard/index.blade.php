@extends('layouts.dashboard')

@section('title', 'Dashboard Pengguna')

@section('content')
<link rel="stylesheet" href="{{ asset('css/userdashboard.css') }}">

<section>
    <h2 class="section-title">LOWONGAN TERBARU</h2>
    <div class="lowongan-grid">
        @forelse($latestJobs as $job)
        @if($job && $job->id && $job->company)
        <div class="lowongan-card">
            <img src="{{ $job->company->user && $job->company->user->profile_photo_path ? asset('storage/' . $job->company->user->profile_photo_path) : asset('images/logo-smk.png') }}" alt="Company Logo" class="lowongan-image">
            <div class="lowongan-content">
                <div class="lowongan-company">{{ $job->company->name ?? 'N/A' }}</div>
                <div class="lowongan-title">{{ $job->title ?? '-' }}</div>
                <div class="lowongan-details">
                    <div><i class="fas fa-money-bill-wave icon"></i> {{ $job->salary ?? 'Gaji tidak tersedia' }}</div>
                    <div><i class="fas fa-map-marker-alt icon"></i> {{ $job->location ?? 'Lokasi tidak tersedia' }}</div>
                    <div><i class="fas fa-clock icon"></i> Sisa waktu: {{ $job->created_at ? $job->created_at->diffForHumans(null, true) : 'Tidak tersedia' }}</div>
                </div>
                <div class="lowongan-meta">
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn-info">Info</a>
                </div>
            </div>
        </div>
        @endif
        @empty
        <p class="text-center text-white">Belum ada lowongan terbaru.</p>
        @endforelse
    </div>
</section>
<script src="{{ asset('js/userdashboard.js') }}"></script>
@endsection
