@extends('layouts.dashboard')

@section('title', 'Lamaran Saya - BKK OPAT')

@section('content')
@if(auth()->user()->role === 'user')
<div class="bg-light min-vh-100 py-4">
    <div class="container-fluid px-4">
        <!-- Search Bar -->
        <div class="mb-4">
            <form method="GET" action="{{ route('user.applications.index') }}" class="w-100">
                <div class="position-relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan perusahaan atau posisi..." class="form-control form-control-lg rounded-pill shadow-sm border-0 ps-5">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </form>
        </div>

        <!-- Main Layout -->
        <div class="row g-4">
            <!-- Table Section -->
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white border-0">
                        <h4 class="card-title mb-0 text-primary">
                            <i class="fas fa-file-alt"></i>
                            Lamaran Saya
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($applications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead class="table-dark" style="background-color: #0d47a1;">
                                        <tr>
                                            <th class="px-4 py-3 text-white fw-bold">Perusahaan</th>
                                            <th class="px-4 py-3 text-white fw-bold">Posisi</th>
                                            <th class="px-4 py-3 text-white fw-bold">Status</th>
                                            <th class="px-4 py-3 text-white fw-bold">Tanggal Melamar</th>
                                            <th class="px-4 py-3 text-white fw-bold">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $application)
                                            <tr class="border-bottom border-secondary-subtle" style="background-color: #ffffff;" onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='#ffffff'">
                                                <td class="px-4 py-3">{{ $application->jobPost->company->name ?? 'Unknown Company' }}</td>
                                                <td class="px-4 py-3">{{ $application->jobPost->title }}</td>
                                                <td class="px-4 py-3">
                                                    @if(in_array($application->status, ['submitted', 'test1', 'test2']))
                                                        <span class="badge bg-primary fw-bold rounded-pill px-3 py-2">Proses</span>
                                                    @elseif($application->status === 'interview')
                                                        <span class="badge bg-primary fw-bold rounded-pill px-3 py-2">Wawancara</span>
                                                    @elseif($application->status === 'accepted')
                                                        <span class="badge bg-success fw-bold rounded-pill px-3 py-2">Diterima</span>
                                                    @elseif($application->status === 'rejected')
                                                        <span class="badge bg-danger fw-bold rounded-pill px-3 py-2">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-secondary fw-bold rounded-pill px-3 py-2">{{ ucfirst($application->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">{{ $application->created_at->format('d M Y') }}</td>
                                                <td class="px-4 py-3">
                                                    <a href="{{ route('user.applications.show', $application) }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $applications->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada lamaran</h5>
                                <p class="text-muted">Anda belum mengajukan lamaran apapun. Mulai lamar pekerjaan sekarang!</p>
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary px-4 py-2">Cari Lowongan</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Notifications -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold">Notifikasi</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="overflow-auto" style="max-height: 400px;">
                            @if($notifications->count() > 0)
                                @foreach($notifications as $notification)
                                    <div class="border border-secondary-subtle rounded-lg p-3 mb-3 shadow-sm">
                                        <p class="mb-1 small">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                        <p class="text-muted small mb-0">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted small">Tidak ada notifikasi baru.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-file-alt"></i>
                            Lamaran Saya
                        </h4>
                    </div>
                    <div class="card-body">
                        <p>Halaman ini hanya untuk role USER.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
