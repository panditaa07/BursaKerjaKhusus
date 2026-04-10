@extends('layouts.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pelamarbulaninicom.css') }}">
@endpush

@section('content')
<div class="container-fluid pelamar-bulan-ini">

    {{-- ====== HEADER ====== --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="page-title mb-0">Pelamar Bulan Ini</h2>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <span class="btn-total">
                <i class="fas fa-users me-1"></i> Pelamar Bulan Ini : {{ $applications->total() }}
            </span>
            <a href="{{ route('company.pelamar.all') }}" class="btn btn-primary">
                <i class="fas fa-list me-2"></i> Lihat Semua Pelamar
            </a>
        </div>
    </div>

    {{-- ====== SEARCH ====== --}}
    <form method="GET" action="{{ route('company.applications.this_month') }}" class="mb-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="search-hero">
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari pelamar berdasarkan nama, lowongan, atau status..."
                            value="{{ request('search') }}"
                        >
                        <button class="btn btn-secondary" type="submit">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('company.applications.this_month') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- ====== ALERT ====== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ====== TABEL ====== --}}
    <div class="card shadow-sm company-applications-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="56">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Lowongan yang Dilamar</th>
                            <th width="120" class="text-center">Status</th>
                            <th width="220" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                        <tr>
                            {{-- No --}}
                            <td class="text-center text-muted fw-bold">
                                {{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}
                            </td>

                            {{-- Nama --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-wrapper me-3">
                                        @if($application->user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}"
                                                 width="36" height="36" class="rounded-circle" alt="">
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

                            {{-- Email --}}
                            <td>
                                <i class="fas fa-envelope text-muted me-2"></i>{{ $application->user->email }}
                            </td>

                            {{-- No HP --}}
                            <td>
                                <i class="fas fa-phone text-muted me-2"></i>{{ $application->user->phone ?? '-' }}
                            </td>

                            {{-- Lowongan --}}
                            <td>
                                <i class="fas fa-briefcase text-muted me-2"></i>{{ $application->jobPost->title ?? 'N/A' }}
                            </td>

                            {{-- Status --}}
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

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="aksi-wrapper">
                                    {{-- Lihat --}}
                                    <a href="{{ route('company.applications.show.company', $application->id) }}"
                                       class="action-text view">Lihat</a>

                                    {{-- Dropdown Edit Status --}}
                                    <div class="dropdown">
                                        <button
                                            class="action-text edit dropdown-toggle"
                                            type="button"
                                            id="dd-{{ $application->id }}"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Edit
                                        </button>

                                        <ul class="dropdown-menu status-menu" aria-labelledby="dd-{{ $application->id }}">
                                            @foreach ([
                                                'submitted' => ['icon' => 'far fa-clock',    'label' => 'Submitted'],
                                                'test1'     => ['icon' => 'fas fa-flask',    'label' => 'Test 1'],
                                                'test2'     => ['icon' => 'fas fa-flask',    'label' => 'Test 2',    'divider_after' => true],
                                                'interview' => ['icon' => 'fas fa-user-tie', 'label' => 'Interview', 'divider_after' => true],
                                                'accepted'  => ['icon' => 'fas fa-check',    'label' => 'Terima',    'btn_class' => 'opt-accepted'],
                                                'rejected'  => ['icon' => 'fas fa-times',    'label' => 'Tolak',     'btn_class' => 'opt-rejected'],
                                            ] as $value => $opt)
                                                @php
                                                    $isActive   = ($value === $application->status);
                                                    $btnClasses = trim('opt-' . $value . ' ' . ($opt['btn_class'] ?? '') . ' ' . ($isActive ? 'is-active' : ''));
                                                @endphp
                                                <li>
                                                    @if($isActive)
                                                        <div class="dropdown-item {{ $btnClasses }}" aria-current="true">
                                                            <i class="status-icon {{ $opt['icon'] }}"></i>
                                                            {{ $opt['label'] }}
                                                            <span class="tick ms-auto"><i class="fas fa-check"></i></span>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}"
                                                              method="POST" class="d-inline w-100">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="{{ $value }}">
                                                            <button type="submit"
                                                                    class="dropdown-item {{ $btnClasses }} w-100 text-start border-0 bg-transparent">
                                                                <i class="status-icon {{ $opt['icon'] }}"></i>
                                                                {{ $opt['label'] }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                </li>
                                                @if(!empty($opt['divider_after']))
                                                    <li><hr class="dropdown-divider my-1"></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>

                                    {{-- Hapus --}}
                                    <form action="{{ route('company.applications.destroy', $application->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus lamaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-text delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Belum ada lamaran bulan ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ====== PAGINATION ====== --}}
    @if($applications->hasPages())
        <div class="d-flex justify-content: center mt-3">
            {{ $applications->links() }}
        </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.company-applications-table .dropdown').forEach(function (dropdown) {
        var btn  = dropdown.querySelector('.dropdown-toggle');
        var menu = dropdown.querySelector('.dropdown-menu');
        if (!btn || !menu) return;

        dropdown.addEventListener('shown.bs.dropdown', function () {
            // Pindah menu ke body agar lepas dari overflow:hidden parent
            document.body.appendChild(menu);

            var rect  = btn.getBoundingClientRect();
            var menuH = menu.offsetHeight;
            var menuW = menu.offsetWidth;

            var topPos  = (window.innerHeight - rect.bottom >= menuH)
                          ? rect.bottom + 5
                          : rect.top - menuH - 5;

            var leftPos = Math.min(rect.left, window.innerWidth - menuW - 8);

            // Clamp vertikal
            topPos = Math.max(8, Math.min(topPos, window.innerHeight - menuH - 8));

            Object.assign(menu.style, {
                position : 'fixed',
                top      : topPos + 'px',
                left     : leftPos + 'px',
                transform: 'none',
                margin   : '0',
                zIndex   : '99999',
                display  : 'block'
            });

            // Backdrop mobile
            if (window.innerWidth <= 768) {
                var bd = document.createElement('div');
                bd.className = 'dropdown-backdrop';
                document.body.appendChild(bd);
                document.body.style.overflow = 'hidden';
                bd.addEventListener('click', function () {
                    var inst = bootstrap.Dropdown.getInstance(btn);
                    if (inst) inst.hide();
                });
            }
        });

        dropdown.addEventListener('hidden.bs.dropdown', function () {
            // Kembalikan menu ke dropdown parent semula
            dropdown.appendChild(menu);
            menu.removeAttribute('style');

            var bd = document.querySelector('.dropdown-backdrop');
            if (bd) bd.remove();
            document.body.style.overflow = '';
        });
    });
});
</script>

@endsection