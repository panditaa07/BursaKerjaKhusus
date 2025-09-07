@extends('layouts.app')

@section('content')
    <h2>Detail Lamaran</h2>

    <p><strong>Nama Pelamar:</strong> {{ $lamaran->nama_pelamar }}</p>
    <p><strong>Lowongan:</strong> {{ $lamaran->lowongan }}</p>
    <p><strong>Status:</strong> {{ $lamaran->status }}</p>
    <p>
        <strong>CV:</strong>
        @if($lamaran->cv)
            <a href="{{ asset('storage/'.$lamaran->cv) }}" target="_blank">Lihat CV</a>
        @else
            Belum upload
        @endif
    </p>

    <a href="{{ route('lamarans.index') }}">← Kembali</a>
@endsection
