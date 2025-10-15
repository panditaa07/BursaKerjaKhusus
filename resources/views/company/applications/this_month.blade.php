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
                            <th width="120">Status</th>
                            <th width="150">Aksi</th>
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
                                            'accepted' => ['label' => 'Terima', 'class' => 'badge badge-success'],
                                            'rejected' => ['label' => 'Tolak', 'class' => 'badge badge-secondary'],
                                            'interview' => ['label' => 'Wawancara', 'class' => 'badge badge-warning'],
                                            'test1' => ['label' => 'Test 1', 'class' => 'badge badge-warning'],
                                            'test2' => ['label' => 'Test 2', 'class' => 'badge badge-warning'],
                                            'submitted' => ['label' => 'Menunggu', 'class' => 'badge badge-secondary'],
                                            'reviewed' => ['label' => 'Menunggu', 'class' => 'badge badge-secondary'],
                                        ];
                                        $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'badge bg-light text-dark'];
                                    @endphp
                                    <span class="{{ $currentStatus['class'] }}">
                                        {{ $currentStatus['label'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <!-- View -->
                                        <a href="{{ route('company.applications.show.company', $application->id) }}" 
                                           class="action-mini view">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Dropdown -->
                                        <div class="dropdown">
                                            <button class="action-mini edit dropdown-toggle" 
                                                    type="button" 
                                                    id="dropdownMenuButton{{ $application->id }}" 
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
    aria-labelledby="dropdownMenuButton{{ $application->id }}">
    @foreach ([
        'submitted' => ['icon' => 'fa-clock', 'label' => 'Submitted'],
        'test1' => ['icon' => 'fa-flask', 'label' => 'Test 1'],
        'test2' => ['icon' => 'fa-flask', 'label' => 'Test 2'],
        'interview' => ['icon' => 'fa-user-tie', 'label' => 'Interview'],
        'accepted' => ['icon' => 'fa-check text-success', 'label' => 'Terima'],
        'rejected' => ['icon' => 'fa-times text-danger', 'label' => 'Tolak']
    ] as $status => $info)
        <li>
            <form action="{{ route('company.applications.updateStatus', $application->id) }}"
                  method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="{{ $status }}">
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
                                            <button type="submit" class="action-mini delete">
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
            console.log('DOM Content Loaded');

            // Test if Bootstrap is loaded
            console.log('Bootstrap loaded:', typeof bootstrap !== 'undefined');
            console.log('Dropdown elements found:', document.querySelectorAll('.dropdown-toggle').length);

            // Ensure all dropdowns work properly
            if (typeof bootstrap !== 'undefined') {
                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });
                console.log('Bootstrap dropdowns initialized:', dropdownList.length);
            } else {
                console.warn('Bootstrap not loaded, using fallback');
                // Fallback for dropdown functionality
                document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        var dropdown = toggle.closest('.dropdown');
                        var menu = dropdown.querySelector('.dropdown-menu');

                        // Toggle menu visibility
                        var isVisible = menu.style.display === 'block';
                        menu.style.display = isVisible ? 'none' : 'block';

                        // Close other dropdowns
                        document.querySelectorAll('.dropdown-menu').forEach(function(otherMenu) {
                            if (otherMenu !== menu) {
                                otherMenu.style.display = 'none';
                            }
                        });
                    });
                });

                // Close dropdowns when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.dropdown')) {
                        document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                            menu.style.display = 'none';
                        });
                    }
                });
            }

            // Add click handler for dropdown items to prevent form submission issues
            document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    // Only prevent default if it's a form button
                    if (e.target.tagName === 'BUTTON' && e.target.closest('form')) {
                        // Let the form submit normally
                        return true;
                    }
                });
            });

            // Debug: Log when dropdown is clicked
            document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    console.log('Dropdown clicked:', e.target);
                    console.log('Dropdown button ID:', e.target.id);
                    console.log('Dropdown aria-expanded:', e.target.getAttribute('aria-expanded'));
                });
            });
        });
    </script>
@endsection
