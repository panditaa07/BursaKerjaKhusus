# TODO: Perbaikan Penyimpanan File Surat Lamaran

## Tugas Utama
- [ ] Ubah logika penyimpanan cover_letter_path agar hanya menyimpan nama file tanpa path folder
- [ ] Pastikan file tetap diunggah ke folder storage/app/public/cover_letter_files

## File yang Perlu Diubah
### Controller
- [ ] app/Http/Controllers/ApplicationController.php - method store()
- [ ] app/Http/Controllers/ProfileController.php - method updateUserProfile()
- [ ] app/Http/Controllers/ApplicationController.php - method previewCoverLetter() dan downloadCoverLetter()

### View
- [ ] resources/views/user/profile/show.blade.php
- [ ] resources/views/user/profile/edit.blade.php
- [ ] resources/views/company/applications/show.blade.php
- [ ] resources/views/admin/users/show.blade.php
- [ ] resources/views/admin/users/show-updated.blade.php

## Langkah-langkah
1. [ ] Ubah ApplicationController store() - gunakan storeAs() dengan folder 'cover_letter_files' dan simpan hanya nama file
2. [ ] Ubah ProfileController updateUserProfile() - sama seperti di atas
3. [ ] Update preview/download methods untuk prepend folder path
4. [ ] Update semua view untuk menggunakan asset('storage/cover_letter_files/' . $path)
5. [ ] Test upload dan preview functionality

## Status
- [ ] Mulai perbaikan
