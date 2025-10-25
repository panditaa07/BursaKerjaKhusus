@extends('layouts.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pelamarbulaninicom.css') }}">
@endpush

@section('content')
<div class="container-fluid pelamar-bulan-ini">
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
            <div class="table-responsive" id="table-container">
                <table class="company-applications-table mb-0">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Lowongan yang Dilamar</th>
                            <th width="160">Status</th>
                            <th width="220" class="text-center">Aksi</th>
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

                                {{-- === AKSI (SEJAJAR HORIZONTAL) === --}}
                                <td class="text-center">
                                    <div class="aksi-wrapper">
                                        {{-- Lihat --}}
                                        <a href="{{ route('company.applications.show.company', $application->id) }}"
                                           class="action-text view">Lihat</a>

                                        {{-- Edit (dropdown ubah status) --}}
                                        <div class="dropdown d-inline-block custom-dropdown">
                                            <button
                                                class="action-text edit dropdown-toggle"
                                                type="button"
                                                data-dropdown-id="dropdown-{{ $application->id }}">
                                                Edit
                                            </button>

                                            <ul class="dropdown-menu custom-dropdown-menu" id="dropdown-{{ $application->id }}">
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

                                                @foreach ($statusMenu as $value => $opt)
                                                    @php
                                                        $isActive = ($value === $application->status);
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
                                                            <form action="{{ route('company.applications.updateStatus', $application->id) }}"
                                                                  method="POST" class="d-inline w-100">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="{{ $value }}">
                                                                <button type="submit" class="dropdown-item {{ $btnClasses }} w-100 text-start">
                                                                    <i class="status-icon {{ $opt['icon'] }}"></i>
                                                                    {{ $opt['label'] }}
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Custom dropdown system untuk menghindari konflik Bootstrap
    class CustomDropdown {
        constructor(button) {
            this.button = button;
            this.dropdownId = button.getAttribute('data-dropdown-id');
            this.menu = document.getElementById(this.dropdownId);
            this.isOpen = false;
            
            this.init();
        }
        
        init() {
            // Click event untuk toggle dropdown
            this.button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggle();
            });
            
            // Close ketika klik di luar
            document.addEventListener('click', (e) => {
                if (!this.button.contains(e.target) && !this.menu.contains(e.target)) {
                    this.close();
                }
            });
            
            // Close ketika tekan Escape
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) {
                    this.close();
                }
            });
        }
        
        toggle() {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        }
        
        open() {
            // Close semua dropdown lain
            document.querySelectorAll('.custom-dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
            
            // Position dropdown
            this.positionDropdown();
            
            // Show current dropdown
            this.menu.classList.add('show');
            this.isOpen = true;
        }
        
        close() {
            this.menu.classList.remove('show');
            this.isOpen = false;
        }
        
        positionDropdown() {
            const buttonRect = this.button.getBoundingClientRect();
            const menuRect = this.menu.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Default: tampilkan di bawah
            let top = buttonRect.bottom + scrollTop;
            let left = buttonRect.left + (buttonRect.width / 2) - (menuRect.width / 2);
            
            // Jika tidak cukup space di bawah, tampilkan di atas
            const spaceBelow = viewportHeight - buttonRect.bottom;
            const spaceAbove = buttonRect.top;
            
            if (spaceBelow < menuRect.height && spaceAbove > menuRect.height) {
                top = buttonRect.top + scrollTop - menuRect.height;
            }
            
            // Pastikan tidak keluar dari viewport horizontal
            if (left < 10) left = 10;
            if (left + menuRect.width > window.innerWidth - 10) {
                left = window.innerWidth - menuRect.width - 10;
            }
            
            // Apply position
            this.menu.style.top = top + 'px';
            this.menu.style.left = left + 'px';
        }
    }
    
    // Initialize semua custom dropdown
    document.querySelectorAll('.custom-dropdown .dropdown-toggle').forEach(button => {
        new CustomDropdown(button);
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        document.querySelectorAll('.custom-dropdown-menu.show').forEach(menu => {
            const dropdownId = menu.id;
            const button = document.querySelector(`[data-dropdown-id="${dropdownId}"]`);
            if (button) {
                const buttonRect = button.getBoundingClientRect();
                const menuRect = menu.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                let top = buttonRect.bottom + scrollTop;
                let left = buttonRect.left + (buttonRect.width / 2) - (menuRect.width / 2);
                
                // Pastikan tidak keluar dari viewport
                if (left < 10) left = 10;
                if (left + menuRect.width > window.innerWidth - 10) {
                    left = window.innerWidth - menuRect.width - 10;
                }
                
                menu.style.top = top + 'px';
                menu.style.left = left + 'px';
            }
        });
    });
});
</script>
@endsection