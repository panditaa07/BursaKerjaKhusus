@extends('layouts.dashboard')

@section('title', 'Kelola Data Lowongan Kerja')

@section('content')
    <h2>Kelola Data Lowongan Kerja</h2>
    <a href="{{ route('admin.jobs.create') }}">+ Tambah Lowongan</a>

    <table border="1" cellpadding="10" cellspacing="0" style="margin-top:10px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Pekerjaan</th>
                <th>Perusahaan</th>
                <th>Lokasi</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Dummy data untuk contoh --}}
            <tr>
                <td>1</td>
                <td>Web Developer</td>
                <td>PT Maju Jaya</td>
                <td>Jakarta</td>
                <td>Full-time</td>
                <td>Aktif</td>
                <td>
                    <a href="#">Edit</a> | <a href="#">Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
