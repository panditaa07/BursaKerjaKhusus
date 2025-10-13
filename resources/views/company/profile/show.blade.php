@extends('layouts.dashboard')

@section('title', 'Profil Perusahaan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profilcompany.css') }}">
@endpush

@section('content')
@php
  $user    = Auth::user();
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

      <div class="cp-actions">
        <a href="{{ route('profile.edit') }}" class="btn btn-dark" title="Edit Profil">
          <i class="fas fa-pen"></i><span class="hide-sm">Edit Profil</span>
        </a>
      </div>
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
          <p>Gunakan logo resolusi tinggi (disarankan PNG transparan atau SVG). Ukuran ideal 800×400px.</p>
          <a href="{{ route('profile.edit') }}" class="btn btn-light"><i class="fas fa-upload"></i> Ganti Logo</a>
        </div>
      </div>
    </article>

    {{-- Informasi PIC (opsional) --}}
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

  </section>
</div>
@endsection
