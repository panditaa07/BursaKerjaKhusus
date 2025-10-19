@extends('layouts.dashboard')

@section('title', 'Detail Pengguna')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profilcompany.css') }}">
<link rel="stylesheet" href="{{ asset('css/detailpengguna.css') }}">
<style>
.job-post-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.job-post-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    background-color: #fdfdff;
}
.job-post-info h4 {
    margin-bottom: 0.25rem;
    font-size: 1.1rem;
    font-weight: 600;
}
.job-post-info p {
    margin-bottom: 0;
    color: #6c757d;
    font-size: 0.9rem;
}
.job-post-status {
    text-align: right;
    flex-shrink: 0;
}
.badge-enhanced {
    display: inline-block;
    padding: .4em .65em;
    font-size: .75em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
}
.badge-enhanced .fas {
    font-size: 0.9em;
    margin-right: 0.25rem;
}
.bg-success {
    background-color: #198754 !important;
}
.bg-danger {
    background-color: #dc3545 !important;
}
</style>
@endpush

@section('content')

{{-- Tombol Kembali --}}
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-custom back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if($user->role->name === 'company')
    @php
      $company = $user->company;
      $logo    = optional($company)->logo;
      $industry= optional($company?->industry)->name;
      $webRaw  = $company?->website;
      $web     = $webRaw ? \Illuminate\Support\Str::of($webRaw)
                  ->replaceStart('https://','')
                  ->replaceStart('http://','') : null;
      $slug    = $company?->slug ?: 'company';
    @endphp

    <div class="company-page">
      {{-- HERO --}}
      <section class="cp-hero">
        <div class="cp-cover"></div>
        <div class="cp-hero-inner">
          <div class="cp-logo">
            @if($logo)
              <img src="{{ asset('storage/'.$logo) }}" alt="Logo Perusahaan">
            @else
              <div class="cp-logo-fallback"><i class="fas fa-building"></i></div>
            @endif
          </div>
          <div class="cp-title">
            <h1>{{ $company->name ?? 'Nama Perusahaan' }}</h1>
            <div class="cp-meta">
              @if($industry)
                <span class="chip"><i class="fas fa-industry"></i>{{ $industry }}</span>
              @endif
              @if($web)
                <a class="cp-link" href="{{ \Illuminate\Support\Str::startsWith($webRaw,'http') ? $webRaw : 'https://'.$web }}" target="_blank" rel="noopener">
                  <i class="fas fa-globe"></i>{{ $web }}
                </a>
              @else
                <span class="cp-link is-muted"><i class="fas fa-globe"></i>Website belum diisi</span>
              @endif
              <span class="cp-link"><i class="fas fa-link"></i>{{ url('/'.$slug) }}</span>
            </div>
          </div>
          {{-- Actions removed --}}
        </div>
      </section>

      {{-- GRID --}}
      <section class="cp-grid">
        {{-- Informasi Perusahaan --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-briefcase"></i> Informasi Perusahaan</h3>
          </header>
          <div class="card-body grid-2">
            <dl class="kv">
              <dt>Nama Perusahaan</dt>
              <dd>{{ $company->name ?? '-' }}</dd>
              <dt>Alamat</dt>
              <dd>{{ $company->address ?? '-' }}</dd>
              <dt>Telepon</dt>
              <dd>{{ $company->phone ?? '-' }}</dd>
              <dt>Email Kontak</dt>
              <dd>{{ $company->email ?? '-' }}</dd>
            </dl>
            <dl class="kv">
              <dt>Industri</dt>
              <dd>{{ $industry ?? '-' }}</dd>
              <dt>Website</dt>
              <dd>
                @if($web)
                  <a class="link" href="{{ \Illuminate\Support\Str::startsWith($webRaw,'http') ? $webRaw : 'https://'.$web }}" target="_blank">
                    {{ $web }} <i class="fas fa-external-link-alt"></i>
                  </a>
                @else - @endif
              </dd>
              <dt>Dibuat</dt>
              <dd>{{ optional($company?->created_at)->format('d M Y') ?? '-' }}</dd>
              <dt>Diperbarui</dt>
              <dd>{{ optional($company?->updated_at)->format('d M Y') ?? '-' }}</dd>
            </dl>
          </div>
        </article>

        {{-- Tentang Perusahaan --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-align-left"></i> Tentang Perusahaan</h3>
          </header>
          <div class="card-body">
            <div class="prose">
              {{ $company?->description ?: 'Belum ada deskripsi perusahaan.' }}
            </div>
          </div>
        </article>

        {{-- Logo & Branding --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-image"></i> Logo & Branding</h3>
          </header>
          <div class="card-body branding">
            <div class="branding-preview">
              @if($logo)
                <img src="{{ asset('storage/'.$logo) }}" alt="Logo Perusahaan">
              @else
                <div class="branding-fallback"><i class="fas fa-building"></i></div>
              @endif
            </div>
            <div class="branding-text">
              <p>Logo perusahaan yang terdaftar.</p>
              {{-- Upload button removed --}}
            </div>
          </div>
        </article>

        {{-- Informasi PIC --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-user-circle"></i> Informasi PIC</h3>
          </header>
          <div class="card-body">
            <div class="pic">
              <div class="pic-avatar">
                @if($user->profile_photo_path)
                  <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user->name }}">
                @else
                  <div class="avatar-fallback"><i class="fas fa-user"></i></div>
                @endif
              </div>
              <dl class="kv">
                <dt>Nama</dt> <dd>{{ $user->name }}</dd>
                <dt>Email</dt> <dd>{{ $user->email }}</dd>
                <dt>No. HP</dt> <dd>{{ $user->phone ?? '-' }}</dd>
                <dt>Alamat</dt> <dd>{{ $user->address ?? '-' }}</dd>
              </dl>
            </div>
          </div>
        </article>

        {{-- Lowongan Perusahaan --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-briefcase-medical"></i> Lowongan Perusahaan ({{ $user->jobPosts->count() }})</h3>
          </header>
          <div class="card-body">
            @if($user->jobPosts->isEmpty())
                <p>Perusahaan ini belum memiliki lowongan.</p>
            @else
                <div class="job-post-list">
                    @foreach($user->jobPosts as $job)
                        <div class="job-post-item">
                            <div class="job-post-info">
                                <h4>{{ $job->title }}</h4>
                                <p>{{ $job->location }} &bull; {{ $job->employment_type }}</p>
                            </div>
                            <div class="job-post-status">
                                <span class="badge-enhanced
                                    @if($job->status == 'active') bg-success
                                    @else bg-danger @endif">
                                    <i class="fas fa-{{ $job->status == 'active' ? 'check' : 'pause' }} me-1"></i>
                                    {{ ucfirst($job->status) }}
                                </span>
                                <a href="{{ route('admin.job-posts.show', $job->id) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
          </div>
        </article>
      </section>
    </div>

@else {{-- This is for regular users --}}

    <div class="company-page"> {{-- Re-use the same container class --}}
      {{-- HERO --}}
      <section class="cp-hero">
        <div class="cp-cover"></div>
        <div class="cp-hero-inner">
          <div class="cp-logo">
            @if($user->profile_photo_path)
              <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Foto Profil">
            @else
              <div class="cp-logo-fallback"><i class="fas fa-user"></i></div>
            @endif
          </div>
          <div class="cp-title">
            <h1>{{ $user->name }}</h1>
            <div class="cp-meta">
                <span class="chip"><i class="fas fa-user-tag"></i>{{ $user->role->name }}</span>
                <span class="cp-link"><i class="fas fa-envelope"></i>{{ $user->email }}</span>
                <span class="cp-link"><i class="fas fa-phone"></i>{{ $user->phone ?? 'No. HP belum diisi' }}</span>
            </div>
          </div>
          {{-- Actions removed --}}
        </div>
      </section>

      {{-- GRID --}}
      <section class="cp-grid">
        {{-- Informasi Personal --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-user-shield"></i> Informasi Personal</h3>
          </header>
          <div class="card-body grid-2">
            <dl class="kv">
              <dt>Nama Lengkap</dt>
              <dd>{{ $user->name }}</dd>
              <dt>Email</dt>
              <dd>{{ $user->email }}</dd>
              <dt>No HP</dt>
              <dd>{{ $user->phone ?? '-' }}</dd>
              <dt>Alamat</dt>
              <dd>{{ $user->address ?? '-' }}</dd>
            </dl>
            <dl class="kv">
              <dt>NIK/NISN</dt>
              <dd>{{ $user->nisn ?? '-' }}</dd>
              <dt>Tanggal Lahir</dt>
              <dd>{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M Y') : '-' }}</dd>
              <dt>Status Akun</dt>
              <dd>{{ $user->deleted_at ? 'Nonaktif' : 'Aktif' }}</dd>
              <dt>Tanggal Daftar</dt>
              <dd>{{ $user->created_at->format('d M Y') }}</dd>
            </dl>
          </div>
        </article>

        {{-- Berkas & Sosial Media --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-file-alt"></i> Berkas & Sosial Media</h3>
          </header>
          <div class="card-body">
            <dl class="kv">
                <dt>CV</dt>
                <dd>
                    @if($user->cv_path)
                        <a href="{{ route('admin.users.preview_cv', $user) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                        <a href="{{ route('admin.users.download_cv', $user) }}" class="btn btn-sm btn-primary" download>Download</a>
                    @else
                        Tidak ada CV
                    @endif
                </dd>
                <dt>Surat Lamaran</dt>
                <dd>
                    @if($user->cover_letter_path)
                        <a href="{{ route('admin.users.preview_cover_letter', $user) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                        <a href="{{ route('admin.users.download_cover_letter', $user) }}" class="btn btn-sm btn-primary" download>Download</a>
                    @else
                        Tidak ada surat lamaran
                    @endif
                </dd>
                <dt>Portfolio</dt>
                <dd>
                    @if($user->portfolio_link)
                        <a href="{{ $user->portfolio_link }}" target="_blank"><i class="fas fa-link"></i> {{ $user->portfolio_link }}</a>
                    @else - @endif
                </dd>
                <dt>LinkedIn</dt>
                <dd>
                    @if($user->linkedin)
                        <a href="{{ $user->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i> {{ $user->linkedin }}</a>
                    @else - @endif
                </dd>
                <dt>Instagram</dt>
                <dd>
                    @if($user->instagram)
                        <a href="{{ $user->instagram }}" target="_blank"><i class="fab fa-instagram"></i> {{ $user->instagram }}</a>
                    @else - @endif
                </dd>
                <dt>Facebook</dt>
                <dd>
                    @if($user->facebook)
                        <a href="{{ $user->facebook }}" target="_blank"><i class="fab fa-facebook"></i> {{ $user->facebook }}</a>
                    @else - @endif
                </dd>
                <dt>Twitter</dt>
                <dd>
                    @if($user->twitter)
                        <a href="{{ $user->twitter }}" target="_blank"><i class="fab fa-twitter"></i> {{ $user->twitter }}</a>
                    @else - @endif
                </dd>
                <dt>TikTok</dt>
                <dd>
                    @if($user->tiktok)
                        <a href="{{ $user->tiktok }}" target="_blank"><i class="fab fa-tiktok"></i> {{ $user->tiktok }}</a>
                    @else - @endif
                </dd>
            </dl>
          </div>
        </article>

        {{-- Riwayat Lamaran --}}
        <article class="card">
            <header class="card-head">
                <h3><i class="fas fa-history"></i> Riwayat Lamaran ({{ $user->applications->count() }})</h3>
            </header>
            <div class="card-body">
                @if($user->applications->isEmpty())
                    <p>Belum ada riwayat lamaran.</p>
                @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Judul Lowongan</th>
                                <th>Perusahaan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->applications as $application)
                                <tr>
                                    <td>{{ $application->jobPost->title ?? '-' }}</td>
                                    <td>{{ $application->jobPost->company->name ?? '-' }}</td>
                                    <td>{{ ucfirst($application->status) }}</td>
                                    <td>{{ $application->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </article>
      </section>
    </div>
@endif

@endsection