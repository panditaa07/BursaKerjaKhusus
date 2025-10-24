@extends('layouts.dashboard')

<link href="{{ asset('css/dashboardcompany.css') }}" rel="stylesheet">

@section('content')
  {{-- === Statistics Cards === --}}
  <div class="row">
    {{-- Total Pelamar --}}
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('company.pelamar.all') }}" class="stat-link">
        <div class="card stat-card border-left-primary shadow h-100 py-2">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pelamar</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">
                {{ $statistics['total_applications'] ?? 0 }}
              </div>
            </div>
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- Pelamar Bulan Ini --}}
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('company.applications.this_month') }}" class="stat-link">
        <div class="card stat-card border-left-success shadow h-100 py-2">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pelamar Bulan Ini</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">
                {{ $statistics['applications_this_month'] ?? 0 }}
              </div>
            </div>
            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- Lowongan Aktif --}}
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('company.jobs.active') }}" class="stat-link">
        <div class="card stat-card border-left-info shadow h-100 py-2">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lowongan Aktif</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">
                {{ $statistics['active_jobs'] ?? 0 }}
              </div>
            </div>
            <i class="fas fa-briefcase fa-2x text-gray-300"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- Lowongan Tidak Aktif --}}
    <div class="col-xl-3 col-md-6 mb-4">
      <a href="{{ route('company.jobs.inactive') }}" class="stat-link">
        <div class="card stat-card border-left-warning shadow h-100 py-2">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Lowongan Tidak Aktif</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">
                {{ $statistics['inactive_jobs'] ?? 0 }}
              </div>
            </div>
            <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
          </div>
        </div>
      </a>
    </div>
  </div>

  {{-- === Tabel Pelamar Terbaru === --}}
  <div class="container table-section">
    <h3 class="section-title">Pelamar Terbaru</h3>

    <table class="table-custom">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No Hp</th>
          <th>Lowongan</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentApplications as $index => $app)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $app->user->name ?? '-' }}</td>
            <td>{{ $app->user->email ?? '-' }}</td>
            <td>{{ $app->user->phone ?? '-' }}</td>
            <td>{{ $app->jobPost->title ?? '-' }}</td>
            <td>
              @php
                $status = $app->status;
                $statusConfig = [
                  'accepted'  => ['label' => 'Terima',    'class' => 'status-accepted'],
                  'rejected'  => ['label' => 'Tolak',     'class' => 'status-rejected'],
                  'interview' => ['label' => 'Wawancara', 'class' => 'status-interview'],
                  'test1'     => ['label' => 'Test 1',    'class' => 'status-test'],
                  'test2'     => ['label' => 'Test 2',    'class' => 'status-test2'],
                  'submitted' => ['label' => 'Menunggu',  'class' => 'status-pending'],
                  'reviewed'  => ['label' => 'Ditinjau',  'class' => 'status-reviewed'],
                ];
                $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-light text-dark'];
              @endphp
              <span class="badge {{ $currentStatus['class'] }} px-3 py-2">
                <i class="fas fa-circle me-1" style="font-size:8px;"></i>{{ $currentStatus['label'] }}
              </span>
            </td>
            <td>{{ $app->created_at->format('d-m-Y') }}</td>

    {{-- AKSI --}}
<td class="text-center">
  <div class="aksi-wrapper d-flex justify-content-center align-items-center">

    {{-- Lihat --}}
    <a href="{{ route('company.applicants.show', $app->id) }}" class="action-text view">Lihat</a>

    {{-- Edit (dropdown buka ke kiri) --}}
    <div class="dropdown dropstart position-static">
      <button
        class="action-text edit"
        type="button"
        id="dropdownMenuButton{{ $app->id }}"
        data-bs-toggle="dropdown"
        data-bs-display="static"
        data-bs-boundary="viewport"
        data-bs-reference="parent"
        aria-expanded="false">
        Edit
      </button>

      @php
        $statusMenu = [
          'submitted' => ['label' => 'Submitted', 'icon' => 'far fa-clock icon-submitted'],
          'test1'     => ['label' => 'Test 1',    'icon' => 'fas fa-flask icon-test'],
          'test2'     => ['label' => 'Test 2',    'icon' => 'fas fa-flask icon-test', 'divider_after' => true],
          'interview' => ['label' => 'Interview', 'icon' => 'fas fa-user-tie icon-interview', 'divider_after' => true],
          'accepted'  => ['label' => 'Terima',    'icon' => 'fas fa-check icon-accepted',  'btn_class' => 'text-success'],
          'rejected'  => ['label' => 'Tolak',     'icon' => 'fas fa-times icon-rejected',   'btn_class' => 'text-danger'],
        ];
      @endphp

      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $app->id }}">
        @foreach ($statusMenu as $value => $opt)
          @php
            $isActive = ($value === $status);
            $btnClasses = trim(($opt['btn_class'] ?? '') . ' ' . ($isActive ? 'is-active' : ''));
          @endphp
          <li>
            @if($isActive)
              {{-- Status aktif --}}
              <div class="dropdown-item {{ $btnClasses }}" aria-current="true">
                <i class="status-icon {{ $opt['icon'] }}"></i>
                {{ $opt['label'] }}
                <span class="tick"><i class="fas fa-check"></i></span>
              </div>
            @else
              {{-- Status lain --}}
              <form action="{{ route('company.applications.updateStatus', $app->id) }}"
                    method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="{{ $value }}">
                <button type="submit" class="dropdown-item {{ $btnClasses }}">
                  <i class="status-icon {{ $opt['icon'] }}"></i>
                  {{ $opt['label'] }}
                  <span class="tick"><i class="fas fa-check"></i></span>
                </button>
              </form>
            @endif
          </li>

          @if(!empty($opt['divider_after']))
            <li><hr class="dropdown-divider"></li>
          @endif
        @endforeach
      </ul>
    </div>

    {{-- Hapus --}}
    <form action="{{ route('company.applicants.destroy', $app->id) }}"
          method="POST" class="d-inline"
          onsubmit="return confirm('Yakin ingin menghapus pelamar ini?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="action-text delete">Hapus</button>
    </form>

  </div>
