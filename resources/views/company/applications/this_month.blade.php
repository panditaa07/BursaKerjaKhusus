@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">Pelamar Bulan Ini</h2>
            <div class="d-flex align-items-center">
                <a href="{{ route('company.pelamar.all') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-list me-2"></i>Lihat Semua Pelamar 
                </a>
                <div class="text-muted">
                    <i class="fas fa-users me-2"></i>
                    Total Pelamar: <strong>{{ $applications->total() }}</strong>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('company.applications.this_month') }}" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari pelamar berdasarkan nama, lowongan, atau status..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('company.applications.this_month') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm company-applications-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 company-applications-table">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-bold text-center" width="60">No</th>
                                <th class="border-0 fw-bold">Nama</th>
                                <th class="border-0 fw-bold">Email</th>
                                <th class="border-0 fw-bold">No. Hp</th>
                                <th class="border-0 fw-bold">Lowongan yang dilamar</th>
                                <th class="border-0 fw-bold text-center" width="120">Status</th>
                                <th class="border-0 fw-bold text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $application)
                                <tr>
                                    <td class="text-center text-muted fw-bold">{{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-3">
                                                @if($application->user->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}"
                                                         class="rounded-circle" width="40" height="40" alt="Avatar">
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
                                                'accepted' => ['label' => 'Terima', 'class' => 'status-accepted'],
                                                'rejected' => ['label' => 'Tolak', 'class' => 'status-rejected'],
                                                'interview' => ['label' => 'Wawancara', 'class' => 'status-interview'],
                                                'test1' => ['label' => 'Test 1', 'class' => 'status-test'],
                                                'test2' => ['label' => 'Test 2', 'class' => 'status-test'],
                                                'submitted' => ['label' => 'Menunggu', 'class' => 'status-pending'],
                                                'reviewed' => ['label' => 'Menunggu', 'class' => 'status-pending'],
                                            ];
                                            $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-light text-dark'];
                                        @endphp
                                        <span class="badge {{ $currentStatus['class'] }} px-3 py-2">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <!-- View Detail -->
                                            <a href="{{ route('company.applications.show.company', $application->id) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit Status -->
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-warning dropdown-toggle"
                                                        type="button"
                                                        id="dropdownMenuButton{{ $application->id }}"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        title="Ubah Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton{{ $application->id }}">
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="submitted">
                                                            <button type="submit" class="dropdown-item">
                                                                Submitted
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="test1">
                                                            <button type="submit" class="dropdown-item">
                                                                Test 1
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="test2">
                                                            <button type="submit" class="dropdown-item">
                                                                Test 2
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="interview">
                                                            <button type="submit" class="dropdown-item">
                                                                Interview
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="accepted">
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fas fa-check-circle me-2"></i>Terima
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-times-circle me-2"></i>Tolak
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Delete Application -->
                                            <form action="{{ route('company.applications.destroy', $application->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus lamaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Lamaran">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p class="mb-0">Belum ada lamaran bulan ini</p>
                                        </div>
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
