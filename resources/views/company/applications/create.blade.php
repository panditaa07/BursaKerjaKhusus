@extends('layouts.app')

@section('content')
    <h2>Tambah Lamaran</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div style="color: red; background: #ffecec; padding: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lamarans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="nama_pelamar">Nama Pelamar</label><br>
            <input type="text" name="nama_pelamar" id="nama_pelamar" value="{{ old('nama_pelamar') }}" required>
        </div>

        <div>
            <label for="lowongan">Lowongan</label><br>
            <input type="text" name="lowongan" id="lowongan" value="{{ old('lowongan') }}" required>
        </div>

        <div>
            <label for="cv">Upload CV (PDF/DOC/DOCX)</label><br>
            <input type="file" name="cv" id="cv" required>
        </div>

        <button type="submit">Kirim Lamaran</button>
        <a href="{{ route('lamarans.index') }}">Batal</a>
    </form>
@endsection
