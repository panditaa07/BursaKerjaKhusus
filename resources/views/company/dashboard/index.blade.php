@extends('layouts.dashboard')

@section('content')
    {{-- === Statistics Cards === --}}
    <div class="row">

        {{-- Total Pelamar --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('company.pelamar.all') }}" class="stat-link">
                <div class="card stat-card border-left-primary shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pelamar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['total_applications'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Pelamar Bulan Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('company.applications.this_month') }}" class="stat-link">
                <div class="card stat-card border-left-success shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pelamar Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['applications_this_month'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Lowongan Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('company.jobs.active') }}" class="stat-link">
                <div class="card stat-card border-left-info shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lowongan Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['active_jobs'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Lowongan Tidak Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('company.jobs.inactive') }}" class="stat-link">
                <div class="card stat-card border-left-warning shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Lowongan Tidak Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['inactive_jobs'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- === Tabel Pelamar Terbaru === --}}
    <div class="container table-section">
        <h3 class="mb-3">Pelamar Terbaru</h3>
        <table class="table table-hover modern-table">
            <thead>
                <tr>
                    <th>No</th><th>Nama</th><th>Email</th><th>No Hp</th>
                    <th>Lowongan</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentApplications as $index => $app)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $app->user->name ?? '-' }}</td>
                        <td>{{ $app->user->email ?? '-' }}</td>
                        <td>{{ $app->user->phone ?? '-' }}</td>
                        <td>{{ $app->jobPost->title ?? '-' }}</td>
                        <td>
                            @php
                                $status = $app->status;
                                $statusConfig = [
                                    'accepted' => ['label' => 'Terima', 'class' => 'status-accepted'],
                                    'rejected' => ['label' => 'Tolak', 'class' => 'status-rejected'],
                                    'interview' => ['label' => 'Wawancara', 'class' => 'status-interview'],
                                    'test1' => ['label' => 'Test 1', 'class' => 'status-test'],
                                    'test2' => ['label' => 'Test 2', 'class' => 'status-test'],
                                    'submitted' => ['label' => 'Menunggu', 'class' => 'status-pending'],
                                    'reviewed' => ['label' => 'Menunggu', 'class' => 'status-pending'],
                                ];
                                $currentStatus = $statusConfig[$status] ?? ['label' => ucfirst($status), 'class' => 'bg-light text-dark'];
                            @endphp
                            <span class="badge {{ $currentStatus['class'] }} px-3 py-2">
                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                {{ $currentStatus['label'] }}
                            </span>
                        </td>
                        <td>{{ $app->created_at->format('d-m-Y') }}</td>
                        <td>
                            <div class="action-buttons d-flex gap-1 justify-content-center">
                                <!-- Detail -->
                                <a href="{{ route('company.applicants.show', $app->id) }}"
                                   class="btn btn-sm btn-primary" title="Lihat Detail">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <!-- Edit Status Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-warning dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton{{ $app->id }}"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            title="Edit Status">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdownMenuButton{{ $app->id }}">
                                        <li>
                                            <form action="{{ route('company.applications.updateStatus', $app->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="submitted">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-clock me-2"></i>Submitted
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('company.applications.updateStatus', $app->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="test1">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-flask me-2"></i>Test 1
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('company.applications.updateStatus', $app->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="test2">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-flask me-2"></i>Test 2
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('company.applications.updateStatus', $app->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="interview">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa fa-user-tie me-2"></i>Interview
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('company.applications.updateStatus', $app->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fa fa-check me-2"></i>Terima
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('company.applications.updateStatus', $app->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa fa-times me-2"></i>Tolak
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Hapus -->
                                <form action="{{ route('company.applicants.destroy', $app->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus pelamar ini?')"
                                            title="Hapus Pelamar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">Belum ada pelamar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- === Lowongan Terbaru Cards === --}}
    <div class="container">
        <h3 class="mb-3">Lowongan Terbaru</h3>
        <div class="row">
            @forelse($recentJobs as $job)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <!-- Company Profile Photo -->
                        <div class="text-center p-3 bg-light">
                            @if($job->company && $job->company->user && $job->company->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $job->company->user->profile_photo_path) }}"
                                     alt="{{ $job->company->name }} Profile Photo"
                                     class="company-logo rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            @else
                                <div class="company-logo-placeholder rounded-circle d-inline-flex align-items-center justify-content-center bg-primary text-white"
                                     style="width: 80px; height: 80px; font-size: 2rem; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $job->company->name ?? 'N/A' }}</h5>
                            <h6 class="card-subtitle mb-2 text-success text-center">{{ $job->title ?? '-' }}</h6>
                            <p class="card-text text-muted text-center">{{ $job->salary ?? 'Gaji tidak tersedia' }}</p>
                            <p class="card-text text-center"><small class="text-muted">Skrg waktu {{ $job->created_at->diffForHumans(null, true) }}</small></p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('company.jobs.show', $job->id) }}" class="btn btn-info btn-sm">Info</a>
                                <a href="{{ route('company.jobs.edit', $job->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('company.jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="from" value="dashboard">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Belum ada lowongan</div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function animateNumbers() {
            const numbers = document.querySelectorAll('.stat-number');
            numbers.forEach(number => {
                const finalNumber = parseInt(number.textContent, 10);
                if (isNaN(finalNumber)) return;

                let currentNumber = 0;
                const increment = Math.max(1, Math.ceil(finalNumber / 100)); // Animate over ~100 frames

                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= finalNumber) {
                        currentNumber = finalNumber;
                        clearInterval(timer);
                    }
                    number.textContent = currentNumber;
                }, 20); // Update every 20ms
            });
        }

        animateNumbers();
    });
</script>
@endpush
