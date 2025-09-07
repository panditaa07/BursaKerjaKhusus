@extends('layouts.app')

@section('content')
    <h2>Edit Lamaran</h2>

    {{-- Error --}}
    @if ($errors->any())
        <div style="color: red; background: #ffecec; padding: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lamarans.update', $lamaran->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_pelamar">Nama Pelamar</label><br>
            <input type="text" name="nama_pelamar" id="nama_pelamar" 
                   value="{{ old('nama_pelamar', $lamaran->nama_pelamar) }}" required>
        </div>

        <div>
            <label for="lowongan">Lowongan</label><br>
            <input type="text" name="lowongan" id="lowongan" 
                   value="{{ old('lowongan', $lamaran->lowongan) }}" required>
        </div>

        <div>
            <label for="cv">Upload CV (PDF/DOC/DOCX)</label><br>
            <input type="file" name="cv" id="cv">
            @if($lamaran->cv)
                <p>CV sekarang: <a href="{{ asset('storage/'.$lamaran->cv) }}" target="_blank">Lihat CV</a></p>
            @endif
        </div>

        <button type="submit">Update Lamaran</button>
        <a href="{{ route('lamarans.index') }}">Batal</a>
    </form>
@endsection
