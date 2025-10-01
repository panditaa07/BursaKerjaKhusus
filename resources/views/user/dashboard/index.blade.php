@extends('layouts.dashboard')

@section('content')
<div class="dashboard-header-bg" style="background-image: url('{{ asset('images/smkn4.png') }}');">
    <div class="overlay"></div>
    <img src="{{ asset('images/disdik.png') }}" alt="Disdik Jabar Logo" style="position: absolute; top: 15px; right: 15px; width: 100px; z-index: 10;">
</div>

<div style="background-color: #0d3a7d; color: white; padding: 5px 15px; font-weight: 600; font-size: 0.9rem;">
    Lowongan Baru di PT Kotom Jaya!!
</div>

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
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn-primary">Info</a>
                </div>
            </div>
        </div>
        @endif
        @empty
        <p class="text-center text-white">Belum ada lowongan terbaru.</p>
        @endforelse
    </div>
</section>

<footer>
    <div class="footer-info">
        <div class="alamat">
            <img src="{{ asset('images/smkn4.png') }}" alt="SMK Negeri 4 Bandung" style="height: 80px; margin-bottom: 10px;">
            <p>SMK NEGERI 4 BANDUNG<br>
            Jl. Kliningan No.6, Turangga, Kec. Lengkong<br>
            Telp/Fax: (022) - 7309738<br>
            Kode Pos : 40264 Kota Bandung<br>
            Provinsi Jawa Barat<br>
            Indonesia</p>
        </div>
        <div class="tautan">
            <a href="https://disdik.jabarprov.go.id" target="_blank" rel="noopener noreferrer">Dinas Pendidikan Jawa Barat</a>
            <a href="https://kemdikbud.go.id" target="_blank" rel="noopener noreferrer">Kementerian Pendidikan dan Kebudayaan</a>
            <a href="https://referensi.data.kemdikbud.go.id" target="_blank" rel="noopener noreferrer">Referensi Pendidikan</a>
            <a href="https://digital.literasi" target="_blank" rel="noopener noreferrer">Digital Literasi</a>
            <a href="https://smk.bisa" target="_blank" rel="noopener noreferrer">SMK Bisa</a>
        </div>
    </div>
    <div class="sosmed">
        <a href="https://instagram.com/smkn4bdg" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('images/instagram.png') }}" alt="Instagram">
        </a>
        <a href="https://facebook.com/smkn4bdg" target="_blank" rel="noopener noreferrer">
            <img src="{{ asset('images/facebook.png') }}" alt="Facebook">
        </a>
    </div>
    <div class="copyright">
        <p>© 2025 smkn4bdg.sch.id All Rights Reserved</p>
    </div>
</footer>
@endsection
