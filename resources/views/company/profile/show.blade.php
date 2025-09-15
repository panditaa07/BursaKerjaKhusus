@extends('layouts.dashboard')

@section('title', 'Profil Perusahaan')

@section('content')
<div class="container">
    <h1>Profil Perusahaan</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Informasi Perusahaan</h3>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-pencil-alt me-1"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama PIC:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email PIC:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>No. HP PIC:</strong> {{ Auth::user()->phone ?? '-' }}</p>
                    <p><strong>Alamat PIC:</strong> {{ Auth::user()->address ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nama Perusahaan:</strong> {{ Auth::user()->company->name ?? '-' }}</p>
                    <p><strong>Alamat Perusahaan:</strong> {{ Auth::user()->company->address ?? '-' }}</p>
                    <p><strong>No. Telp Perusahaan:</strong> {{ Auth::user()->company->phone ?? '-' }}</p>
                    <p><strong>Email Kontak:</strong> {{ Auth::user()->company->email ?? '-' }}</p>
                    <p><strong>Industri:</strong> {{ Auth::user()->company->industry->name ?? '-' }}</p>
                    <p><strong>Deskripsi:</strong> {{ Auth::user()->company->description ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-3">
                <p><strong>Logo Perusahaan:</strong><br>
                    @if(Auth::user()->company && Auth::user()->company->logo)
                        <img src="{{ asset('storage/' . Auth::user()->company->logo) }}" alt="Logo" style="max-width: 150px;">
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
