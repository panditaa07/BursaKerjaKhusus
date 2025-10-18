<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" href="{{ asset('images/smkn4.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="form-box">
            <div class="logo-box">
                <img src="{{ asset('images/smkn4.png') }}" alt="logo">
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

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email', $request->email) }}" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password Baru" id="password" required>
                    <i class="fa fa-eye-slash" id="togglePassword"></i>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" required>
                </div>

                <button type="submit">Reset Password</button>
            </form>

            <div class="register-link">
                <p>Ingat password Anda? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </div>

        <div class="animation-box">
            <div id="lottie-animation"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

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
