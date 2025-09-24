<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - BKK OPAT</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}" />
</head>
<body>
    <div class="d-flex">
        <!-- Unified Sidebar -->
        <div id="sidebar" class="sidebar text-white">
            <x-sidebar />
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="main-content flex-grow-1">
            <header class="top-header">
                <button id="menuToggle" class="btn btn-light">
                    <i class="bi bi-list"></i>
                </button>
                <!-- You can add other header content here, like user dropdown -->
            </header>
            
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    <script src="{{ asset('js/dashboardadmin.js') }}" defer></script>

    @stack('scripts')
</body>
</html>