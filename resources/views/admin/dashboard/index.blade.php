@extends('layouts.dashboard')

@section('content')
    {{-- === Statistics Cards === --}}
    <div class="row">
        {{-- Total Pelamar --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('admin.dashboard.pelamar') }}" class="stat-link">
                <div class="card stat-card border-left-primary shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pelamar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['total_pelamar'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Pelamar Bulan Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('admin.dashboard.pelamar.bulanini') }}" class="stat-link">
                <div class="card stat-card border-left-success shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pelamar Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['pelamar_bulan_ini'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Lowongan Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('admin.dashboard.lowongan-aktif') }}" class="stat-link">
                <div class="card stat-card border-left-info shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lowongan Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['lowongan_aktif'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Lowongan Tidak Aktif --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('admin.dashboard.lowongan-tidak-aktif') }}" class="stat-link">
                <div class="card stat-card border-left-warning shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Lowongan Tidak Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 stat-number">{{ $statistics['lowongan_tidak_aktif'] ?? 0 }}</div>
                        </div>
                        <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- === Charts Section === --}}
    <div class="row mb-4">
        {{-- Line Chart: Pelamar Bulan Ini --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card chart-card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pelamar Bulan Ini</h6>
                </div>
                <div class="card-body">
                    <canvas id="pelamarChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Bar Chart: Lowongan Aktif --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card chart-card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Lowongan Aktif</h6>
                </div>
                <div class="card-body">
                    <canvas id="lowonganChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Pie Chart: Status Lamaran --}}
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card chart-card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Status Lamaran</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- === Tabel Pelamar === --}}
    <div class="container table-section">
        <h3 class="mb-3">Daftar Pelamar Terbaru</h3>
        <table class="table table-hover modern-table">
            <thead>
                <tr>
                    <th>No</th><th>Nama</th><th>Email</th><th>No Hp</th>
                    <th>Perusahaan</th><th>Lowongan</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($daftar_pelamar_terbaru as $index => $app)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $app->user->name ?? '-' }}</td>
                        <td>{{ $app->user->email ?? '-' }}</td>
                        <td>{{ $app->user->phone ?? '-' }}</td>
                        <td>{{ $app->jobPost->company->name ?? '-' }}</td>
                        <td>{{ $app->jobPost->title ?? '-' }}</td>
                        <td>
                            @if($app->status === 'accepted')
                                <span class="badge bg-success">Accepted</span>
                            @elseif($app->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @elseif($app->status === 'submitted')
                                <span class="badge bg-warning text-dark">Submitted</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($app->status ?? '-') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.show', $app->id) }}" class="table-btn view">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="_from" value="dashboard">
                                <button type="submit" class="table-btn delete" onclick="return confirm('Yakin hapus pelamar ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.applications.edit', $app->id) }}" class="table-btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">Belum ada pelamar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- === Tabel Loker Aktif === --}}
    <div class="container table-section">
        <h3 class="mb-3">Loker Terbaru</h3>
        <table class="table table-hover modern-table">
            <thead>
                <tr>
                    <th>No</th><th>Perusahaan</th><th>No HRD</th><th>Alamat</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loker_terbaru as $index => $job)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $job->company->name ?? '-' }}</td>
                        <td>{{ $job->no_hrd ?? '-' }}</td>
                        <td>{{ $job->alamat ?? $job->location ?? '-' }}</td>
                        <td>
                            @if($job->status === 'active')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.job-posts.show', $job->id) }}" class="table-btn view">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-btn delete" onclick="return confirm('Yakin hapus loker ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="table-btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada loker aktif</td></tr>
                @endforelse
            </tbody>
        </table>
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
                const increment = Math.max(1, Math.ceil(finalNumber / 100));

                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= finalNumber) {
                        currentNumber = finalNumber;
                        clearInterval(timer);
                    }
                    number.textContent = currentNumber;
                }, 20);
            });
        }
        animateNumbers();

        // Sample data - replace with real data from controller
        const pelamarData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            datasets: [{
                label: 'Pelamar',
                data: [12, 19, 3, 5, 2, 3, {{ $statistics['pelamar_bulan_ini'] ?? 0 }}],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        };

        const lowonganData = {
            labels: ['Aktif', 'Tidak Aktif'],
            datasets: [{
                label: 'Lowongan',
                data: [{{ $statistics['lowongan_aktif'] ?? 0 }}, {{ $statistics['lowongan_tidak_aktif'] ?? 0 }}],
                backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)']
            }]
        };

        const statusData = {
            labels: ['Submitted', 'Accepted', 'Rejected'],
            datasets: [{
                data: [{{ $statistics['submitted'] ?? 10 }}, {{ $statistics['accepted'] ?? 5 }}, {{ $statistics['rejected'] ?? 3 }}],
                backgroundColor: ['rgba(255, 206, 86, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(255, 99, 132, 0.8)']
            }]
        };

        // Pelamar Line Chart
        const pelamarCtx = document.getElementById('pelamarChart').getContext('2d');
        new Chart(pelamarCtx, {
            type: 'line',
            data: pelamarData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Lowongan Bar Chart
        const lowonganCtx = document.getElementById('lowonganChart').getContext('2d');
        new Chart(lowonganCtx, {
            type: 'bar',
            data: lowonganData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Status Pie Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush
