@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edituser.css') }}">
<div class="container-fluid">
    <h1 class="h3 mb-4">Edit User</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No HP</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nisn" class="form-label">NIK/NISN</label>
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                   id="nisn" name="nisn" value="{{ old('nisn', $user->nisn) }}">
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                   id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="user" {{ old('role', $user->role->name) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="company" {{ old('role', $user->role->name) == 'company' ? 'selected' : '' }}>Company</option>
                                <option value="admin" {{ old('role', $user->role->name) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', !$user->deleted_at ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', !$user->deleted_at ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update User
                            </button>
                            @include('components.back-button')
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Created:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Last Updated:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
                    <p><strong>ID:</strong> {{ $user->id }}</p>
                    
                    @if($user->role == 'company' && $user->company)
                        <hr>
                        <h6>Company Details</h6>
                        <p><strong>Company Name:</strong> {{ $user->company->name ?? 'N/A' }}</p>
                        <p><strong>Company Status:</strong> 
                            <span class="badge bg-{{ $user->company->is_verified ? 'success' : 'warning' }}">
                                {{ $user->company->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/edituser.js') }}"></script>
@endsection
