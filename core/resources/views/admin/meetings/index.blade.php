@extends('admin.layouts.app')

@section('title', 'Meeting Management')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Video Meetings</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manage ongoing and scheduled sessions</p>
        </div>
        <a href="{{ route('meeting.create') }}" class="btn btn-primary" target="_blank">+ New Meeting</a>
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
                        <th>Title</th>
                        <th>Host</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="hide-mobile">Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meetings as $meeting)
                    <tr>
                        <td style="font-weight: 600;">{{ $meeting->title }}</td>
                        <td>{{ $meeting->host->name ?? 'Unknown' }}</td>
                        <td>
                            <span class="badge {{ $meeting->type === 'instant' ? 'badge-primary' : 'badge-outline' }}">
                                {{ ucfirst($meeting->type) }}
                            </span>
                        </td>
                        <td>
                            @if($meeting->status === 'active')
                                <span class="badge badge-success">Active</span>
                            @elseif($meeting->status === 'ended')
                                <span class="badge badge-danger">Ended</span>
                            @else
                                <span class="badge badge-outline">Pending</span>
                            @endif
                        </td>
                        <td class="hide-mobile">{{ $meeting->created_at->format('M d, H:i') }}</td>
                        <td style="display: flex; gap: 0.5rem;">
                            @if($meeting->status !== 'ended')
                                <a href="{{ route('meeting.room', $meeting->room_code) }}" class="btn btn-outline" target="_blank" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">Join</a>
                                <form action="{{ route('admin.meetings.end', $meeting) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Force end this meeting?')">End</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.meetings.destroy', $meeting) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete this record?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 4rem; color: #94a3b8;">
                            <div style="font-size: 2.5rem; margin-bottom: 1rem;">📹</div>
                            No meetings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $meetings->links() }}
    </div>
@endsection
