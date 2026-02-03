@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Events</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('events.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-lg"></i> Create Event
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Status</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->date }} {{ $event->time }}</td>
                <td>
                    <span class="badge bg-{{ $event->status == 'comming' ? 'primary' : 'secondary' }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </td>
                <td>{{ ucfirst($event->type) }}</td>
                <td>
                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No events found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $events->links() }}
</div>
@endsection
