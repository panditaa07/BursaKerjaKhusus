@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register-admin.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="gradient-text">Register as Admin</span>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/register/admin') }}" id="registerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Full Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>
                            <div class="password-field">
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror" 
                                       required>
                                <span class="password-toggle" title="Show password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="error-message show">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="password-field">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="form-control" 
                                       required>
                                <span class="password-toggle" title="Show password">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <span class="btn-text">Register</span>
                            <div class="loading-spinner"></div>
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Already have an account? 
                            <a href="{{ url('/login') }}" class="text-decoration-none">Sign in here</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/register-admin.js') }}"></script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            if (window.RegisterAdmin) {
                window.RegisterAdmin.showSuccess();
            }
        }, 500);
    });
</script>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($errors->keys() as $field)
            const field_{{ $loop->index }} = document.getElementById('{{ $field }}');
            if (field_{{ $loop->index }}) {
                field_{{ $loop->index }}.classList.add('invalid');
            }
        @endforeach
    });
</script>
@endif
@endsection