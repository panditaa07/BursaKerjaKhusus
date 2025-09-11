@extends('layouts.dashboard')

@section('title', 'Edit Biodata - BKK OPAT')

@section('content')
<div class="bg-light min-vh-100 py-4">
    <div class="container-fluid px-4">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-0">
                <h4 class="card-title mb-0 text-primary">
                    <i class="fas fa-user-edit"></i>
                    Edit Biodata
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold">Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('profile.index') }}" class="btn btn-secondary rounded-pill px-4 py-2 fw-bold ms-2">
                        Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
