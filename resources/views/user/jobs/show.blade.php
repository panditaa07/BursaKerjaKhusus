@extends('layouts.dashboard')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
    }

    .job-detail {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .job-detail h1 {
        margin-top: 0;
        color: #2c3e50;
    }

    .job-detail p {
        color: #555;
        font-size: 1rem;
        line-height: 1.5;
    }

    form {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    label {
        font-weight: bold;
        color: #333;
        font-size: 0.95rem;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    input[type="file"] {
        border: none;
        background: #f0f0f0;
        padding: 6px;
        border-radius: 6px;
    }

    button {
        padding: 10px 15px;
        border: none;
        background: #3498db;
        color: white;
        font-size: 0.95rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    button:hover {
        background: #217dbb;
    }

    .login-prompt {
        margin-top: 15px;
        color: #555;
    }

    .login-prompt a {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .login-prompt a:hover {
        text-decoration: underline;
    }
</style>

<div class="job-detail">
    <h1>{{ $job->title }}</h1>
    <p>{{ $job->description }}</p>
    @if($job->company)
        <small>Perusahaan: {{ $job->company->name }}</small>
    @endif

    @auth
        <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="job_post_id" value="{{ $job->id }}">
            <label>Cover letter</label>
            <textarea name="cover_letter">{{ old('cover_letter') }}</textarea>

            <label>Upload CV (PDF) — optional</label>
            <input type="file" name="cv" accept="application/pdf">

            <button type="submit">Apply</button>
        </form>
    @else
        <p class="login-prompt">
            <a href="{{ route('login') }}">Login</a> untuk melamar pekerjaan ini
        </p>
    @endauth
</div>
@endsection
