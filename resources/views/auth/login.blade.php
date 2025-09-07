@extends('layouts.guest')

@section('content')
<style>
    body { font-family: Arial, sans-serif; background-color: #f4f6f8; }
    .container { margin-top: 50px; }
    .card { border: none; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .card-header { background-color: #007bff; color: white; font-size: 18px; font-weight: bold; padding: 15px; border-top-left-radius: 10px; border-top-right-radius: 10px; }
    .card-body { padding: 30px; background-color: white; }
    label { font-weight: bold; color: #555; }
    .form-control { border-radius: 6px; padding: 10px; border: 1px solid #ccc; transition: 0.3s; }
    .form-control:focus { border-color: #007bff; box-shadow: 0 0 4px rgba(0,123,255,0.4); }
    .btn-primary { background-color: #007bff; border: none; border-radius: 6px; padding: 10px 15px; font-weight: bold; transition: 0.3s; }
    .btn-primary:hover { background-color: #0056b3; }
    .invalid-feedback { color: red; font-size: 14px; }
    p a { color: #007bff; text-decoration: none; font-weight: bold; }
    p a:hover { text-decoration: underline; }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('authenticate') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                            </div>
                        </div>

                        <div class="row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <p class="mb-0">
                                    {{ __("Don't have an account?") }}
                                    <a href="{{ route('register') }}">{{ __('Register here') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
