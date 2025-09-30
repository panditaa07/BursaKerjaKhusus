{{-- Updated Blade Template --}}
@extends('layouts.guest')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
<!-- Animated background particles -->
<div class="particles" id="particles"></div>

<div class="register-container">
    <div class="container">
        <div class="register-card mx-auto">
            <h1 class="main-title">Choose Your Role</h1>
            <p class="subtitle">Select the type of account you'd like to create</p>
            
            <div class="role-buttons">

                
                <a href="{{ url('/register/company') }}" class="role-btn company-btn" data-role="company">
                    <i class="fas fa-building role-icon"></i>
                    <div class="role-title">Company</div>
                    <div class="role-description">Create and manage business profiles</div>
                </a>
                
                <a href="{{ url('/register/user') }}" class="role-btn user-btn" data-role="user">
                    <i class="fas fa-user role-icon"></i>
                    <div class="role-title">User</div>
                    <div class="role-description">Access services and features</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/register.js') }}"></script>
@endpush
