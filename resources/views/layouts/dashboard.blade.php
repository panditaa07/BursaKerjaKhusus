<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - BKK OPAT</title>
    <link rel="icon" href="{{ asset('images/smkn4.png') }}" type="image/png">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard-fix.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/table-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Kelolapengguna.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    {{-- CSS tambahan untuk setiap halaman --}}
    @yield('css')
    @yield('styles') {{-- ✅ Tambahan agar CSS halaman seperti profile.css bisa terbaca --}}
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Unified Sidebar -->
        <div id="sidebar" class="sidebar text-white">
            <x-sidebar />
        </div>

        <!-- Mobile Backdrop -->
        <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

        <!-- Main Content -->
        <div id="mainContent" class="main-content flex-grow-1">
            <header class="top-header">
                <button id="menuToggle" class="btn btn-light d-lg-none">
                    <i class="bi bi-list" style="font-size: 1.5rem;"></i>
                </button>
                <!-- You can add other header content here, like user dropdown -->
            </header>

            {{-- Role-based Page Title - Only on Dashboard Index Pages --}}
            @php
                $user = Auth::user();
                $role = $user ? ($user->role->name ?? 'user') : 'guest';
                $pageTitles = [
                    'admin' => 'Dashboard Admin',
                    'company' => 'Dashboard Perusahaan',
                    'user' => 'Dashboard Pengguna'
                ];
                $pageTitle = $pageTitles[$role] ?? 'Dashboard';
                $isDashboardPage = request()->routeIs('admin.dashboard.index') || 
                                   request()->routeIs('company.dashboard.index') || 
                                   request()->routeIs('user.dashboard.index');
            @endphp
            @if($isDashboardPage)
            <div class="page-title">
                <div class="container mx-auto px-4 py-4">
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                </div>
            </div>
            @endif
            
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>

    {{-- Script tambahan untuk setiap halaman --}}
    @yield('scripts') {{-- ✅ Tambahan agar JS halaman seperti profile.js bisa berjalan --}}
    @stack('scripts')
</body>
</html>
