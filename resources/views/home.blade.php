<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursa Kerja Khusus</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav">
             <div class="logo">
            <span>BKK Opat</span>
          </div>

            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-login" id="loginBtn">Login</a>
                <a href="{{ route('register') }}" class="btn btn-register" id="registerBtn">Register</a>
            </div>


            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="hero-content">
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

         <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>