@extends('layouts.dashboard')

@section('title', 'Detail Pengguna')

@section('content')
<link rel="stylesheet" href="{{ asset('css/detailpengguna.css') }}">

{{-- Tombol Kembali --}}
<div class="container">
    <a href="{{ route('admin.users.index') }}" class="btn btn-custom back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if($user->role->name === 'company')
    @php
      $company = $user->company;
      $logo    = $company?->logo;
    @endphp

    <div class="container">
      {{-- HERO --}}
      <section class="hero">
        <div class="hero-cover"></div>
        <div class="hero-inner">
          <div class="hero-logo">
            @if($logo)
              <img src="{{ asset('storage/'.$logo) }}" alt="Logo {{ $company->name }}">
            @else
              <div class="hero-logo-fallback"><i class="fas fa-building"></i></div>
            @endif
          </div>
          <div class="hero-title">
            <h1>{{ $company->name ?? $user->name }}</h1>
            <div class="hero-meta">
                <span class="chip"><i class="fas fa-envelope"></i>{{ $company->email ?? $user->email }}</span>
                <span class="chip"><i class="fas fa-phone"></i>{{ $company->phone ?? 'No. Telp belum diisi' }}</span>
            </div>
          </div>
        </div>
      </section>

      {{-- GRID --}}
      <section class="cards-grid">
        {{-- Informasi Perusahaan --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-info-circle"></i> Detail Perusahaan</h3>
          </header>
          <div class="card-body">
            <dl class="kv">
              <dt>Nama Perusahaan</dt>
              <dd>{{ $company->name ?? '-' }}</dd>
              <dt>Email Perusahaan</dt>
              <dd>{{ $company->email ?? '-' }}</dd>
              <dt>No. Telp Perusahaan</dt>
              <dd>{{ $company->phone ?? '-' }}</dd>
              <dt>Alamat</dt>
              <dd>{{ $company->address ?? '-' }}</dd>
            </dl>
          </div>
        </article>

        {{-- Informasi PIC / HRD --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-user-tie"></i> Detail PIC / HRD</h3>
          </header>
          <div class="card-body">
            <div class="pic">
              <div class="pic-avatar">
                @if($user->profile_photo_path)
                  <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Foto PIC">
                @else
                  <div class="avatar-fallback"><i class="fas fa-user"></i></div>
                @endif
              </div>
              <div class="kv">
                <dl>
                  <dt>Nama PIC</dt>
                  <dd>{{ $user->name }}</dd>
                  <dt>Email PIC</dt>
                  <dd>{{ $user->email }}</dd>
                  <dt>No. HP PIC</dt>
                  <dd>{{ $user->phone ?? '-' }}</dd>
                </dl>
              </div>
            </div>
            <hr class="my-3">
            <dl class="kv">
              <dt>Alamat PIC</dt>
              <dd>{{ $user->address ?? '-' }}</dd>
              <dt>Status Akun</dt>
              <dd>{{ $user->deleted_at ? 'Nonaktif' : 'Aktif' }}</dd>
              <dt>Tanggal Daftar</dt>
              <dd>{{ $user->created_at->format('d M Y') }}</dd>
            </dl>
          </div>
        </article>

        {{-- Sosial Media Perusahaan --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-share-alt"></i> Sosial Media Perusahaan</h3>
          </header>
          <div class="card-body">
            <dl class="kv">
                <dt>LinkedIn</dt>
                <dd>
                    @if($company->linkedin)
                        <a href="{{ $company->linkedin }}" target="_blank" class="link"><i class="fab fa-linkedin"></i> {{ $company->linkedin }}</a>
                    @else - @endif
                </dd>
                <dt>Facebook</dt>
                <dd>
                    @if($company->facebook)
                        <a href="{{ $company->facebook }}" target="_blank" class="link"><i class="fab fa-facebook"></i> {{ $company->facebook }}</a>
                    @else - @endif
                </dd>
                <dt>Twitter / X</dt>
                <dd>
                    @if($company->twitter)
                        <a href="{{ $company->twitter }}" target="_blank" class="link"><i class="fab fa-twitter"></i> {{ $company->twitter }}</a>
                    @else - @endif
                </dd>
                <dt>TikTok</dt>
                <dd>
                    @if($company->tiktok)
                        <a href="{{ $company->tiktok }}" target="_blank" class="link"><i class="fab fa-tiktok"></i> {{ $company->tiktok }}</a>
                    @else - @endif
                </dd>
                <dt>YouTube</dt>
                <dd>
                    @if($company->youtube)
                        <a href="{{ $company->youtube }}" target="_blank" class="link"><i class="fab fa-youtube"></i> {{ $company->youtube }}</a>
                    @else - @endif
                </dd>
            </dl>
          </div>
        </article>

        {{-- Lowongan Kerja Terbaru --}}
        <article class="card">
          <header class="card-head">
            <h3><i class="fas fa-briefcase"></i> Lowongan Kerja Terbaru</h3>
          </header>
          <div class="card-body">
            @if($user->jobPosts->isEmpty())
              <p>Belum ada lowongan kerja yang dipasang.</p>
            @else
              <div class="job-post-list">
                @foreach($user->jobPosts as $job)
                  <div class="job-post-item">
                    <div class="job-post-info">
                      <h4>{{ $job->title }}</h4>
                      <p><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</p>
                      <p><i class="far fa-calendar-alt me-1"></i>{{ $job->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="job-post-status">
                      <span class="badge-enhanced {{ $job->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                        {{ $job->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                      </span>
                      <a href="{{ route('admin.job-posts.show', $job->id) }}" class="btn btn-sm btn-info">Detail</a>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </article>
      </section>
    </div>

@else
    <div class="container">
      {{-- HERO --}}
      <section class="hero">
        <div class="hero-cover"></div>
        <div class="hero-inner">
          <div class="hero-logo">
            @if($user->profile_photo_path)
              <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Foto Profil">
            @else
              <div class="hero-logo-fallback"><i class="fas fa-user"></i></div>
            @endif
          </div>
          <div class="hero-title">
            <h1>{{ $user->name }}</h1>
            <div class="hero-meta">
                <span class="chip"><i class="fas fa-user-tag"></i>{{ $user->role->name }}</span>
                <span class="chip"><i class="fas fa-envelope"></i>{{ $user->email }}</span>
                <span class="chip"><i class="fas fa-phone"></i>{{ $user->phone ?? 'No. HP belum diisi' }}</span>
            </div>
          </div>
        </div>
      </section>

      {{-- GRID --}}
      <section class="cards-grid">
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
                        <a href="{{ route('admin.users.download_cv', $user) }}" class="btn btn-sm btn-info" download>Download</a>
                    @else
                        Tidak ada CV
                    @endif
                </dd>
                <dt>Surat Lamaran</dt>
                <dd>
                    @if($user->cover_letter_path)
                        <a href="{{ route('admin.users.preview_cover_letter', $user) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                        <a href="{{ route('admin.users.download_cover_letter', $user) }}" class="btn btn-sm btn-info" download>Download</a>
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
        <article class="card riwayat-card">
            <header class="card-head">
                <h3><i class="fas fa-history"></i> Riwayat Lamaran ({{ $user->applications->count() }})</h3>
            </header>
            <div class="card-body riwayat-container">
                @if($user->applications->isEmpty())
                    <p>Belum ada riwayat lamaran.</p>
                @else
                    <div class="table-wrapper">
                        <table class="table table-bordered table-striped riwayat-table">
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
                    </div>
                @endif
            </div>
        </article>
      </section>
    </div>
@endif

@endsection
