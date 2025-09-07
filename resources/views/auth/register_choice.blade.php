@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Register as</h2>
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ url('/register/admin') }}" class="btn btn-primary btn-lg">Admin</a>
        <a href="{{ url('/register/company') }}" class="btn btn-success btn-lg">Company</a>
        <a href="{{ url('/register/user') }}" class="btn btn-info btn-lg">User</a>
    </div>
</div>
@endsection
