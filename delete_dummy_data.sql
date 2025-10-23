-- Script SQL untuk menghapus data dummy dari database Bursa Kerja Khusus
-- Hanya menyisakan data admin dan data yang dibuat oleh admin
-- Menggunakan TRANSACTION untuk keamanan dan menonaktifkan foreign key checks sementara

START TRANSACTION;

-- Menonaktifkan foreign key checks untuk menghindari error
SET FOREIGN_KEY_CHECKS = 0;

-- Mendapatkan role_id untuk admin
SET @admin_role_id = (SELECT id FROM roles WHERE name = 'admin' LIMIT 1);

-- DRY RUN: Menampilkan jumlah data yang akan dihapus per tabel
SELECT 'DRY RUN - Jumlah data yang akan dihapus:' AS info;

SELECT 'user_notifications' AS table_name, COUNT(*) AS count_to_delete
FROM user_notifications
WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id);

SELECT 'applications' AS table_name, COUNT(*) AS count_to_delete
FROM applications
WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id)
   OR job_post_id IN (SELECT id FROM job_posts WHERE company_id IN (SELECT id FROM companies WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id)));

SELECT 'job_posts' AS table_name, COUNT(*) AS count_to_delete
FROM job_posts
WHERE company_id IN (SELECT id FROM companies WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id));

SELECT 'companies' AS table_name, COUNT(*) AS count_to_delete
FROM companies
WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id);

SELECT 'users' AS table_name, COUNT(*) AS count_to_delete
FROM users
WHERE role_id != @admin_role_id;

-- EKSEKUSI PENGHAPUSAN DATA
-- Hapus notifikasi terlebih dahulu
DELETE FROM user_notifications
WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id);

-- Hapus aplikasi
DELETE FROM applications
WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id)
   OR job_post_id IN (SELECT id FROM job_posts WHERE company_id IN (SELECT id FROM companies WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id)));

-- Hapus job posts
DELETE FROM job_posts
WHERE company_id IN (SELECT id FROM companies WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id));

-- Hapus companies
DELETE FROM companies
WHERE user_id IN (SELECT id FROM users WHERE role_id != @admin_role_id);

-- Hapus users (company dan user roles)
DELETE FROM users
WHERE role_id != @admin_role_id;

-- Mengaktifkan kembali foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- HASIL AKHIR: Menampilkan jumlah data tersisa per tabel
SELECT 'HASIL AKHIR - Jumlah data tersisa:' AS info;

SELECT 'roles' AS table_name, COUNT(*) AS remaining_count FROM roles;
SELECT 'industries' AS table_name, COUNT(*) AS remaining_count FROM industries;
SELECT 'users' AS table_name, COUNT(*) AS remaining_count FROM users;
SELECT 'companies' AS table_name, COUNT(*) AS remaining_count FROM companies;
SELECT 'job_posts' AS table_name, COUNT(*) AS remaining_count FROM job_posts;
SELECT 'applications' AS table_name, COUNT(*) AS remaining_count FROM applications;
SELECT 'user_notifications' AS table_name, COUNT(*) AS remaining_count FROM user_notifications;

-- Commit transaksi
COMMIT;

SELECT 'Proses penghapusan data dummy selesai dengan aman.' AS status;
