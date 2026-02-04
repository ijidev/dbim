@extends('layouts.app')

@section('title', 'Meetings')

@push('styles')
<style>
    .meeting-container {
        max-width: 900px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    .meeting-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .meeting-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .meeting-info h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem;
    }
    .meeting-meta {
        font-size: 0.875rem;
        color: #64748b;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-active { background: #f0fdf4; color: #22c55e; }
    .status-pending { background: #fefce8; color: #eab308; }
    .status-ended { background: #f1f5f9; color: #64748b; }
</style>
@endpush

@section('content')
<div class="meeting-container">
    <div class="meeting-header">
        <h1 style="font-size: 2rem; font-weight: 800; color: #1e293b;">My Meetings</h1>
        <a href="{{ route('meeting.create') }}" style="background: var(--primary-color); color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none;">+ New Meeting</a>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($meetings as $meeting)
        <div class="meeting-card">
            <div class="meeting-info">
                <h3>{{ $meeting->title }}</h3>
                <div class="meeting-meta">
                    <span>Room: <strong>{{ $meeting->room_code }}</strong></span>
                    @if($meeting->scheduled_at)
                        <span> • {{ $meeting->scheduled_at->format('M d, Y h:i A') }}</span>
                    @endif
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span class="status-badge status-{{ $meeting->status }}">{{ ucfirst($meeting->status) }}</span>
                @if($meeting->status !== 'ended')
                    <a href="{{ route('meeting.room', $meeting->room_code) }}" style="background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;">Join</a>
                @endif
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 4rem; background: white; border: 1px dashed #cbd5e1; border-radius: 1rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📹</div>
            <h3 style="color: #1e293b; margin-bottom: 0.5rem;">No Meetings Yet</h3>
            <p style="color: #64748b; margin-bottom: 1.5rem;">Create your first meeting to get started.</p>
            <a href="{{ route('meeting.create') }}" style="background: var(--primary-color); color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none;">Create Meeting</a>
        </div>
    @endforelse

    {{ $meetings->links() }}
</div>
@endsection
