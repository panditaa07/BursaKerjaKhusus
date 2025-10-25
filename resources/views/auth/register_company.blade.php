@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register-company.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="registration-wrapper">
    <div class="registration-container">
        <div class="form-header">
            <h2>Buat Akun Perusahaan</h2>
            <p>Bergabunglah dengan kami dan mulailah perjalanan bisnis Anda</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="list-style: none; margin: 0; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom: 5px;">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/register/company') }}" id="registrationForm">
            @csrf
            
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="company_name">Nama Perusahaan</label>
                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" required>
                <span class="password-toggle" title="Show password">
                    <i class="fas fa-eye-slash"></i>
                </span>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                <span class="password-toggle" title="Show password">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="btn-text">Daftar</span>
                <div class="loading-spinner"></div>
            </button>
        </form>

        <div class="login-link text">
            Sudah punya akun? <a href="{{ route('login') }}" class="signin-link">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/register-company.js') }}"></script>
@endsection
