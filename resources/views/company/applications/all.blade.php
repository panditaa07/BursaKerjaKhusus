@extends('layouts.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/kelolapelamarcom.css') }}">

@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">Semua Pelamar</h2>
            <div class="d-flex align-items-center">
                <a href="{{ route('company.applications.this_month') }}" class="btn btn-primary me-2">
                    <i class="fas fa-calendar-alt me-2"></i>Pelamar Bulan Ini
                </a>
                <div class="text-muted">
                    <i class="fas fa-users me-2"></i>
                    Total Pelamar: <strong>{{ $applications->total() }}</strong>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('company.pelamar.all') }}" class="mb-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari pelamar berdasarkan nama, lowongan, atau status..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('company.pelamar.all') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        <!-- Filter Buttons -->
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('company.pelamar.all', array_merge(request()->query(), ['filter' => 'new'])) }}"
                   class="btn {{ request('filter') === 'new' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-user-plus me-2"></i>Pelamar Baru
                </a>
                <a href="{{ route('company.pelamar.all', array_merge(request()->query(), ['filter' => 'process'])) }}"
                   class="btn {{ request('filter') === 'process' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-cogs me-2"></i>Pelamar Dalam Proses
                </a>
                <a href="{{ route('company.pelamar.all', array_merge(request()->query(), ['filter' => 'all'])) }}"
                   class="btn {{ !request('filter') || request('filter') === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-users me-2"></i>Total Pelamar
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm company-applications-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 company-applications-table">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-bold text-center" width="60">No</th>
                                <th class="border-0 fw-bold">Nama</th>
                                <th class="border-0 fw-bold">Email</th>
                                <th class="border-0 fw-bold">No. Hp</th>
                                <th class="border-0 fw-bold">Lowongan yang dilamar</th>
                                <th class="border-0 fw-bold text-center" width="120">Status</th>
                                <th class="border-0 fw-bold text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $application)
                                <tr>
                                    <td class="text-center text-muted fw-bold">{{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper me-3">
                                                @if($application->user->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}"
                                                         class="rounded-circle" width="40" height="40" alt="Avatar">
                                                @else
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px; font-size: 14px; font-weight: bold;">
                                                        {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $application->user->name }}</div>
                                                <small class="text-muted">ID: {{ $application->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        {{ $application->user->email }}
                                    </td>
                                    <td>
                                        <i class="fas fa-phone text-muted me-2"></i>
                                        {{ $application->user->phone ?? '-' }}
                                    </td>
                                    <td>
                                        <i class="fas fa-briefcase text-muted me-2"></i>
                                        {{ $application->jobPost->title ?? 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $status = $application->status;
                                            $statusConfig = [
                                                'accepted' => ['label' => 'Terima', 'class' => 'status-accepted'],
                                                'rejected' => ['label' => 'Tolak', 'class' => 'status-rejected'],
                                                'interview' => ['label' => 'Wawancara', 'class' => 'status-interview'],
                                                'test1' => ['label' => 'Test 1', 'class' => 'status-test'],
                                                'test2' => ['label' => 'Test 2', 'class' => 'status-test'],
                                                'submitted' => ['label' => 'Menunggu', 'class' => 'status-pending'],
                                                'reviewed' => ['label' => 'Ditinjau', 'class' => 'status-reviewed'],
                                            ];
                                            $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-light text-dark'];
                                        @endphp
                                        <span class="badge {{ $currentStatus['class'] }} px-3 py-2">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <!-- View Detail -->
                                            <a href="{{ route('company.applications.show.company', $application->id) }}"
                                               class="btn btn-sm btn-outline-info"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit Status -->
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-warning dropdown-toggle"
                                                        type="button"
                                                        id="dropdownMenuButton{{ $application->id }}"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        title="Ubah Status">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton{{ $application->id }}">
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="submitted">
                                                            <button type="submit" class="dropdown-item">
                                                                Submitted
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="test1">
                                                            <button type="submit" class="dropdown-item">
                                                                Test 1
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="test2">
                                                            <button type="submit" class="dropdown-item">
                                                                Test 2
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="interview">
                                                            <button type="submit" class="dropdown-item">
                                                                Interview
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="accepted">
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fas fa-check-circle me-2"></i>Terima
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-times-circle me-2"></i>Tolak
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Delete Application -->
                                            <form action="{{ route('company.applications.destroy', $application->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus lamaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Lamaran">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p class="mb-0">Belum ada lamaran</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($applications->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

   <script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan Bootstrap sudah aktif
    if (typeof bootstrap !== 'undefined') {
        document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
            // Inisialisasi dropdown Bootstrap
            new bootstrap.Dropdown(toggle, { autoClose: false });
        });
    }

    // Cegah dropdown langsung tertutup ketika klik di dalam menu
    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
        menu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });

    // Pastikan form bisa dikirim tanpa gangguan dropdown
    document.querySelectorAll('.dropdown-menu form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.stopPropagation(); // cegah dropdown nutup duluan
            this.submit(); // kirim form normal
        });
    });
});
</script>

@endsection