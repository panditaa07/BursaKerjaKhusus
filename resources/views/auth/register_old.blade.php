@extends('layouts.guest')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f8;
    }
    .container {
        margin-top: 50px;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .card-body {
        padding: 30px;
        background-color: white;
    }
    label {
        font-weight: bold;
        color: #555;
    }
    .form-control {
        border-radius: 6px;
        padding: 10px;
        border: 1px solid #ccc;
        transition: 0.3s;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0,123,255,0.4);
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 6px;
        padding: 10px 15px;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .invalid-feedback {
        color: red;
        font-size: 14px;
    }
    p a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }
    p a:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}" required autofocus>

                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Register as') }}</label>
                            <div class="col-md-6">
                                <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">-- Select Role --</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="company" {{ old('role') == 'company' ? 'selected' : '' }}>Company</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>

                                @error('role')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- NIK/NISN (hanya muncul kalau role=user) --}}
                        <div class="row mb-3" id="nik-nisn-field" style="display: none;">
                            <label for="nik_nisn" class="col-md-4 col-form-label text-md-end">{{ __('NIK/NISN') }}</label>
                            <div class="col-md-6">
                                <input id="nik_nisn" type="text" 
                                    class="form-control @error('nik_nisn') is-invalid @enderror" 
                                    name="nik_nisn" value="{{ old('nik_nisn') }}">

                                @error('nik_nisn')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required>

                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" 
                                    class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        {{-- Link ke login --}}
                        <div class="row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <p class="mb-0">
                                    {{ __('Already have an account?') }}
                                    <a href="{{ route('login') }}">{{ __('Login here') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk tampilkan NIK/NISN kalau pilih User --}}
<script>
    document.getElementById('role').addEventListener('change', function () {
        let field = document.getElementById('nik-nisn-field');
        if (this.value === 'user') {
            field.style.display = 'flex';
        } else {
            field.style.display = 'none';
        }
    });

    // auto-trigger kalau ada old value (misal setelah validation error)
    window.addEventListener('DOMContentLoaded', function () {
        let role = document.getElementById('role').value;
        if (role === 'user') {
            document.getElementById('nik-nisn-field').style.display = 'flex';
        }
    });
</script>
@endsection