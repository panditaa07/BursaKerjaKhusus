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
                        <td>{{ $app->jobPost->company?->name ?? '-' }}</td>
                        <td>{{ $app->jobPost->title ?? '-' }}</td>
                        <td>{{ $app->status ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.applications.show', $app->id) }}" class="btn btn-sm btn-primary action-btn">👁</a>
                            <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this application?')">🗑</button>
                            </form>
                            <a href="{{ route('admin.applications.edit', $app->id) }}" class="btn btn-sm btn-warning action-btn">✏️</a>
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
                        <td>{{ $job->company?->name ?? '-' }}</td>
                        <td>{{ $job->no_hrd ?? '-' }}</td>
                        <td>{{ $job->alamat ?? $job->location ?? '-' }}</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <a href="{{ route('admin.job-posts.show', $job->id) }}" class="btn btn-sm btn-primary action-btn">👁</a>
                            <form action="{{ route('admin.job-posts.destroy', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this job post?')">🗑</button>
                            </form>
                            <a href="{{ route('admin.job-posts.edit', $job->id) }}" class="btn btn-sm btn-warning action-btn">✏️</a>
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