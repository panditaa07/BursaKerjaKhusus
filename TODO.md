# TODO: Ubah Tombol Kembali di Halaman Fitur Lowongan

## Tugas Utama
Ubah tampilan halaman fitur lowongan agar tombol "Kembali" konsisten dengan desain di fitur pelamar (seperti di halaman Detail Pelamar):
- Class CSS: `btn-custom back` (tanpa "btn btn-")
- Ikon: `<i class="fas fa-arrow-left me-2"></i>` (dengan margin end)
- Teks: "Kembali" (sederhana)
- Posisi: Di bagian atas halaman, sebelum isi konten utama
- Fungsi: Mengarah ke halaman dashboard utama (/admin/dashboard)

## Langkah-langkah
- [x] Ubah tombol kembali di `resources/views/admin/dashboard/lowongan-aktif.blade.php`
- [x] Ubah tombol kembali di `resources/views/admin/dashboard/lowongan-tidak-aktif.blade.php`
- [x] Ubah tombol kembali di `resources/views/admin/jobs/show.blade.php` (Detail Lowongan)
- [x] Ubah tombol kembali di `resources/views/admin/jobs/edit.blade.php` (Edit Lowongan)
- [x] Verifikasi tidak ada duplikat tombol kembali di halaman manapun
- [x] Pastikan struktur Blade/HTML rapi dan mengikuti standar template layout

## File yang Terpengaruh
- resources/views/admin/dashboard/lowongan-aktif.blade.php
- resources/views/admin/dashboard/lowongan-tidak-aktif.blade.php
- resources/views/admin/jobs/show.blade.php
- resources/views/admin/jobs/edit.blade.php
- resources/views/admin/applications/show.blade.php

## Referensi
- Halaman Detail Pelamar (resources/views/admin/applications/show.blade.php) menggunakan desain yang benar sebagai patokan.
- Halaman Loker Terbaru (dashboard utama) tidak memiliki tombol kembali karena merupakan halaman utama.
