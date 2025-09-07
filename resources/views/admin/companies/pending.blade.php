@extends('layouts.dashboard')

@section('title', 'Pending Companies')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Pending Companies</h1>

    @if($pendingCompanies->isEmpty())
        <div class="alert alert-info">No pending companies to display.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingCompanies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->email }}</td>
                    <td><span class="badge badge-warning">Pending Verification</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
