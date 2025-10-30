@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edituser.css') }}">

<div class="container mx-auto px-4 py-4">
<div class="detail-pengguna-page">
    <h1>Edit User</h1>
    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-custom back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-custom back">
            <i class="fas fa-eye"></i> Lihat Detail
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="fas fa-user-shield"></i> Informasi Personal</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Nama:</strong></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>Email:</strong></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label"><strong>No HP:</strong></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nisn" class="form-label"><strong>NIK/NISN:</strong></label>
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                id="nisn" name="nisn" value="{{ old('nisn', $user->nisn) }}">
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label"><strong>Alamat:</strong></label>
                    <textarea class="form-control @error('address') is-invalid @enderror"
                            id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="birth_date" class="form-label"><strong>Tanggal Lahir:</strong></label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="role" class="form-label"><strong>Role:</strong></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="user" {{ old('role', $user->role->name) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="company" {{ old('role', $user->role->name) == 'company' ? 'selected' : '' }}>Company</option>
                                <option value="admin" {{ old('role', $user->role->name) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label"><strong>Status:</strong></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status', !$user->deleted_at ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', !$user->deleted_at ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="fas fa-file-alt"></i> Berkas & Sosial Media</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="linkedin" class="form-label">
                                <i class="fab fa-linkedin"></i> <strong>LinkedIn:</strong>
                            </label>
                            <input type="url" class="form-control @error('linkedin') is-invalid @enderror"
                                id="linkedin" name="linkedin" 
                                value="{{ old('linkedin', $user->linkedin) }}"
                                placeholder="https://linkedin.com/in/username">
                            @error('linkedin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="portfolio" class="form-label">
                                <i class="fas fa-briefcase"></i> <strong>Portfolio:</strong>
                            </label>
                            <input type="url" class="form-control @error('portfolio') is-invalid @enderror"
                                id="portfolio" name="portfolio" 
                                value="{{ old('portfolio', $user->portfolio) }}"
                                placeholder="https://portfolio.com">
                            @error('portfolio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="instagram" class="form-label">
                                <i class="fab fa-instagram"></i> <strong>Instagram:</strong>
                            </label>
                            <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                id="instagram" name="instagram" 
                                value="{{ old('instagram', $user->instagram) }}"
                                placeholder="@username">
                            @error('instagram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="facebook" class="form-label">
                                <i class="fab fa-facebook"></i> <strong>Facebook:</strong>
                            </label>
                            <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                id="facebook" name="facebook" 
                                value="{{ old('facebook', $user->facebook) }}"
                                placeholder="username atau URL">
                            @error('facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Twitter dan TikTok --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="twitter" class="form-label">
                                <i class="fab fa-twitter"></i> <strong>Twitter/X:</strong>
                            </label>
                            <input type="text" class="form-control @error('twitter') is-invalid @enderror"
                                id="twitter" name="twitter" 
                                value="{{ old('twitter', $user->twitter) }}"
                                placeholder="@username">
                            @error('twitter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tiktok" class="form-label">
                                <i class="fab fa-tiktok"></i> <strong>TikTok:</strong>
                            </label>
                            <input type="text" class="form-control @error('tiktok') is-invalid @enderror"
                                id="tiktok" name="tiktok" 
                                value="{{ old('tiktok', $user->tiktok) }}"
                                placeholder="@username">
                            @error('tiktok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- CV & Surat Lamaran sejajar di bawah --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cv" class="form-label">
                                <i class="fas fa-file-alt"></i> <strong>Curriculum Vitae (CV):</strong>
                            </label>
                            <input type="file" class="form-control @error('cv') is-invalid @enderror"
                                id="cv" name="cv" accept=".pdf,.doc,.docx">
                            @error('cv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($user->cv)
                                <p class="mt-2">
                                    <a href="{{ asset('storage/'.$user->cv) }}" target="_blank" class="text-primary">
                                        <i class="fas fa-download"></i> Lihat CV Saat Ini
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cover_letter" class="form-label">
                                <i class="fas fa-envelope"></i> <strong>Surat Lamaran:</strong>
                            </label>
                            <input type="file" class="form-control @error('cover_letter') is-invalid @enderror"
                                id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx">
                            @error('cover_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($user->cover_letter)
                                <p class="mt-2">
                                    <a href="{{ asset('storage/'.$user->cover_letter) }}" target="_blank" class="text-primary">
                                        <i class="fas fa-download"></i> Lihat Surat Lamaran Saat Ini
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Informasi Tambahan</h3>
            </div>
            <div class="card-body">
                <p><strong>Tanggal Daftar:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
                <p><strong>Terakhir Login:</strong> {{ $user->last_login_at ?? '-' }}</p>
                <p><strong>ID:</strong> {{ $user->id }}</p>

                @if($user->role->name === 'company')
                    <hr>
                    <h6>Data Perusahaan</h6>
                    <p><strong>Nama Perusahaan:</strong> {{ $user->company->name ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ $user->company->address ?? '-' }}</p>
                    <p><strong>No. Telp:</strong> {{ $user->company->phone ?? '-' }}</p>
                    <p><strong>Email Kontak:</strong> {{ $user->company->email ?? '-' }}</p>
                    <p><strong>Industri:</strong> {{ $user->company->industry->name ?? '-' }}</p>
                    <p><strong>Jumlah Lowongan:</strong> {{ $user->job_posts_count ?? 0 }}</p>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2 mb-3">
            <button type="submit" class="btn btn-custom edit">
                <i class="fas fa-save"></i> Update User
            </button>
        </div>
    </form>
</div>
</div>

<script src="{{ asset('js/edituser.js') }}"></script>
@endsection
