<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
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

            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                </div>

                <button type="submit">Kirim Link Reset</button>
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
