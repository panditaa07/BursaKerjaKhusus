@extends('layouts.dashboard')

@section('title', 'Profil Perusahaan & Pengguna')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profilcompany.css') }}">
@endpush

@section('content')
@php
  use Illuminate\Support\Facades\Storage;
  use Illuminate\Support\Str;

  $user     = Auth::user();
  $company  = $user->company;
  $slug     = $company?->slug ?: 'company';
  $companyUrl = url('/'.$slug);

  // Helper path -> URL aman dari storage/public
  $mkUrl = function ($rawPath) {
      if (!$rawPath) return null;
      if (Str::startsWith($rawPath, ['http://','https://'])) return $rawPath;
      $normalized = Str::startsWith($rawPath, 'public/') ? Str::after($rawPath, 'public/') : $rawPath;
      return Storage::disk('public')->exists($normalized) ? asset('storage/'.$normalized) : null;
  };

  $logoUrl  = $mkUrl(optional($company)->logo);

  // Foto PIC (Jetstream atau custom)
  $photoRaw = $user->profile_photo_path;
  $photoUrl = method_exists($user, 'profile_photo_url') ? $user->profile_photo_url : null;
  $photoUrl = $photoUrl ?: $mkUrl($photoRaw);
@endphp

<div class="container">
  {{-- ===== HERO ===== --}}
  <header class="hero">
    <div class="hero-cover"></div>
    <div class="hero-inner">
      <div class="hero-logo">
        @if($logoUrl)
          <img src="{{ $logoUrl }}" alt="Logo Perusahaan">
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

 

    </div>
  </header>

  {{-- ===== GRID ===== --}}
  <div class="cards-grid">

    {{-- === Informasi HRD (PIC) === --}}
    <div class="card">
      <div class="card-header"><h3>Informasi HRD</h3></div>
      <div class="card-body">
        <div class="pic-header"><i class="fas fa-user-circle"></i><span>Foto Profil</span></div>

        <div class="pic-avatar">
          @if($photoUrl)
            <img
              src="{{ $photoUrl }}"
              alt="Foto Profil"
              class="profile-pic"
              role="button"
              aria-label="Perbesar foto profil"
              onclick="openPhotoModal('{{ $photoUrl }}')"
            >
          @else
            <div class="avatar-fallback"><i class="fas fa-user"></i></div>
          @endif
        </div>

        <div class="pic-details">
          <p><strong>Nama:</strong> {{ $user->name }}</p>
          <p><strong>Email:</strong> {{ $user->email }}</p>
          <p><strong>No. HP:</strong> {{ $user->phone ?? '-' }}</p>
          <p><strong>Alamat:</strong> {{ $user->address ?? '-' }}</p>
        </div>
      </div>
    </div>

    {{-- === Informasi Perusahaan === --}}
    <div class="card mb-4">
      <div class="card-header"><h3>Informasi Perusahaan</h3></div>
      <div class="card-body">
        <p><strong>Nama Perusahaan:</strong> {{ $company->name ?? '-' }}</p>
        <p><strong>Alamat Perusahaan:</strong> {{ $company->address ?? '-' }}</p>
        <p><strong>No. Telp Perusahaan:</strong> {{ $company->phone ?? '-' }}</p>
        <p><strong>Email Kontak:</strong> {{ $company->email ?? '-' }}</p>
      </div>
    </div>

  </div>
</div>

  <div class="company-edit">
  <a href="{{ route('profile.edit') }}" class="btn-edit">
    <i class="fas fa-pen"></i> Edit Profil
  </a>
</div>


