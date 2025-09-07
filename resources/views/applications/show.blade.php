@extends('layouts.dashboard')

@section('title', 'Detail Lamaran')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Lamaran</h4>
        </div>
        <div class="card-body">
            {{-- Info Pelamar --}}
            <h5 class="mb-3">📄 Informasi Pelamar</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $application->user ? $application->user->name : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $application->user ? $application->user->email : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>CV</th>
                    <td>
                        @if($application->cv_path)
                            <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="btn btn-sm btn-success">
                                📂 Lihat CV
                            </a>
                        @else
                            <span class="text-muted">Belum mengunggah CV</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Info Pekerjaan --}}
            <h5 class="mt-4 mb-3">💼 Informasi Pekerjaan</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Posisi</th>
                    <td>{{ $application->jobPost ? $application->jobPost->title : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Perusahaan</th>
                    <td>{{ $application->jobPost && $application->jobPost->company ? $application->jobPost->company->name : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Status Lamaran</th>
                    <td>
                        @if($application->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($application->status === 'accepted')
                            <span class="badge bg-success">Diterima</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Cover Letter --}}
            <h5 class="mt-4 mb-3">📝 Surat Lamaran</h5>
            <div class="border rounded p-3" style="min-height: 100px;">
                {!! nl2br(e($application->cover_letter ?? 'Tidak ada surat lamaran yang diberikan.')) !!}
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">⬅ Kembali</a>
        </div>
    </div>
</div>
@endsection
