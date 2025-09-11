@props(['user' => null])

@php
    $user = $user ?? Auth::user();
    $role = $user ? ($user->role->name ?? null) : null;
@endphp

<div class="sidebar bg-primary text-white">
    <!-- Logo Section -->
    <div class="sidebar-header">
        <div class="text-center">
            <img src="{{ asset('images/logo-smk.png') }}" alt="BKK OPAT Logo" class="mx-auto mb-2 rounded-circle" style="width: 64px; height: 64px;">
            <h5 class="fw-bold mb-0">BKK OPAT</h5>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="sidebar-content">
        <ul class="lists">
            @if($role === 'admin')
                <!-- Admin Menu -->
                <li><a href="{{ route('admin.dashboard.index') }}" class="nav-link">
                    <i class="icon bi bi-house-door"></i>
                    <span>Halaman Utama</span>
                </a></li>
                <li><a href="{{ route('admin.job-posts.index') }}" class="nav-link">
                    <i class="icon bi bi-briefcase"></i>
                    <span>Kelola Lowongan Kerja</span>
                </a></li>
            @elseif($role === 'company')
                <!-- Company Menu -->
                <li><a href="{{ route('company.dashboard.index') }}" class="nav-link">
                    <i class="icon bi bi-house-door"></i>
                    <span>Halaman Utama</span>
                </a></li>
                <li><a href="{{ route('company.applications.index') }}" class="nav-link">
                    <i class="icon bi bi-people"></i>
                    <span>Kelola Pelamar</span>
                </a></li>
                <li><a href="{{ route('company.jobs.index') }}" class="nav-link">
                    <i class="icon bi bi-briefcase"></i>
                    <span>Kelola Lowongan Kerja</span>
                </a></li>
                <li><a href="{{ route('profile.index') }}" class="nav-link">
                    <i class="icon bi bi-person"></i>
                    <span>Profile</span>
                </a></li>
            @elseif($role === 'user')
                <!-- User Menu -->
                <li><a href="{{ route('user.dashboard.index') }}" class="nav-link">
                    <i class="icon bi bi-house-door"></i>
                    <span>Halaman Utama</span>
                </a></li>
                <li><a href="{{ route('jobs.index') }}" class="nav-link">
                    <i class="icon bi bi-briefcase"></i>
                    <span>Lowongan Kerja</span>
                </a></li>
                <li><a href="{{ route('user.applications.index') }}" class="nav-link">
                    <i class="icon bi bi-file-earmark-text"></i>
                    <span>Lamaran Saya</span>
                </a></li>
                <li><a href="{{ route('profile.index') }}" class="nav-link">
                    <i class="icon bi bi-person"></i>
                    <span>Biodata</span>
                </a></li>
            @endif
        </ul>

        <!-- Logout Form -->
        <div class="bottom-list">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
