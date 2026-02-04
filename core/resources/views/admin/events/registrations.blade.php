@extends('admin.layouts.app')

@section('title', 'Event Registrations')

@section('content')
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('events.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem;">← Back to Events</a>
        <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Registrations: {{ $event->title }}</h2>
        <p style="color: #64748b; margin: 0.25rem 0 0;">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'TBA' }} • {{ $registrations->total() }} registrations</p>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registered</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                <tr>
                    <td style="font-weight: 600;">{{ $reg->name }}</td>
                    <td>{{ $reg->email }}</td>
                    <td>{{ $reg->phone ?? '-' }}</td>
                    <td>{{ $reg->created_at->format('M d, Y h:i A') }}</td>
                    <td>
                        @if($reg->status == 'confirmed')
                            <span class="badge badge-success">Confirmed</span>
                        @elseif($reg->status == 'cancelled')
                            <span class="badge" style="background: #fef2f2; color: #ef4444;">Cancelled</span>
                        @else
                            <span class="badge badge-info">Registered</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <form action="{{ route('admin.event.registrations.update', $reg->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="form-input" style="padding: 0.375rem 0.5rem; font-size: 0.8125rem; width: auto;">
                                    <option value="registered" {{ $reg->status == 'registered' ? 'selected' : '' }}>Registered</option>
                                    <option value="confirmed" {{ $reg->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $reg->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                            <form action="{{ route('admin.event.registrations.destroy', $reg->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete registration?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem; color: #94a3b8;">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📝</div>
                        No registrations yet for this event.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $registrations->links() }}
    </div>
@endsection
