@extends('layouts.dashboard')

@section('title', 'Detail Pelamar')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/detailpelamarcom.css') }}">
@endpush

@section('content')
<div class="container">

  {{-- HERO SECTION --}}
  <section class="hero">
    <div class="hero-cover"></div>
    <div class="hero-inner">
      <div class="hero-logo">
        @if($application->user && $application->user->profile_photo_path)
          <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}" alt="Foto Profil">
        @else
          <div class="hero-logo-fallback">
            <i class="fas fa-user"></i>
          </div>
        @endif
      </div>
      <div class="hero-title">
        <h1>{{ $application->user ? $application->user->name : 'N/A' }}</h1>
        <div class="hero-meta">
          <span class="chip"><i class="fas fa-user-tag"></i>Pelamar</span>
          <span class="chip"><i class="fas fa-envelope"></i>{{ $application->user ? $application->user->email : '-' }}</span>
          <span class="chip"><i class="fas fa-phone"></i>{{ $application->user ? ($application->user->phone ?? 'No. HP belum diisi') : '-' }}</span>
          <span class="chip"><i class="fas fa-calendar"></i>{{ $application->created_at->format('d M Y') }}</span>
        </div>
      </div>
    </div>
  </section>

  {{-- GRID SECTION --}}
  <section class="cards-grid">
    {{-- Informasi Personal --}}
    <article class="card">
      <header class="card-head">
        <h3><i class="fas fa-user-shield"></i> Informasi Personal</h3>
      </header>
      <div class="card-body grid-2">
        <dl class="kv">
          <dt>Nama Lengkap</dt>
          <dd>{{ $application->user ? $application->user->name : '-' }}</dd>
          <dt>Email</dt>
          <dd>{{ $application->user ? $application->user->email : '-' }}</dd>
          <dt>No HP</dt>
          <dd>{{ $application->user ? $application->user->phone ?? '-' : '-' }}</dd>
          <dt>Alamat</dt>
          <dd>{{ $application->user ? $application->user->address ?? '-' : '-' }}</dd>
        </dl>
        <dl class="kv">
          <dt>NIK/NISN</dt>
          <dd>{{ $application->user ? $application->user->nisn ?? '-' : '-' }}</dd>
          <dt>Tanggal Lahir</dt>
          <dd>
            {{ $application->user && $application->user->birth_date 
                ? \Carbon\Carbon::parse($application->user->birth_date)->format('d M Y') 
                : '-' }}
          </dd>
          <dt>Profil Singkat</dt>
          <dd>{{ $application->user ? $application->user->short_profile ?? '-' : '-' }}</dd>
        </dl>
      </div>
    </article>

    {{-- Informasi Lamaran --}}
    <article class="card">
      <header class="card-head">
        <h3><i class="fas fa-file-alt"></i> Informasi Lamaran</h3>
      </header>
      <div class="card-body grid-2">
        <dl class="kv">
          <dt>Lowongan</dt>
          <dd>{{ $application->jobPost->title ?? '-' }}</dd>
          <dt>Perusahaan</dt>
          <dd>{{ $application->jobPost->company->name ?? '-' }}</dd>
          <dt>Tanggal Lamar</dt>
          <dd>{{ $application->created_at->format('d M Y H:i') }}</dd>
        </dl>
        <dl class="kv">
          <dt>Status Lamaran</dt>
          <dd>
            @php
              $status = $application->status;
              $statusConfig = [
                'accepted'  => ['label' => 'Diterima',  'class' => 'badge-enhanced bg-success'],
                'rejected'  => ['label' => 'Ditolak',   'class' => 'badge-enhanced bg-danger'],
                'interview' => ['label' => 'Wawancara', 'class' => 'badge-enhanced bg-info'],
                'test1'     => ['label' => 'Test 1',    'class' => 'badge-enhanced bg-warning'],
                'test2'     => ['label' => 'Test 2',    'class' => 'badge-enhanced bg-primary'],
                'submitted' => ['label' => 'Menunggu',  'class' => 'badge-enhanced bg-secondary'],
                'reviewed'  => ['label' => 'Ditinjau',  'class' => 'badge-enhanced bg-info'],
              ];
              $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'badge-enhanced bg-secondary'];
            @endphp
            <span class="{{ $currentStatus['class'] }}">
              {{ $currentStatus['label'] }}
            </span>
          </dd>
          <dt>ID Lamaran</dt>
          <dd>#{{ $application->id }}</dd>
        </dl>
      </div>
      @if($application->description)
        <div class="card-body">
          <h4 class="mb-3"><i class="fas fa-align-left"></i> Deskripsi Lamaran</h4>
          <div class="prose">
            {{ $application->description }}
          </div>
        </div>
      @endif
    </article>

    {{-- Dokumen & Berkas --}}
    <article class="card">
      <header class="card-head">
        <h3><i class="fas fa-file-download"></i> Dokumen & Berkas</h3>
      </header>
      <div class="card-body">
        <div class="grid-2">
          <div>
            <h4 class="mb-3"> Surat Lamaran</h4>
            @if($application->cover_letter_path || ($application->user && $application->user->cover_letter_path))
              <div class="d-flex gap-2 mb-3">
                <a href="{{ route('company.applications.preview-cover-letter', $application->id) }}" 
                   target="_blank" class="btn btn-info">
                  <i class="fas fa-eye"></i> Lihat
                </a>
                <a href="{{ route('company.applications.download-cover-letter', $application->id) }}" 
                   target="_blank" class="btn btn-primary" download>
                  <i class="fas fa-download"></i> Download
                </a>
              </div>
            @else
              <p class="text-muted">Tidak ada surat lamaran</p>
            @endif
          </div>
          <div>
            <h4 class="mb-3"> Curriculum Vitae</h4>
            @if($application->cv_path || ($application->user && $application->user->cv_path))
              <div class="d-flex gap-2 mb-3">
                <a href="{{ route('company.applications.preview', $application->id) }}" 
                   target="_blank" class="btn btn-info">
                  <i class="fas fa-eye"></i> Lihat
                </a>
                <a href="{{ route('company.applications.download', $application->id) }}" 
                   target="_blank" class="btn btn-primary" download>
                  <i class="fas fa-download"></i> Download
                </a>
              </div>
            @else
              <p class="text-muted">Tidak ada CV</p>
            @endif
          </div>
        </div>
      </div>
    </article>

    {{-- Sosial Media & Portfolio --}}
    @if($application->user && ($application->user->portfolio_link || $application->user->facebook || $application->user->instagram || $application->user->linkedin || $application->user->twitter || $application->user->tiktok))
      <article class="card">
        <header class="card-head">
          <h3><i class="fas fa-share-alt"></i> Sosial Media & Portfolio</h3>
        </header>
        <div class="card-body">
          <div class="d-flex flex-wrap gap-3">
            @if($application->user->portfolio_link)
              <a href="{{ $application->user->portfolio_link }}" target="_blank" class="link">
                <i class="fas fa-globe me-2"></i>Portfolio
              </a>
            @endif
            @if($application->user->facebook)
              <a href="{{ $application->user->facebook }}" target="_blank" class="link">
                <i class="fab fa-facebook me-2"></i>Facebook
              </a>
            @endif
            @if($application->user->instagram)
              <a href="{{ $application->user->instagram }}" target="_blank" class="link">
                <i class="fab fa-instagram me-2"></i>Instagram
              </a>
            @endif
            @if($application->user->linkedin)
              <a href="{{ $application->user->linkedin }}" target="_blank" class="link">
                <i class="fab fa-linkedin me-2"></i>LinkedIn
              </a>
            @endif
            @if($application->user->twitter)
              <a href="{{ $application->user->twitter }}" target="_blank" class="link">
                <i class="fab fa-twitter me-2"></i>Twitter
              </a>
            @endif
            @if($application->user->tiktok)
              <a href="{{ $application->user->tiktok }}" target="_blank" class="link">
                <i class="fab fa-tiktok me-2"></i>TikTok
              </a>
            @endif
          </div>
        </div>
      </article>
    @endif

    {{-- Update Status --}}
    <article class="card">
      <header class="card-head">
        <h3><i class="fas fa-edit"></i> Update Status Lamaran</h3>
      </header>
      <div class="card-body">
        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label class="form-label fw-bold mb-3">Status Baru:</label>
            <select name="status" class="form-select" required style="padding: 12px; border-radius: 12px; border: 2px solid #e2e8f0;">
              <option value="">Pilih Status</option>
              <option value="reviewed"  {{ $application->status == 'reviewed' ? 'selected' : '' }}>Ditinjau</option>
              <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Wawancara</option>
              <option value="test1"     {{ $application->status == 'test1' ? 'selected' : '' }}>Test 1</option>
              <option value="test2"     {{ $application->status == 'test2' ? 'selected' : '' }}>Test 2</option>
              <option value="accepted"  {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
              <option value="rejected"  {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100" style="padding: 12px; border-radius: 12px; font-weight: 600;">
            <i class="fas fa-save me-2"></i> Update Status
          </button>
        </form>
      </div>
    </article>
  </section>

  {{-- Tombol Kembali (bawah kiri) --}}
  <div class="text-start mt-4 mb-4">
    <a href="{{ route('company.pelamar.all') }}" class="btn btn-custom back">
      <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
    </a>
  </div>

</div>

<script>
function showNoCoverLetterAlert(){ 
  alert('Pelamar tidak mencantumkan surat lamaran.'); 
}
</script>
@endsection
