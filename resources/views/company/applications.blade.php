@extends('layouts.dashboard')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-header h1 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1f2937;
    }

    .card-header p {
        margin-top: 0.25rem;
        color: #6b7280;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: #f9fafb;
    }

    th {
        padding: 0.75rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        color: #111827;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    .status {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 9999px;
    }

    .status.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status.accepted {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status.rejected {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn {
        border: none;
        background: none;
        font-size: 0.875rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .btn.accept {
        color: #16a34a;
    }

    .btn.accept:hover {
        color: #15803d;
    }

    .btn.reject {
        color: #dc2626;
    }

    .btn.reject:hover {
        color: #b91c1c;
    }

    .empty {
        text-align: center;
        color: #6b7280;
        padding: 1rem;
    }

    .pagination {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Daftar Lamaran Perusahaan</h1>
            <p>Kelola lamaran yang masuk untuk lowongan Anda</p>
        </div>

        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Lowongan</th>
                        <th>Tanggal Melamar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>
                                <div>
                                    <div style="font-weight:500;">{{ $application->user->name }}</div>
                                    <div style="color:#6b7280; font-size:0.875rem;">{{ $application->user->email }}</div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $application->jobPost->title }}</div>
                                <div style="color:#6b7280; font-size:0.875rem;">{{ $application->jobPost->company->name }}</div>
                            </td>
                            <td style="color:#6b7280;">
                                {{ $application->created_at->format('d M Y, H:i') }}
                            </td>
                            <td>
                                <span class="status {{ $application->status }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <a href="{{ route('company.applications.preview', $application) }}" 
                                       target="_blank" 
                                       class="btn" 
                                       style="color: #3b82f6; text-decoration: none;">
                                        📄 Preview CV
                                    </a>
                                    
                                    <form action="{{ route('company.applications.updateStatus', $application) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')

                                        @if($application->status != 'accepted')
                                            <button type="submit" name="status" value="accepted" class="btn accept"
                                                onclick="return confirm('Apakah Anda yakin ingin menerima lamaran ini?')">
                                                ✔ Terima
                                            </button>
                                        @endif

                                        @if($application->status != 'rejected')
                                            <button type="submit" name="status" value="rejected" class="btn reject"
                                                onclick="return confirm('Apakah Anda yakin ingin menolak lamaran ini?')">
                                                ✖ Tolak
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada lamaran yang masuk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($applications->hasPages())
            <div class="pagination">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
