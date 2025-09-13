@extends('layouts.dashboard')

@section('title', 'Semua Notifikasi')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 fw-bold">Semua Notifikasi</h5>
        </div>
        <div class="card-body p-3">
            <div class="overflow-auto" style="max-height: 600px;">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="border border-secondary-subtle rounded-lg p-3 mb-3 shadow-sm">
                            <p class="mb-1 small">
                                {{ $notification->message ?? 'Notifikasi baru' }}
                            </p>
                            <p class="text-muted small mb-2">
                                {{ optional($notification->created_at)->diffForHumans() }}
                            </p>

                            @if(!$notification->is_read)
                                <a href="{{ route('notifications.read', $notification->id) }}" 
                                   class="btn btn-sm btn-primary">
                                   Tandai Sudah Dibaca
                                </a>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted small">Tidak ada notifikasi baru.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
