# TODO: Hapus Data Dummy dan Data Terdaftar

## Tugas Utama
Hapus semua data dummy dan data perusahaan/pengguna yang terdaftar, menyisakan hanya data admin untuk testing dari awal.

## Langkah-langkah
- [x] Eksekusi script SQL delete_dummy_data.sql
- [x] Verifikasi data tersisa (hanya admin)
- [x] Clear Laravel cache jika diperlukan

## File yang Terpengaruh
- delete_dummy_data.sql (script penghapusan)
- Database: laravel (MySQL)

## Catatan
- Script menggunakan transaction untuk keamanan
- Menampilkan dry run dan hasil akhir
- Foreign key checks dinonaktifkan sementara
- Script dieksekusi melalui Laravel Tinker untuk menghindari masalah command line
- Cache Laravel telah dibersihkan
