# TODO: Ubah Tombol Kembali di Halaman Fitur Lowongan

## Tugas Utama
Ubah tampilan halaman fitur lowongan (Lowongan Aktif, Lowongan Tidak Aktif) agar tombol "Kembali" konsisten dengan desain di halaman Show dan Edit:
- Class CSS: `btn btn-custom back`
- Ikon: `<i class="fas fa-arrow-left"></i>`
- Teks: "Kembali ke Daftar Lowongan"
- Posisi: Di bagian atas halaman, sebelum isi konten utama
- Fungsi: Mengarah ke halaman dashboard utama (/admin/dashboard)

## Langkah-langkah
- [x] Ubah tombol kembali di `resources/views/admin/dashboard/lowongan-aktif.blade.php`
- [x] Ubah tombol kembali di `resources/views/admin/dashboard/lowongan-tidak-aktif.blade.php`
- [x] Verifikasi tidak ada duplikat tombol kembali di halaman manapun
- [x] Pastikan struktur Blade/HTML rapi dan mengikuti standar template layout
- [x] Pastikan tombol menggunakan class `btn btn-custom back` dan ikon FontAwesome

## File yang Terpengaruh
- resources/views/admin/dashboard/lowongan-aktif.blade.php
- resources/views/admin/dashboard/lowongan-tidak-aktif.blade.php

## Referensi
- Halaman Show (resources/views/admin/jobs/show.blade.php) dan Edit (resources/views/admin/jobs/edit.blade.php) sudah menggunakan desain yang benar.
- Halaman Loker Terbaru (dashboard utama) tidak memiliki tombol kembali karena merupakan halaman utama.