</td>

        @empty
          <tr><td colspan="8" class="text-center text-muted">Belum ada pelamar</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- === Lowongan Terbaru Cards === --}}
  <div class="container jobs-latest mt-4">  {{-- sebelumnya: <div class="container jobs-latest"> --}}

    <div class="jobs-header mb-4 text-center">
      <h3 class="section-title mb-0">Lowongan Terbaru</h3>
    </div>

    <div class="row g-3 g-md-4">
      @forelse($recentJobs as $job)
        @php
          $avatar = ($job->company && $job->company->user && $job->company->user->profile_photo_path)
                      ? asset('storage/' . $job->company->user->profile_photo_path)
                      : asset('images/placeholders/company-avatar.png');
        @endphp
        <div class="col-md-6 col-lg-4">
          <div class="jl-card">
            <div class="jl-accent"></div>

            <div class="jl-avatar js-preview"
                 data-image="{{ $avatar }}"
                 data-title="{{ $job->company->name ?? 'Logo Perusahaan' }}">
              <img src="{{ $avatar }}" alt="{{ $job->company->name ?? 'Company' }}"
                   class="img-thumbnail rounded-circle shadow-sm jl-avatar-img"
                   loading="lazy" decoding="async" fetchpriority="low">
            </div>

            <div class="jl-body">
              @if($job->created_at && $job->created_at->gt(now()->subDays(7)))
                <span class="jl-ribbon">Baru</span>
              @endif

              <div class="jl-company">{{ $job->company->name ?? 'N/A' }}</div>
              <a href="{{ route('company.jobs.show', $job->id) }}" class="jl-title">
                {{ $job->title ?? '-' }}
              </a>

              <div class="jl-meta">
                <span class="jl-salary"><i class="fas fa-wallet"></i>{{ $job->salary ?? 'Gaji tidak tersedia' }}</span>
                <span class="jl-time"><i class="fas fa-clock"></i>{{ $job->created_at->diffForHumans(null, true) }}</span>
              </div>

              <div class="jl-actions">
                <a href="{{ route('company.jobs.show', $job->id) }}" class="btn btn-info btn-sm">
                  <i class="fas fa-info-circle me-1"></i> Info
                </a>
                <a href="{{ route('company.jobs.edit', $job->id) }}" class="btn btn-warning btn-sm">
                  <i class="fas fa-pen-to-square me-1"></i> Edit
                </a>
                <form action="{{ route('company.jobs.destroy', $job->id) }}" method="POST"
                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                  @csrf @method('DELETE')
                  <input type="hidden" name="from" value="dashboard">
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt me-1"></i> Hapus
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted">Belum ada lowongan</div>
      @endforelse
    </div>
  </div>

  {{-- Modal Preview Logo --}}
  <div class="modal fade modal-zoom" id="jobImageModal" tabindex="-1" aria-labelledby="jobImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content jobs-modal">
        <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-header jobs-modal-header">
          <h5 class="modal-title" id="jobImageModalLabel">Preview</h5>
        </div>
        <div class="modal-body p-0">
          <div class="modal-image-frame">
            <img id="jobImageModalImg" src="" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // angka naik pada kartu statistik
  document.querySelectorAll('.stat-number').forEach(function (el) {
    var finalNumber = parseInt(el.textContent, 10);
    if (isNaN(finalNumber)) return;
    var current = 0, inc = Math.max(1, Math.ceil(finalNumber / 100));
    var t = setInterval(function () {
      current += inc;
      if (current >= finalNumber) { current = finalNumber; clearInterval(t); }
      el.textContent = current;
    }, 20);
  });

  // modal preview logo
  var modalEl = document.getElementById('jobImageModal');
  var modalImg = document.getElementById('jobImageModalImg');
  var modalTit = document.getElementById('jobImageModalLabel');
  if (modalEl && window.bootstrap && bootstrap.Modal) {
    var bsModal = new bootstrap.Modal(modalEl, { backdrop: true, keyboard: true });
    document.querySelectorAll('.jobs-latest .js-preview').forEach(function (el) {
      el.addEventListener('click', function () {
        modalImg.src = el.getAttribute('data-image');
        modalTit.textContent = el.getAttribute('data-title') || 'Logo Perusahaan';
        bsModal.show();
      });
    });
  }

  // efek reveal sederhana
  var targets = document.querySelectorAll('.stat-card, .table-section, .jl-card');
  targets.forEach(function (el, i) { el.classList.add('reveal'); el.style.setProperty('--delay', (Math.min(i * 0.06, .36)) + 's'); });
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('is-inview'); io.unobserve(e.target); }
      });
    }, { threshold: .15, rootMargin: '0px 0px -10% 0px' });
    targets.forEach(function (el) { io.observe(el); });
  } else {
    targets.forEach(function (el) { el.classList.add('is-inview'); });
  }
});
</script>
@endpush
