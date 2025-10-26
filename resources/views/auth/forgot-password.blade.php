<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="icon" href="{{ asset('images/smkn4.png') }}" type="image/png">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="login-wrapper">
        <!-- FORM LOGIN -->
        <div class="form-box">
            <div class="logo-box">
                <img src="{{ asset('images/smkn4.png') }}" alt="logo">
                <h4 style="font-weight: bold; margin-top: 10px;">Lupa Password</h4>
            </div>
            <p class="mb-4 text-muted">Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan link untuk mereset password Anda.</p>
            
            @if (session('status'))
                <div class="alert alert-success status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Kirim Link Reset Password
                    </button>
                </div>
            </form>

            <div class="login-link">
                <p>
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </p>
            </div>
        </div>

        <!-- ANIMASI LOTTIE -->
        <div class="animation-box">
            <div id="lottie-animation"></div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        // Lottie Animation
        lottie.loadAnimation({
            container: document.getElementById("lottie-animation"),
            renderer: "svg",
            loop: true,
            autoplay: true,
            path: "https://lottie.host/ae75b9b9-c8f8-4db5-a30c-3c0c1de2c026/jmhHHxwSkA.json"
        });
    </script>
</body>
</html>