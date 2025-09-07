@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
<div class="container">
    <h1>Profil Saya</h1>
    
    <div class="card">
        <div class="card-header">
            <h3>Informasi Profil</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <div class="col-md-6">
                    @if(Auth::user()->cv_path)
                        <p><strong>CV:</strong> <a href="{{ Storage::url(Auth::user()->cv_path) }}" target="_blank">Lihat CV</a></p>
                    @else
                        <p><strong>CV:</strong> Belum diunggah</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-3">
                <a href="{{ route('profile.upload-cv') }}" class="btn btn-primary">Upload CV</a>
                <a href="{{ route(match(auth()->user()->role ?? 'user') { 'admin' => 'admin.dashboard.index', 'company' => 'company.dashboard.index', default => 'user.dashboard.index' }) }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
