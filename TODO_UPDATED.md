# TODO: Implementasi Fitur Kelola Pengguna dan Perbaikan Profil

## 1. Sidebar & Route Admin
- [x] Tambahkan menu sidebar "Kelola Pengguna" (route: GET /admin/users) - DONE
- [x] Hanya bisa diakses oleh role=admin (middleware) - DONE

## 2. Kelola Pengguna (Admin)
- [x] Buat halaman tabel `resources/views/admin/users/index.blade.php` - DONE
- [x] Menampilkan semua user yang sudah register (role company & user). Role admin JANGAN ditampilkan - DONE
- [x] Kolom tabel: No, Nama, Email, Role, Kategori, Tanggal Daftar, Aksi - DONE
- [x] Kategori sesuai spesifikasi - DONE
- [x] Tambahkan search (nama/email) dan filter (role, kategori) - DONE
- [x] Pagination paginate(10) - DONE
- [x] Aksi: Detail (show), Edit (edit), Delete (soft delete) - DONE

## 3. Detail Pengguna (Admin)
- [x] Company: Data Umum, Data Perusahaan, List ringkas lowongan - DONE
- [x] User: Data Umum, Data Personal, Berkas, Riwayat Lamaran - DONE

## 4. Edit Pengguna (Admin)
- [x] Semua field yang tampil di detail harus bisa di-edit - DONE
- [x] Validasi field (email unique, file upload sesuai aturan) - DONE
- [x] Setelah simpan → redirect ke detail dengan notifikasi sukses - DONE

## 5. Profile Role Company & User
- [x] Company Profile: nama perusahaan, alamat, telp, email kontak, industri, logo, deskripsi - DONE
- [x] User Profile: NIK/NISN, nama, tanggal lahir, no HP, alamat, profil singkat, foto profil, CV, surat lamaran - DONE
- [x] Upload rules: CV & Logo & Foto Profil max 2MB - DONE
- [x] Jika field kosong → tampilkan "-" atau badge "Belum diisi" - DONE

## 6. Konsistensi Data
- [x] Semua data admin ambil langsung dari field profil User/Company - DONE
- [x] Relasi: Company → jobPosts, User → applications - DONE

## 7. Delete & Safety
- [x] Delete hanya soft delete (gunakan deleted_at) - DONE
- [x] Admin tidak bisa menghapus dirinya sendiri - DONE

## 8. "Loker Tersedia"
- [x] Ubah perhitungan "Loker Tersedia" di halaman admin job posts - DONE
- [x] Selalu tampilkan TOTAL SEMUA lowongan dari tabel `job_posts` (JobPost::count()) - DONE
- [x] Tidak dipengaruhi search, filter, pagination, status, atau perusahaan - DONE

## 9. Data Dummy (Seeder)
- [x] Hapus data dummy lama yang duplikat - DONE
- [x] Buat ulang data dummy dengan nilai unik - DONE
- [x] Distribusi: 5 company sudah punya lowongan, 3 company belum; 8 user sudah melamar, 5 user belum; 15 job posts - DONE

## 10. Validasi & Notifikasi
- [x] Tambahkan flash message untuk aksi (sukses/gagal simpan, sukses/gagal hapus) - DONE
- [x] Validasi upload file sesuai rules - DONE

## 11. Testing Setelah Deploy
- [ ] Admin: Cek Kelola Pengguna → semua user tampil sesuai kategori
- [ ] Admin: Cek Detail/Edit → data konsisten & bisa diedit
- [ ] Admin: Cek Delete → user hilang dari list tapi masih ada di DB (soft delete)
- [ ] Company/User: Cek halaman profile → semua field konsisten dengan detail admin
- [ ] Admin Job Post: Cek "Loker Tersedia" → selalu menampilkan jumlah total semua job_posts di DB
- [ ] Seeder: Jalankan db:seed → verifikasi data dummy unik, kategori terdistribusi benar

## 12. Bug Fixes
- [x] Fixed route name from 'admin.users.showUser' to 'admin.users.show' in index view
- [x] Fixed SQL error by using role relationship instead of non-existent 'role' column
- [x] Fixed route name from 'admin.users' to 'admin.users.index' in create/edit views
