@extends('layouts.dashboard')

@section('title', 'Edit Profil Saya')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/editprofile-user.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<style>
    .cropper-modal .modal-lg {
        max-width: 800px;
    }
    #image-to-crop {
        max-width: 100%;
    }
    .photo-wrapper {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
        border: 4px solid #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .profile-photo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-photo {
        font-size: 4rem;
        color: #adb5bd;
    }
    .cropper-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin: 20px auto;
        border: 2px solid #e9ecef;
    }

    /* === New Styles for Backdrop and Cropper UI === */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.8);
    }
    .modal-backdrop.show {
        opacity: 1; /* Use background-color for opacity */
    }

    .cropper-view-box {
        outline: 1px solid white;
        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.65);
    }
    
    /* Hide default cropper guides for a cleaner look */
    .cropper-dashed, .cropper-point, .cropper-line, .cropper-center {
        display: none;
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
                    <input type="file" id="profile_photo_input" accept="image/png, image/jpeg" hidden>
                </label>
            </div>

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
                <textarea name="short_profile" rows="4">{{ old('short_profile', Auth::user()->short_profile) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Portfolio Link</label>
                    <input type="url" name="portfolio_link" value="{{ old('portfolio_link', Auth::user()->portfolio_link) }}">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="url" name="linkedin" value="{{ old('linkedin', Auth::user()->linkedin) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram', Auth::user()->instagram) }}">
                </div>
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="url" name="facebook" value="{{ old('facebook', Auth::user()->facebook) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Twitter</label>
                    <input type="url" name="twitter" value="{{ old('twitter', Auth::user()->twitter) }}">
                </div>
                <div class="form-group">
                    <label>TikTok</label>
                    <input type="url" name="tiktok" value="{{ old('tiktok', Auth::user()->tiktok) }}">
                </div>
            </div>

            @if(Auth::user()->role->name !== 'company')
            <div class="form-group">
                <label>Upload CV</label>
                <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx">
                @if(Auth::user()->cv_path)
                    <p class="current-file">CV saat ini: 
                        <a href="{{ asset('storage/' . Auth::user()->cv_path) }}" target="_blank">Lihat</a>
                    </p>
                @endif
            </div>
            <div class="form-group">
                <label for="cover_letter">Upload Surat Lamaran</label>
                <input type="file" id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx">
                @if(Auth::user()->cover_letter_path)
                    <p class="current-file">Surat Lamaran saat ini: 
                        <a href="{{ asset('storage/cover_letter_files/' . Auth::user()->cover_letter_path) }}" target="_blank">Lihat</a>
                    </p>
                @endif
            </div>
            @endif

            <div class="btn-group">
                <a href="{{ route('profile.show') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Cropper Modal -->
<div class="modal fade cropper-modal" id="cropImageModal" tabindex="-1" aria-labelledby="cropImageModalLabel" aria-hidden="true">
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