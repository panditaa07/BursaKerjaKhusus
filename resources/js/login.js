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