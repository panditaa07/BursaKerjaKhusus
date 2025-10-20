@extends('layouts.dashboard')

@section('title', 'Edit Profil Saya')

@push('styles')
<meta name="update-photo-url" content="{{ route('profile.photo.update') }}">
<link rel="stylesheet" href="{{ asset('css/editprofile-user.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
    .cropper-modal {
        background-color: rgba(0, 0, 0, 0.3); /* Make the overlay less dark */
    }
    .img-container {
        max-height: 450px;
    }
    .cropper-preview {
        overflow: hidden;
        width: 160px; /* preview width */
        height: 160px; /* preview height */
        border-radius: 50%; /* Make it a circle */
        margin: 0 auto;
        border: 1px solid #ddd;
    }
    .form-note {
        font-size: 0.875rem;
        color: #6c757d;
        text-align: center;
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="header">
        <h1>Edit Profil</h1>
    </div>

    <div class="profile-card">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
            @csrf
            @method('PUT')

            <!-- Photo Section - Horizontal Layout -->
            <div class="photo-section">
                <div class="photo-wrapper">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                             alt="Foto Profil" class="profile-photo-img" id="profile-image-preview">
                    @else
                        <div class="profile-photo" id="profile-image-preview">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <label class="upload-btn">
                    Upload Foto
                    <input type="file" id="profile_photo_input" accept="image/jpeg, image/png, .jpg, .jpeg, .png" hidden>
                </label>
            </div>

            <!-- Basic Info -->
            <div class="form-row">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="address" value="{{ old('address', Auth::user()->address) }}">
                </div>
            </div>

            @if(Auth::user()->role->name !== 'company')
            <div class="form-row">
                <div class="form-group">
                    <label>NIK/NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn', Auth::user()->nisn) }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', Auth::user()->birth_date) }}">
                </div>
            </div>
            @endif

            <div class="form-group">
                <label>Profil Singkat</label>
                <textarea name="short_profile" rows="3">{{ old('short_profile', Auth::user()->short_profile) }}</textarea>
            </div>

            <!-- Links Section - 2 Columns -->
            <div class="form-row">
                <div class="form-group">
                    <label>Portfolio Link</label>
                    <input type="url" name="portfolio_link" value="{{ old('portfolio_link', Auth::user()->portfolio_link) }}" placeholder="https://portfolio.com">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="url" name="linkedin" value="{{ old('linkedin', Auth::user()->linkedin) }}" placeholder="https://linkedin.com/in/username">
                </div>
            </div>

            <!-- Social Media - 3 Columns -->
            <div class="social-media-row">
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram', Auth::user()->instagram) }}" placeholder="https://instagram.com/username">
                </div>
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="url" name="facebook" value="{{ old('facebook', Auth::user()->facebook) }}" placeholder="https://facebook.com/username">
                </div>
                <div class="form-group">
                    <label>Twitter</label>
                    <input type="url" name="twitter" value="{{ old('twitter', Auth::user()->twitter) }}" placeholder="https://twitter.com/username">
                </div>
            </div>

            <div class="form-group">
                <label>TikTok</label>
                <input type="url" name="tiktok" value="{{ old('tiktok', Auth::user()->tiktok) }}" placeholder="https://tiktok.com/@username">
            </div>

            @if(Auth::user()->role->name !== 'company')
            <!-- Documents Section - 2 Columns -->
            <div class="documents-row">
                <div class="form-group">
                    <label class="file-upload-btn">
                    Pilih CV
                    <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" hidden>
                </label>

                @if(Auth::user()->cv_path)
                <p class="current-file">Saat ini: 
                    <a href="{{ asset('storage/' . Auth::user()->cv_path) }}" target="_blank">Lihat CV</a>
                </p>
                @endif

                </div>
                <div class="form-group">
                    <label class="file-upload-btn">
                    Pilih Surat Lamaran
                    <input type="file" id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx" hidden>
                </label>

                @if(Auth::user()->cover_letter_path)
                <p class="current-file">Saat ini: 
                    <a href="{{ asset('storage/cover_letter_files/' . Auth::user()->cover_letter_path) }}" target="_blank">Lihat Surat</a>
                </p>
                @endif

                </div>
            </div>
            @endif

            <p class="form-note">
                Catatan: Untuk perubahan data selain foto profil, pastikan Anda menekan tombol "Simpan Perubahan".
            </p>

            <div class="btn-group">
                <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" id="save-changes-btn">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Cropper Modal -->
<div class="modal fade" id="cropImageModal" tabindex="-1" aria-labelledby="cropImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cropImageModalLabel">Crop Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-8">
                <div class="img-container">
                    <img id="image-to-crop" src="">
                </div>
            </div>
            <div class="col-md-4">
                <h6 class="text-center">Preview</h6>
                <div class="cropper-preview"></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="crop-and-save">Simpan Foto</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="{{ asset('js/editprofile-user.js') }}"></script>
@endpush