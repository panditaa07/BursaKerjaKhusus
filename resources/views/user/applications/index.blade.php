@extends('layouts.dashboard')

@section('title', 'Lamaran Saya - BKK OPAT')

@section('content')
<link rel="stylesheet" href="{{ asset('css/lamaran.css') }}">
<div class="bg-light min-vh-100 py-4">
    <div class="container-fluid px-4">
        <!-- Search Bar -->
        <div class="mb-4">
    <form method="GET" action="{{ url('/user/applications') }}" class="d-flex align-items-center justify-content-center gap-2">
        <div class="position-relative" style="width: 60%;">
            <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari berdasarkan perusahaan atau posisi..."
                class="form-control rounded-pill shadow-sm border-0 ps-5" style="height: 42px;">
        </div>
        <button type="submit" class="btn btn-primary rounded-pill fw-semibold px-4 py-2 d-flex align-items-center">
            <i class="fas fa-search me-2"></i> Cari
        </button>
    </form>
</div>


        <!-- Main Layout -->
        <div class="row g-4">
            <!-- Table Section -->
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header border-0">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-file-alt"></i>
                            Lamaran Saya
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($applications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead class="table">
                                        <tr>
                                            <th class="px-4 py-3 text-blue ">Perusahaan</th>
                                            <th class="px-4 py-3 text-blue ">Posisi</th>
                                            <th class="px-4 py-3 text-blue ">Status</th>
                                            <th class="px-4 py-3 text-blue ">Tanggal Melamar</th>
                                            <th class="px-4 py-3 text-blue ">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $application)
                                            <tr class="border-bottom border-secondary-subtle" style="background-color: #ffffff;" onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='#ffffff'">
                                                <td class="px-4 py-3 company-name-cell">{{ Str::limit($application->jobPost->company->name ?? 'Unknown Company', 30, '...') }}</td>
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
                                                <td class="px-4 py-3 text-center">
                                                    <a href="{{ route('user.applications.show', $application) }}" 
                                                       class="btn btn-primary d-flex align-items-center justify-content-center gap-2 rounded-pill px-4 py-2 fw-bold"
                                                       style="transition: background-color 0.3s;">
                                                        <i class="fas fa-eye"></i><span>Lihat</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                          <div class="pagination-custom">
    <ul class="pagination">
        {{-- Tombol Previous --}}
        @if ($applications->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $applications->previousPageUrl() }}" rel="prev">Previous</a>
            </li>
        @endif

        {{-- Tombol Next --}}
        @if ($applications->hasMorePages())
            <li class="page-item">
                <a class="page-link active" href="{{ $applications->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif
    </ul>
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
                    <div class="card-header border-0">
                        <h5 class="mb-0 fw-bold">Notifikasi</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="overflow-auto" style="max-height: 400px;">
                            @if($notifications->count() > 0)
                                @foreach($notifications as $notification)
                                    <div class="border border-secondary-subtle rounded-lg p-3 mb-3 shadow-sm">
                                        <p class="mb-1 small">
                                            {{ $notification->data['message'] ?? 'New notification' }}
                                        </p>
                                        <p class="text-muted small mb-2">
                                            {{ optional($notification->created_at)->diffForHumans() }}
                                        </p>

                                        @if(is_null($notification->read_at))
                                            <a href="{{ route('notifications.read', $notification->id) }}" 
                                            class="btn btn-sm btn-primary">
                                            Tandai Sudah Dibaca
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted small">Tidak ada notifikasi baru.</p>
                            @endif
                            <div class="text-center mt-2">
                                <a href="{{ route('notifications.index') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                                    Lihat Semua Notifikasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/lamaran.js') }}"></script>
@endsection
