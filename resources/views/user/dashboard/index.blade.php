@extends('layouts.dashboard')
@section('title', 'User Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Welcome User</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2 class="h4 mb-4">Lowongan Terbaru</h2>
        </div>
    </div>

    <div class="row">
        <!-- Sample Lowongan Cards -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="card-img-top" alt="PT Kaizen Jaya Abadi" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">Operator Produksi</h5>
                    <p class="card-text text-muted">PT Kaizen Jaya Abadi</p>
                    <p class="text-muted small">📍 Kabupaten - Sukabumi</p>
                    <p class="text-muted small">💰 Rp 3.500.000 - Rp 4.000.000</p>
                    <p class="text-muted small">👥 25 orang, lulusan semua jurusan SMK</p>
                    <a href="#" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="card-img-top" alt="PT Kaizen Jaya Abadi" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">Staff Administrasi</h5>
                    <p class="card-text text-muted">PT Kaizen Jaya Abadi</p>
                    <p class="text-muted small">📍 Kabupaten - Sukabumi</p>
                    <p class="text-muted small">💰 Rp 4.000.000 - Rp 4.500.000</p>
                    <p class="text-muted small">👥 5 orang, lulusan OTKP/AKL</p>
                    <a href="#" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" class="card-img-top" alt="PT Kaizen Jaya Abadi" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">Teknisi Mesin</h5>
                    <p class="card-text text-muted">PT Kaizen Jaya Abadi</p>
                    <p class="text-muted small">📍 Kabupaten - Sukabumi</p>
                    <p class="text-muted small">💰 Rp 4.500.000 - Rp 5.000.000</p>
                    <p class="text-muted small">👥 10 orang, lulusan TMI/TKJ</p>
                    <a href="#" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
