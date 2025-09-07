@props(['user' => null])

@php
    $user = $user ?? Auth::user();
    $role = $user ? $user->role : null;
@endphp

<div class="bg-primary text-white overflow-auto" style="width: 250px; min-height: 100vh;">
    <!-- Logo Section -->
    <div class="d-flex align-items-center justify-content-center py-3 border-bottom border-secondary">
        <div class="text-center">
            <img src="{{ asset('images/logo-smk.png') }}" alt="BKK OPAT Logo" class="mx-auto mb-2 rounded-circle" style="width: 64px; height: 64px;">
            <h5 class="fw-bold mb-0">BKK OPAT</h5>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-3">
        <div class="list-group list-group-flush bg-transparent">
            @if($role === 'admin')
                <!-- Admin Menu -->
                <a href="{{ route('admin.dashboard.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-house-door me-3"></i>
                    <span class="small fw-medium">Halaman Utama</span>
                </a>
                <a href="{{ route('admin.job-posts.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-briefcase me-3"></i>
                    <span class="small fw-medium">Kelola Lowongan Kerja</span>
                </a>
            @elseif($role === 'company')
                <!-- Company Menu -->
                <a href="{{ route('company.dashboard.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-house-door me-3"></i>
                    <span class="small fw-medium">Halaman Utama</span>
                </a>
                <a href="{{ route('company.applications.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-people me-3"></i>
                    <span class="small fw-medium">Kelola Pelamar</span>
                </a>
                <a href="{{ route('company.jobs.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-briefcase me-3"></i>
                    <span class="small fw-medium">Kelola Lowongan Kerja</span>
                </a>
                <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-person me-3"></i>
                    <span class="small fw-medium">Profile</span>
                </a>
            @elseif($role === 'user')
                <!-- User Menu -->
                <a href="{{ route('user.dashboard.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-house-door me-3"></i>
                    <span class="small fw-medium">Halaman Utama</span>
                </a>
                <a href="{{ route('jobs.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-briefcase me-3"></i>
                    <span class="small fw-medium">Lowongan Kerja</span>
                </a>
                <a href="{{ route('user.applications.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-file-earmark-text me-3"></i>
                    <span class="small fw-medium">Lamaran Saya</span>
                </a>
                <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action bg-transparent text-white border-0 px-3 py-2">
                    <i class="bi bi-person me-3"></i>
                    <span class="small fw-medium">Biodata</span>
                </a>
            @endif

            <!-- Logout Form -->
            <div class="mt-4 px-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>
