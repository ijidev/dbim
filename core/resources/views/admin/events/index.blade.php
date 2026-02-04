@extends('admin.layouts.app')

@section('title', 'Events')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">All Events</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manage church events and programs</p>
        </div>
        <a href="{{ route('events.create') }}" class="btn btn-primary">+ Create Event</a>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date & Time</th>
                        <th class="hide-mobile">Location</th>
                        <th class="hide-mobile">Type</th>
                        <th class="hide-mobile">Status</th>
                        <th>RSVPs</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $event->title }}</div>
                        </td>
                        <td>
                            <div>{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'TBA' }}</div>
                            <div style="font-size: 0.8125rem; color: #64748b;">{{ $event->time ?? '' }}</div>
                        </td>
                        <td class="hide-mobile">{{ $event->location ?? '-' }}</td>
                        <td class="hide-mobile"><span class="badge badge-info">{{ ucfirst($event->type) }}</span></td>
                        <td class="hide-mobile">
                            @if($event->status == 'comming')
                                <span class="badge badge-success">Upcoming</span>
                            @else
                                <span class="badge" style="background: #f1f5f9; color: #64748b;">Passed</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight: 600;">{{ $event->registrations()->count() ?? 0 }}</span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.event.registrations', $event->id) }}" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;" title="View RSVPs">RSVPs</a>
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">Edit</a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete this event?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 3rem; color: #94a3b8;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📅</div>
                            No events found. <a href="{{ route('events.create') }}" style="color: var(--primary-color); font-weight: 600;">Create your first event</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $events->links() }}
    </div>
@endsection
