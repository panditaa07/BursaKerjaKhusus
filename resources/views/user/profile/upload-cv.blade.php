@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Upload CV</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('profile.upload-cv.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="cv">Select CV (PDF only, max 2MB):</label>
            <input type="file" name="cv" id="cv" class="form-control" required>
            @error('cv')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
