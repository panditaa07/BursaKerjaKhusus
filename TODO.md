# TODO: Perbaiki Fitur Update Status pada Halaman Detail Pelamar (Admin)

## Masalah
- Saat admin mengubah status pelamar dari halaman Detail Pelamar, status tidak berubah di database.
- Halaman Update Data Pelamar berhasil update status.

## Analisis
- Form di `show.blade.php` mengarah ke `admin.applications.update` (method PATCH) yang sama dengan edit form.
- Method `update` di `AdminApplicationController` memvalidasi semua field lengkap, bukan hanya status.
- Form status hanya mengirim field `status`, sehingga validasi gagal.

## Solusi
1. Buat method `updateStatus` terpisah di `AdminApplicationController` untuk update status saja.
2. Tambahkan route baru `admin.applications.updateStatus` (PATCH).
3. Update form di `show.blade.php` untuk menggunakan route baru.
4. Pastikan ada notifikasi sukses dan redirect kembali ke halaman show.
5. Tes bahwa status tersimpan di DB dan tampil di semua role.

## Langkah Implementasi
- [x] Tambahkan method `updateStatus` di `AdminApplicationController`
- [x] Tambahkan route `admin.applications.updateStatus` di `routes/web.php`
- [x] Update form action di `resources/views/admin/applications/show.blade.php`
- [x] Tambahkan notifikasi sukses setelah update
- [x] Tes update status dari halaman Detail Pelamar
- [x] Verifikasi status tersimpan di database
- [x] Verifikasi status tampil di halaman admin, company, dan user
