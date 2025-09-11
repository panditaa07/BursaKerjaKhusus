<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'BKK OPAT')</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />

    {{-- CSS global --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    {{-- CSS tambahan per halaman --}}
    @yield('css')
    @stack('styles')
</head>
<body class="bg-light">

    {{-- Konten halaman --}}
    @yield('content')

    {{-- JS Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JS global --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- JS tambahan per halaman --}}
    @yield('js')
    @stack('scripts')

</body>
</html>