{{-- ===== MODAL GALERI (satu-satunya) ===== --}}
<div id="photoModal" class="ph-modal" aria-hidden="true" style="display:none">
  <div class="ph-backdrop"></div>

  <div class="ph-toolbar">
    <button class="ph-btn" title="Perkecil (−)" onclick="phZoom(-1)"><i class="fas fa-minus"></i></button>
    <button class="ph-btn" title="Perbesar (+)" onclick="phZoom(1)"><i class="fas fa-plus"></i></button>
    <span class="ph-sep"></span>
    <button class="ph-btn" title="Putar 90°" onclick="phRotate()"><i class="fas fa-undo"></i></button>
    <span class="ph-sep"></span>
    <a class="ph-btn" id="phDownload" title="Download" download><i class="fas fa-download"></i></a>
  </div>

  <button class="ph-close" aria-label="Tutup (Esc)" onclick="closePhotoModal()">
    <i class="fas fa-times"></i>
  </button>

  <div class="ph-stage" id="phStage">
    <div class="ph-loader" id="phLoader"></div>
    <img id="phImg" alt="Foto Profil">
  </div>
</div>

{{-- ===== JS Interaksi Modal ===== --}}
<script>
  let phState = { scale: 1, rotate: 0, dragging: false, startX: 0, startY: 0, originX: 0, originY: 0 };

  function openPhotoModal(url) {
    const modal = document.getElementById('photoModal');
    const img   = document.getElementById('phImg');
    const loader= document.getElementById('phLoader');
    const dl    = document.getElementById('phDownload');

    // reset state
    phState = { scale: 1, rotate: 0, dragging: false, startX: 0, startY: 0, originX: 0, originY: 0 };
    img.style.transform = 'translate(0px,0px) scale(1) rotate(0deg)';
    img.src = ''; loader.style.display = 'block'; dl.href = url;

    modal.style.display = 'grid';
    document.body.style.overflow = 'hidden';

    img.onload  = () => loader.style.display = 'none';
    img.onerror = () => { loader.style.display = 'none'; closePhotoModal(); };
    img.src = url;
  }

  function closePhotoModal() {
    document.getElementById('photoModal').style.display = 'none';
    document.body.style.overflow = '';
  }

  // Tutup via backdrop & ESC
  document.querySelector('#photoModal .ph-backdrop').addEventListener('click', closePhotoModal);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closePhotoModal(); });

  // Zoom
  function phZoom(dir){
    const img = document.getElementById('phImg');
    phState.scale = Math.max(0.2, Math.min(6, phState.scale + (dir>0?0.2:-0.2)));
    img.style.transform = `translate(${phState.originX}px,${phState.originY}px) scale(${phState.scale}) rotate(${phState.rotate}deg)`;
  }

  // Rotate
  function phRotate(){
    const img = document.getElementById('phImg');
    phState.rotate = (phState.rotate + 90) % 360;
    img.style.transform = `translate(${phState.originX}px,${phState.originY}px) scale(${phState.scale}) rotate(${phState.rotate}deg)`;
  }

  // Dblclick zoom toggle
  document.getElementById('phStage').addEventListener('dblclick',()=>phZoom(phState.scale<2?1:-1));

  // Drag-to-pan
  const phImgEl=document.getElementById('phImg');
  phImgEl.addEventListener('mousedown',e=>{
    phState.dragging=true;
    phState.startX=e.clientX-phState.originX;
    phState.startY=e.clientY-phState.originY;
    phImgEl.style.cursor='grabbing';
  });
  window.addEventListener('mousemove',e=>{
    if(!phState.dragging) return;
    phState.originX=e.clientX-phState.startX;
    phState.originY=e.clientY-phState.startY;
    phImgEl.style.transform=
      `translate(${phState.originX}px,${phState.originY}px) scale(${phState.scale}) rotate(${phState.rotate}deg)`;
  });
  window.addEventListener('mouseup',()=>{phState.dragging=false;phImgEl.style.cursor='grab';});

  // Scroll to zoom
  document.getElementById('phStage').addEventListener('wheel',e=>{
    e.preventDefault(); phZoom(e.deltaY<0?1:-1)
  },{passive:false});
</script>
@endsection

@push('scripts')
<script src="{{ asset('js/profile.js') }}" defer></script>
@endpush
