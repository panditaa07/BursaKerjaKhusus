<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
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
                <h4 style="font-weight: bold; margin-top: 10px;">Login</h4>
            </div>
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" id="password" required>
                    <i class="fa fa-eye-slash" id="togglePassword"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; margin-bottom: 1rem;">
                    <label>
                        <input type="checkbox" name="remember"> Ingat Saya
                    </label>
                    <a href="{{ route('password.request') }}" style="color: #6C4F3D; text-decoration: none;">Lupa Password?</a>
                </div>

                <button type="submit">Masuk</button>
            </form>

            <div class="register-link">
                <p>Belum Punya Akun? 
                    <a href="{{ route('register.role', ['role' => 'user']) }}">Daftar sebagai Pelamar</a> atau 
                    <a href="{{ route('register.role', ['role' => 'company']) }}">Daftar sebagai Perusahaan</a>
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
        // Toggle Password
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

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
