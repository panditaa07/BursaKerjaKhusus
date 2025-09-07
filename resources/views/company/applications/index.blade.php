@extends('layouts.dashboard')

@section('content')
    <h2>Daftar Lamaran</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding:10px; margin-bottom:15px; border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelamar</th>
                <th>Lowongan</th>
                <th>CV</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $application->user->name }}</td>
                    <td>{{ $application->jobPost->title }}</td>
                    <td>
                        @if($application->cv_path)
                            <a href="{{ route('company.applications.preview', $application->id) }}" target="_blank">Lihat CV</a>
                        @else
                            Belum upload
                        @endif
                    </td>
                    <td>{{ $application->status }}</td>
                    <td style="white-space:nowrap;">
                        <a href="{{ route('applications.show', $application->id) }}">Detail</a> |

                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" style="color:green;">Terima</button>
                        </form>

                        <form action="{{ route('company.applications.updateStatus', $application->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" style="color:red;">Tolak</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">Belum ada lamaran</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
