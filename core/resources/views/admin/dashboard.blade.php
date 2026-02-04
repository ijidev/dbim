@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">{{ \App\Models\Event::count() }}</div>
                    <div class="stat-label">Total Events</div>
                </div>
                <div class="stat-icon blue">📅</div>
            </div>
            <span class="stat-change up">↑ Active</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">{{ \App\Models\Course::count() }}</div>
                    <div class="stat-label">Courses</div>
                </div>
                <div class="stat-icon green">📚</div>
            </div>
            <span class="stat-change up">↑ Published</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">{{ \App\Models\User::count() }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-icon purple">👥</div>
            </div>
            <span class="stat-change up">↑ Growing</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">{{ \App\Models\Product::count() }}</div>
                    <div class="stat-label">Products</div>
                </div>
                <div class="stat-icon yellow">🛒</div>
            </div>
            <span class="stat-change up">In Store</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">{{ \App\Models\Book::count() }}</div>
                    <div class="stat-label">Books</div>
                </div>
                <div class="stat-icon blue">📖</div>
            </div>
            <span class="stat-change up">In Library</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-header">
                <div>
                    <div class="stat-value">₦0</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-icon green">💰</div>
            </div>
            <span class="stat-change up">↑ This Month</span>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="data-card" style="margin-bottom: 2rem;">
        <div class="data-card-header">
            <h3 class="data-card-title">Quick Actions</h3>
        </div>
        <div style="padding: 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem;">
            <a href="{{ route('events.create') }}" class="btn btn-primary">+ New Event</a>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">+ New Course</a>
            <a href="{{ route('livestream.index') }}" class="btn btn-outline">📹 Manage Live Stream</a>
            <a href="{{ route('users.index') }}" class="btn btn-outline">👥 Manage Users</a>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="data-card">
        <div class="data-card-header">
            <h3 class="data-card-title">Recent Users</h3>
            <a href="{{ route('users.index') }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8125rem;">View All</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="hide-mobile">Email</th>
                        <th>Role</th>
                        <th class="hide-mobile">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                    <tr>
                        <td style="font-weight: 600;">{{ $user->name }}</td>
                        <td class="hide-mobile">{{ $user->email }}</td>
                        <td><span class="badge badge-info">{{ ucfirst($user->role) }}</span></td>
                        <td class="hide-mobile">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
