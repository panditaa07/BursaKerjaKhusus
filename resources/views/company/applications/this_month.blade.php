@extends('layouts.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pelamarbulaninicom.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Pelamar Bulan Ini</h2>
        <div class="d-flex align-items-center">
            <a href="{{ route('company.pelamar.all') }}" class="btn btn-primary me-3">
                <i class="fas fa-list me-2"></i> Lihat Semua Pelamar
            </a>
            <div class="text-muted fw-semibold">
                <i class="fas fa-users me-2 text-primary"></i>
                Total Pelamar: <strong>{{ $applications->total() }}</strong>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('company.applications.this_month') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control search-bar" 
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
    </form>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="company-applications-table mb-0">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Lowongan yang Dilamar</th>
                            <th width="160">Status</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                            <tr>
                                <td>{{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-wrapper me-3">
                                            @if($application->user->profile_photo_path)
                                                <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}" 
                                                     width="40" height="40" alt="Avatar">
                                            @else
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px; font-size: 14px; font-weight: bold;">
                                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $application->user->name }}</div>
                                            <small class="text-muted">ID: {{ $application->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    {{ $application->user->email }}
                                </td>
                                <td>
                                    <i class="fas fa-phone text-muted me-2"></i>
                                    {{ $application->user->phone ?? '-' }}
                                </td>
                                <td>
                                    <i class="fas fa-briefcase text-muted me-2"></i>
                                    {{ $application->jobPost->title ?? 'N/A' }}
                                </td>
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
                                    <span class="badge {{ $currentStatus['class'] }} px-3 py-2">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                        {{ $currentStatus['label'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <!-- View -->
                                        <a href="{{ route('company.applications.show.company', $application->id) }}" 
                                           class="btn-icon view" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn-icon edit dropdown-toggle" 
                                                    type="button" 
                                                    id="dropdownMenuButton{{ $application->id }}" 
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton{{ $application->id }}">
                                                @foreach ([
                                                    'submitted' => ['icon' => 'fa-clock', 'label' => 'Submitted'],
                                                    'test1'     => ['icon' => 'fa-flask', 'label' => 'Test 1'],
                                                    'test2'     => ['icon' => 'fa-flask', 'label' => 'Test 2'],
                                                    'interview' => ['icon' => 'fa-user-tie', 'label' => 'Interview'],
                                                    'accepted'  => ['icon' => 'fa-check text-success', 'label' => 'Terima'],
                                                    'rejected'  => ['icon' => 'fa-times text-danger', 'label' => 'Tolak']
                                                ] as $st => $info)
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}"
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="{{ $st }}">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fa {{ $info['icon'] }} me-2"></i>{{ $info['label'] }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <!-- Delete -->
                                        <form action="{{ route('company.applications.destroy', $application->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus lamaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon delete" aria-label="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p class="mb-0">Belum ada lamaran bulan ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($applications->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $applications->links() }}
        </div>
    @endif
</div>

<!-- Custom JavaScript for dropdown functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure all dropdowns work properly
    if (typeof bootstrap !== 'undefined') {
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        dropdownElementList.map(function (el) { return new bootstrap.Dropdown(el); });
    } else {
        // Fallback
        document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                var dropdown = toggle.closest('.dropdown');
                var menu = dropdown.querySelector('.dropdown-menu');
                var isVisible = menu.style.display === 'block';
                menu.style.display = isVisible ? 'none' : 'block';
                document.querySelectorAll('.dropdown-menu').forEach(function(other) {
                    if (other !== menu) other.style.display = 'none';
                });
            });
        });
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.style.display = 'none';
                });
            }
        });
    }
});
</script>
@endsection