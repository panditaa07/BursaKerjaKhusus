@extends('layouts.dashboard')

@section('title', 'Profil Perusahaan & Pengguna')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profilcompany.css') }}">
@endpush

@section('content')
@php
  $user     = Auth::user();
  $company  = $user->company;
  $logo     = optional($company)->logo;
  $slug     = $company?->slug ?: 'company';
  $companyUrl = url('/'.$slug);
@endphp

<div class="container">

  {{-- ===== HERO HEADER ===== --}}
  <header class="hero">
    <div class="hero-cover"></div>

    <div class="hero-inner">
      <div class="hero-logo">
        @if($logo)
          <img src="{{ asset('storage/'.$logo) }}" alt="Logo Perusahaan">
        @else
          <div class="hero-logo-fallback"><i class="fas fa-building"></i></div>
        @endif
      </div>

      <div class="hero-title">
        <h1>{{ $company->name ?? 'Nama Perusahaan' }}</h1>

        <div class="hero-meta">
          <a class="chip" href="{{ $companyUrl }}" target="_blank" rel="noopener">
            <i class="fas fa-globe"></i>{{ $companyUrl }}
          </a>
        </div>
      </div>

      <div class="hero-actions">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
          <i class="fas fa-pen"></i> Edit Profil
        </a>
      </div>
    </div>
  </header>

  {{-- ===== GRID: 2 kartu ===== --}}
  <div class="cards-grid">
    {{-- === Informasi Perusahaan === --}}
    <div class="card mb-4">
      <div class="card-header">
        <h3>Informasi Perusahaan</h3>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p><strong>Nama Perusahaan:</strong> {{ $company->name ?? '-' }}</p>
            <p><strong>Alamat Perusahaan:</strong> {{ $company->address ?? '-' }}</p>
            <p><strong>No. Telp Perusahaan:</strong> {{ $company->phone ?? '-' }}</p>
            <p><strong>Email Kontak:</strong> {{ $company->email ?? '-' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Industri:</strong> {{ optional($company?->industry)->name ?? '-' }}</p>
            <p><strong>Deskripsi:</strong> {{ $company->description ?? '-' }}</p>
          </div>
        </div>
      </div>
    </div>

    {{-- === Informasi PIC === --}}
    <div class="card">
      <div class="card-header">
        <h3>Informasi PIC</h3>
      </div>

      <div class="card-body">
        <div class="text-center mb-4">
          <h5 class="mb-3"><i class="fas fa-user-circle text-primary"></i> Foto Profil PIC</h5>
          @if($user->profile_photo_path)
            <img src="{{ asset('storage/'.$user->profile_photo_path) }}"
                 alt="Foto Profil {{ $user->name }}"
                 class="rounded-circle border"
                 style="width:120px;height:120px;object-fit:cover;border-width:4px !important;border-color:#dee2e6 !important;box-shadow:0 4px 12px rgba(0,0,0,.15);">
          @else
            <div class="rounded-circle border bg-light d-inline-flex align-items-center justify-content-center"
                 style="width:120px;height:120px;border-width:4px !important;border-color:#dee2e6 !important;box-shadow:0 4px 12px rgba(0,0,0,.15);">
              <i class="fas fa-user text-muted fa-3x"></i>
            </div>
          @endif
        </div>

        <div class="row justify-content-center">
          <div class="col-md-6">
            <p><strong>Nama PIC:</strong> {{ $user->name }}</p>
            <p><strong>Email PIC:</strong> {{ $user->email }}</p>
            <p><strong>No. HP PIC:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong>Alamat PIC:</strong> {{ $user->address ?? '-' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/profile.js') }}" defer></script>
@endpush
