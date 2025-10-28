@extends('layouts.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/kelolapelamarcom.css') }}">
@endpush

@section('content')
<div class="container-fluid kelola-pelamar">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="page-title mb-0">Semua Pelamar</h2>
        <div class="d-flex align-items-center flex-wrap gap-2">
            {{-- Total Pelamar SAMA PERSIS seperti di Kelola Lowongan Kerja --}}
            <span class="btn-total">
                <i class="fas fa-users me-1"></i> Total Pelamar : {{ $applications->total() }}
            </span>
            <a href="{{ route('company.applications.this_month') }}" class="btn btn-primary">
                <i class="fas fa-calendar-alt me-2"></i> Pelamar Bulan Ini
            </a>
        </div>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('company.pelamar.all') }}" class="mb-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="input-group search-hero">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari pelamar berdasarkan nama, lowongan, atau status..."
                        value="{{ request('search') }}"
                    >
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('company.pelamar.all') }}" class="btn btn-outline-secondary reset-btn">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <!-- Filter -->
    <div class="mb-3 d-flex flex-wrap gap-2">
        <a href="{{ route('company.pelamar.all', array_merge(request()->query(), ['filter' => 'new'])) }}"
           class="btn {{ request('filter') === 'new' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-user-plus me-2"></i> Pelamar Baru
        </a>
        <a href="{{ route('company.pelamar.all', array_merge(request()->query(), ['filter' => 'process'])) }}"
           class="btn {{ request('filter') === 'process' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-cogs me-2"></i> Pelamar Dalam Proses
        </a>
        <a href="{{ route('company.pelamar.all', array_merge(request()->query(), ['filter' => 'all'])) }}"
           class="btn {{ !request('filter') || request('filter') === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-users me-2"></i> Total Pelamar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabel -->
    <div class="card shadow-sm company-applications-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="56">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Hp</th>
                            <th>Lowongan yang Dilamar</th>
                            <th width="120" class="text-center">Status</th>
                            <th width="220" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                        <tr>
                            <td class="text-center text-muted fw-bold">
                                {{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper me-3">
                                        @if($application->user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}" width="36" height="36" class="rounded-circle" alt="">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width:36px;height:36px;font-size:13px;font-weight:700;">
                                                {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $application->user->name }}</div>
                                        <small class="text-muted">ID: {{ $application->id }}</small>
                                    </div>
                                </div>
                            </td>

                            <td><i class="fas fa-envelope text-muted me-2"></i>{{ $application->user->email }}</td>
                            <td><i class="fas fa-phone text-muted me-2"></i>{{ $application->user->phone ?? '-' }}</td>
                            <td><i class="fas fa-briefcase text-muted me-2"></i>{{ $application->jobPost->title ?? 'N/A' }}</td>

                            <td class="text-center">
                                @php
                                    $status = $application->status;
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
                                <span class="badge {{ $currentStatus['class'] }}">
                                    <i class="fas fa-circle me-1" style="font-size:8px;"></i>{{ $currentStatus['label'] }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="aksi-wrapper">
                                    <a href="{{ route('company.applications.show.company', $application->id) }}" class="action-text view">Lihat</a>

                                    <!-- Dropdown Aksi -->
                                    <div class="dropdown">
                                      <button
                                        class="action-text edit dropdown-toggle"
                                        type="button"
                                        id="dd-{{ $application->id }}"
                                        data-bs-toggle="dropdown"
                                        data-bs-boundary="viewport"
                                        data-bs-reference="parent"
                                        data-bs-offset="0,8"
                                        data-bs-display="static"
                                        aria-expanded="false">
                                        Edit
                                      </button>

                                      <ul class="dropdown-menu status-menu" aria-labelledby="dd-{{ $application->id }}">
                                        @foreach ([
                                          'submitted' => ['icon' => 'far fa-clock', 'label' => 'Submitted'],
                                          'test1'     => ['icon' => 'fas fa-flask', 'label' => 'Test 1'],
                                          'test2'     => ['icon' => 'fas fa-flask', 'label' => 'Test 2', 'divider_after' => true],
                                          'interview' => ['icon' => 'fas fa-user-tie', 'label' => 'Interview', 'divider_after' => true],
                                          'accepted'  => ['icon' => 'fas fa-check', 'label' => 'Terima', 'btn_class' => 'text-success'],
                                          'rejected'  => ['icon' => 'fas fa-times', 'label' => 'Tolak', 'btn_class' => 'text-danger'],
                                        ] as $value => $opt)
                                          @php
                                            $isActive = ($value === $application->status);
                                            $btnClasses = trim('opt-'.$value.' '.($opt['btn_class'] ?? '').' '.($isActive ? 'is-active' : ''));
                                          @endphp
                                          <li>
                                            @if($isActive)
                                              <div class="dropdown-item {{ $btnClasses }}" aria-current="true">
                                                <i class="status-icon {{ $opt['icon'] }}"></i>
                                                {{ $opt['label'] }}
                                                <span class="tick ms-auto"><i class="fas fa-check"></i></span>
                                              </div>
                                            @else
                                              <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline w-100">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ $value }}">
                                                <button type="submit" class="dropdown-item {{ $btnClasses }} w-100 text-start border-0 bg-transparent">
                                                  <i class="status-icon {{ $opt['icon'] }}"></i> {{ $opt['label'] }}
                                                </button>
                                              </form>
                                            @endif
                                          </li>
                                          @if(!empty($opt['divider_after'])) <li><hr class="dropdown-divider my-1"></li> @endif
                                        @endforeach
                                      </ul>
                                    </div>

                                    <form action="{{ route('company.applications.destroy', $application->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus lamaran ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-text delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i><br>Belum ada lamaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($applications->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $applications->links() }}
        </div>
    @endif
</div>

<!-- Script tetap sama -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const tableCard = document.querySelector('.company-applications-table');
  const dropdowns  = document.querySelectorAll('.company-applications-table .dropdown');

  function addBackdrop(dropdownEl){
    if (window.innerWidth > 768) return;
    const backdrop = document.createElement('div');
    backdrop.className = 'dropdown-backdrop';
    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', () => {
      const inst = bootstrap.Dropdown.getInstance(
        dropdownEl.querySelector('[data-bs-toggle="dropdown"]')
      );
      inst && inst.hide();
    });
    document.body.style.overflow = 'hidden';
  }
  function removeBackdrop(){
    const bd = document.querySelector('.dropdown-backdrop');
    if (bd) bd.remove();
    document.body.style.overflow = '';
  }

  dropdowns.forEach(dd => {
    dd.addEventListener('show.bs.dropdown', () => {
      tableCard && tableCard.classList.add('dropdown-active');
      const td = dd.closest('td');
      td && td.classList.add('dropdown-open');
      addBackdrop(dd);
    });

    dd.addEventListener('hide.bs.dropdown', () => {
      tableCard && tableCard.classList.remove('dropdown-active');
      const td = dd.closest('td');
      td && td.classList.remove('dropdown-open');
      removeBackdrop();
    });
  });

  window.addEventListener('resize', removeBackdrop);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const tableCard = document.querySelector('.company-applications-table');
  const dropdowns  = document.querySelectorAll('.company-applications-table .dropdown');

  function addBackdrop(dropdownEl){
    if (window.innerWidth > 768) return;
    const backdrop = document.createElement('div');
    backdrop.className = 'dropdown-backdrop';
    document.body.appendChild(backdrop);
    backdrop.addEventListener('click', () => {
      const inst = bootstrap.Dropdown.getInstance(
        dropdownEl.querySelector('[data-bs-toggle="dropdown"]')
      );
      inst && inst.hide();
    });
    document.body.style.overflow = 'hidden';
  }
  function removeBackdrop(){
    const bd = document.querySelector('.dropdown-backdrop');
    if (bd) bd.remove();
    document.body.style.overflow = '';
  }

  function placePortal(menu, toggle){
    const r = toggle.getBoundingClientRect();
    // Simpan parent asal
    menu.__origin = menu.__origin || menu.parentElement;
    // Pindah ke body
    document.body.appendChild(menu);
    // Gunakan posisi fixed agar lepas dari semua stacking context
    Object.assign(menu.style, {
      position: 'fixed',
      left: (r.left) + 'px',
      top:  (r.bottom + 8) + 'px',
      zIndex: 2147483647,
      transform: 'none',
      willChange: 'auto'
    });
    menu.classList.add('dropdown-menu-portal');
  }

  function restorePortal(menu){
    if (menu && menu.__origin) {
      menu.__origin.appendChild(menu);
      menu.removeAttribute('style');
      menu.classList.remove('dropdown-menu-portal');
    }
  }

  // Reposisi saat scroll/resize
  let currentToggle = null, currentMenu = null;
  function repro(){
    if (!currentToggle || !currentMenu) return;
    placePortal(currentMenu, currentToggle);
  }
  window.addEventListener('scroll', repro, true);
  window.addEventListener('resize', repro);

  dropdowns.forEach(dd => {
    const toggle = dd.querySelector('[data-bs-toggle="dropdown"]');
    const menu = dd.querySelector('.dropdown-menu');

    dd.addEventListener('show.bs.dropdown', () => {
      tableCard && tableCard.classList.add('dropdown-active');
      const td = dd.closest('td');
      const tr = dd.closest('tr');
      td && td.classList.add('dropdown-open');
      tr && tr.classList.add('row-locked');

      placePortal(menu, toggle);
      currentToggle = toggle;
      currentMenu = menu;
      addBackdrop(dd);
    });

    dd.addEventListener('hide.bs.dropdown', () => {
      tableCard && tableCard.classList.remove('dropdown-active');
      const td = dd.closest('td');
      const tr = dd.closest('tr');
      td && td.classList.remove('dropdown-open');
      tr && tr.classList.remove('row-locked');

      restorePortal(menu);
      currentToggle = null;
      currentMenu = null;
      removeBackdrop();
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const dropdowns = document.querySelectorAll('.company-applications-table .dropdown');
  let currentToggle=null, currentMenu=null;

  function portal(menu, toggle){
    const r = toggle.getBoundingClientRect();
    // pindahkan node asli ke body (bukan clone)
    menu.__origin = menu.__origin || menu.parentElement;
    document.body.appendChild(menu);
    // posisikan tepat di bawah tombol
    Object.assign(menu.style, {
      position: 'fixed',
      left: r.left + 'px',
      top: (r.bottom + 8) + 'px',
      zIndex: 2147483647,
      transform: 'none',
      willChange: 'auto'
    });
    menu.classList.add('dropdown-menu-portal');
  }
  function restore(menu){
    if (menu && menu.__origin){
      menu.__origin.appendChild(menu);
      menu.removeAttribute('style');
      menu.classList.remove('dropdown-menu-portal');
    }
  }
  function repro(){ if(currentToggle && currentMenu){ portal(currentMenu, currentToggle); } }
  window.addEventListener('scroll', repro, true);
  window.addEventListener('resize', repro);

  dropdowns.forEach(dd => {
    const toggle = dd.querySelector('[data-bs-toggle="dropdown"]');
    const menu = dd.querySelector('.dropdown-menu');

    dd.addEventListener('show.bs.dropdown', () => {
      const td = dd.closest('td'); const tr = dd.closest('tr');
      td && td.classList.add('dropdown-open');
      tr && tr.classList.add('row-locked');
      portal(menu, toggle);
      currentToggle = toggle; currentMenu = menu;
    });

    dd.addEventListener('hide.bs.dropdown', () => {
      const td = dd.closest('td'); const tr = dd.closest('tr');
      td && td.classList.remove('dropdown-open');
      tr && tr.classList.remove('row-locked');
      restore(menu);
      currentToggle = null; currentMenu = null;
    });
  });
});
</script>

@endsection