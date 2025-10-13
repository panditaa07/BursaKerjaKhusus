@extends('layouts.dashboard')

<link href="{{ asset('css/dashboardcompany.css') }}" rel="stylesheet">

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
        <h3 class="section-title mb-3">Pelamar Terbaru</h3>
        <table class="table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Hp</th>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
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
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2">

                                {{-- Lihat Detail --}}
                                <a href="{{ route('company.applicants.show', $app->id) }}"
                                   class="action-mini view"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Edit Status --}}
                                <div class="dropdown">
                                    <button class="action-mini edit dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton{{ $app->id }}"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            title="Edit Status">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdownMenuButton{{ $app->id }}">
                                        @foreach ([
                                            'submitted' => ['icon' => 'fa-clock', 'label' => 'Submitted'],
                                            'test1' => ['icon' => 'fa-flask', 'label' => 'Test 1'],
                                            'test2' => ['icon' => 'fa-flask', 'label' => 'Test 2'],
                                            'interview' => ['icon' => 'fa-user-tie', 'label' => 'Interview'],
                                            'accepted' => ['icon' => 'fa-check text-success', 'label' => 'Terima'],
                                            'rejected' => ['icon' => 'fa-times text-danger', 'label' => 'Tolak']
                                        ] as $status => $info)
                                            <li>
                                                <form action="{{ route('company.applications.updateStatus', $app->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="{{ $status }}">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fa {{ $info['icon'] }} me-2"></i>{{ $info['label'] }}
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Hapus --}}
                                <form action="{{ route('company.applicants.destroy', $app->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus pelamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="action-mini delete"
                                            title="Hapus Pelamar">
                                        <i class="fas fa-trash"></i>
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
    <div class="container jobs-latest">
        <div class="jobs-header position-relative mb-3 text-center">
            <h3 class="section-title mb-0">Lowongan Terbaru</h3>
            <a href="{{ route('company.jobs.active') }}"
               class="see-all btn btn-outline-primary btn-sm position-absolute top-0 end-0">
                Lihat Semua
            </a>
        </div>

        <div class="row g-3 g-md-4">
            @forelse($recentJobs as $job)
                @php
                    $avatar = ($job->company && $job->company->user && $job->company->user->profile_photo_path)
                                ? asset('storage/' . $job->company->user->profile_photo_path)
                                : asset('images/placeholders/company-avatar.png');
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="jl-card">
                        <div class="jl-accent"></div>

                        <div class="jl-avatar js-preview"
                             data-image="{{ $avatar }}"
                             data-title="{{ $job->company->name ?? 'Logo Perusahaan' }}">
                            <img src="{{ $avatar }}"
                                 alt="{{ $job->company->name ?? 'Company' }}"
                                 class="img-thumbnail rounded-circle shadow-sm jl-avatar-img"
                                 loading="lazy" decoding="async" fetchpriority="low">
                        </div>

                        <div class="jl-body">
                            @if($job->created_at && $job->created_at->gt(now()->subDays(7)))
                                <span class="jl-ribbon">Baru</span>
                            @endif

                            <div class="jl-company">{{ $job->company->name ?? 'N/A' }}</div>
                            <a href="{{ route('company.jobs.show', $job->id) }}" class="jl-title">
                                {{ $job->title ?? '-' }}
                            </a>

                            <div class="jl-meta">
                                <span class="jl-salary">
                                    <i class="fas fa-wallet"></i>
                                    {{ $job->salary ?? 'Gaji tidak tersedia' }}
                                </span>
                                <span class="jl-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $job->created_at->diffForHumans(null, true) }}
                                </span>
                            </div>

                            <div class="jl-actions">
                                <a href="{{ route('company.jobs.show', $job->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-info-circle me-1"></i> Info
                                </a>
                                <a href="{{ route('company.jobs.edit', $job->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-pen-to-square me-1"></i> Edit
                                </a>
                                <form action="{{ route('company.jobs.destroy', $job->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="from" value="dashboard">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Belum ada lowongan</div>
            @endforelse
        </div>

        {{-- Modal Global --}}
        <div class="modal fade" id="jobImageModal" tabindex="-1" aria-labelledby="jobImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="jobImageModalLabel">Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="modal-image-frame">
                            <img id="jobImageModalImg" src="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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

    const modalEl  = document.getElementById('jobImageModal');
    const modalImg = document.getElementById('jobImageModalImg');
    const modalTit = document.getElementById('jobImageModalLabel');
    const bsModal = new bootstrap.Modal(modalEl, { backdrop: true, keyboard: true });

    document.querySelectorAll('.jobs-latest .js-preview').forEach(el => {
        el.addEventListener('click', () => {
            const src   = el.getAttribute('data-image');
            const title = el.getAttribute('data-title') || 'Logo Perusahaan';
            modalImg.src = src;
            modalImg.alt = title;
            modalTit.textContent = title;
            bsModal.show();
        });
    });
});
</script>
@endpush
