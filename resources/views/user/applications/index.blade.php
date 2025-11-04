@extends('layouts.dashboard')

@section('title', 'Lamaran Saya - BKK OPAT')

@section('content')
<link rel="stylesheet" href="{{ asset('css/lamaran.css') }}">
    <div class="container-fluid px-4">

        <!-- 🔍 Search Bar -->
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

            <!-- 📋 Tabel Lamaran -->
            <div class="col-lg-12 table-card">
                <div class="card shadow-sm border-0 rounded-lg">
                        @if($applications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless lamaran-table">
                                    <thead>
                                        <tr>
                                            <th>Perusahaan</th>
                                            <th>Posisi</th>
                                            <th>Status</th>
                                            <th>Tanggal Melamar</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $application)
                                            <tr>
                                                <td data-label="Perusahaan">{{ $application->jobPost->company->name ?? 'Unknown Company' }}</td>
                                                <td data-label="Posisi">{{ $application->jobPost->title }}</td>
                                                <td data-label="Status">
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
                                                <td data-label="Tanggal Melamar">{{ $application->created_at->format('d M Y') }}</td>
                                                <td data-label="Detail">
                                                    <a href="{{ route('user.applications.show', $application) }}"
                                                       class="btn btn-primary d-flex align-items-center justify-content-center gap-2 rounded-pill px-3 py-2 fw-bold btn-detail">
                                                        <span>Lihat</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

<!-- Pagination -->
@if ($applications->total() > 10)
    <div class="pagination-custom">
        <ul class="pagination">
            {{-- Tombol Previous --}}
            @if ($applications->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
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
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </div>
@endif

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
        </div>
    </div>
</div>

<script src="{{ asset('js/lamaran.js') }}"></script>
@endsection