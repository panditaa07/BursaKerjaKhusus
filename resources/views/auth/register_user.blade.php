@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register-user.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register as User</div>
                <div class="card-body">
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

                    <form method="POST" action="{{ url('/register/user') }}" id="registrationForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nisn">NIK/NISN</label>
                            <input type="text" id="nisn" name="nisn" class="form-control" value="{{ old('nisn') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <div class="password-field">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <span class="password-toggle" title="Show password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="password-field">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                <span class="password-toggle" title="Show password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-info">
                            <span class="btn-text">Register</span>
                            <div class="loading-spinner"></div>
                        </button>
                    </form>

                    <div class="login-link">
                        Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/register-user.js') }}"></script>
@endsection