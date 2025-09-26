<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursa Kerja Khusus</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="icon" href="images/smkn4.png" type="image/png">
    <!-- Lottie Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>

</head>
<body class="overflow-hidden">

    <!-- LOADING SCREEN -->
    <div id="loading-screen">
        <div id="lottie-logo"></div>
    </div>

    <header class="header">
        <nav class="nav">
            <div class="logo">
            <img src="{{ asset('images/smkn4.png') }}" class="logo-img">
            <span>BKK Opat</span>
          </div>

            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-login" id="loginBtn">Login</a>
                <a href="{{ route('register') }}" class="btn btn-register" id="registerBtn">Register</a>
            </div>

        </nav>
    </header>

    <div id="main-content" style="opacity: 0; transform: translateY(50px); transition: opacity 1s ease-out, transform 1s ease-out;">

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="hero-content" id="hero-content">
            <h1>Bursa Kerja Khusus</h1>
            <p>Bursa Kerja Khusus (BKK) SMKN 4 Bandung merupakan layanan resmi sekolah 
      yang berfungsi sebagai jembatan antara dunia pendidikan dan dunia kerja. 
      Dalam website ini menyediakan informasi terkini seputar lowongan pekerjaan, 
      magang, rekrutmen, serta pelatihan karir yang ditujukan bagi siswa dan alumni.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="features-container">
            <h2>Tim BKK</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="foto">
                        <img src="{{ asset('images/foto-default.png') }}" alt="Default">
                    </div>
                    <h3>Nama Staff</h3>
                    <p>Staff BKK</p>
                </div>
                <div class="feature-card">
                    <div class="foto">
                        <img src="{{ asset('images/foto-default.png') }}" alt="Default">
                    </div>
                    <h3>Nama Staff</h3>
                    <p>Staff BKK</p>
                </div>
                <div class="feature-card">
                  <div class="foto">
                    <img src="{{ asset('images/foto-default.png') }}" alt="Default">
                </div>
                <h3>Nama Staff</h3>
                <p>Staff BKK</p>
                </div>
                <div class="feature-card">
                    <div class="foto">
                        <img src="{{ asset('images/foto-default.png') }}" alt="Default">
                    </div>
                    <h3>Nama Staff</h3>
                    <p>Staff BKK</p>
                </div>
                <div class="feature-card">
                    <div class="foto">
                        <img src="{{ asset('images/foto-default.png') }}" alt="Default">
                    </div>
                    <h3>Nama Staff</h3>
                    <p>Staff BKK</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <footer>
  <div class="footer-info">
    <!-- Kiri -->
    <div class="alamat">
      <div class="logo-footer">
        <img src="{{ asset('images/jabar.png') }}" alt="Logo 1">
        <img src="{{ asset('images/disdik.png') }}" alt="Logo 2">
        <img src="{{ asset('images/smkn4.png') }}" alt="Logo 3">
      </div>
      <h3>SMK NEGERI 4 BANDUNG</h3>
      <p>
        Jl. Kliningan No.6, Turangga, Kec. Lengkong<br>
        Telp/Fax : (022) – 7303736<br>
        Kode Pos : 40264 Kota Bandung<br>
        Provinsi Jawa Barat<br>
        Indonesia
      </p>
    </div>

    <!-- Kanan -->
    <div class="tautan">
      <a href="https://disdik.jabarprov.go.id/">Dinas Pendidikan Jawa Barat</a>
      <a href="https://kemendikdasmen.go.id/">Kementrian Pendidikan dan Kebudayaan</a>
      <a href="https://referensi.data.kemendikdasmen.go.id/">Referensi Pendidikan</a>
      <a href="https://data.komdigi.go.id/article/literasi-digital-indonesia">Digital Literasi</a>
      <a href="https://smkbisa.id/">Smk Bisa</a>
    </div>
  </div>

  <!-- Sosmed -->
  <div class="sosmed">
    <a href="https://instagram.com/smknegeri4bandung"><img src="{{ asset('images/instagram.png') }}" alt="Instagram"></a>
    <a href="https://www.youtube.com/@SMKN4BANDUNGOfficial"><img src="{{ asset('images/youtube.png') }}" alt="Youtube"></a>
  </div>

  <!-- Copyright -->
  <div class="copyright">
    <p>2025 <strong>smkn4bdg.sch.id</strong> All Rights Reserved</p>
  </div>
</footer>

</div>

         <script src="{{ asset('js/home.js') }}"></script>

<!-- LOADING SCRIPT -->
<script>
  // Load Lottie Animation
  lottie.loadAnimation({
    container: document.getElementById('lottie-logo'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: "{{ asset('animations/bkk-loading.json') }}"  // ganti dengan lokasi file animasi logo kamu
  });

  function hideLoader() {
    const loader = document.getElementById("loading-screen");
    loader.classList.add("opacity-0");
    setTimeout(() => {
      loader.remove();
      document.body.classList.remove("overflow-hidden");
    }, 500);
  }

  // Minimal delay 3s
  const minDelay = 3000;

  window.addEventListener("load", function () {
    setTimeout(hideLoader, minDelay);
    // Add animation to main-content after loading screen hides
    setTimeout(() => {
      const mainContent = document.getElementById('main-content');
      if (mainContent) {
        mainContent.style.opacity = '1';
        mainContent.style.transform = 'translateY(0)';
      }
   // Hapus overflow-hidden setelah animasi main-content selesai
    document.body.classList.remove("overflow-hidden");
   }, minDelay + 300);
  });
</script>
</body>
</html>
