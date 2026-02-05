@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <div style="max-width: 600px;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('users.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                ← Back to Users
            </a>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Edit User: {{ $user->name }}</h2>
        </div>

        @if($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="data-card" style="padding: 2rem;">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">User Role</label>
                    <select name="role" class="form-input">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Member</option>
                        <option value="instructor" {{ $user->role == 'instructor' ? 'selected' : '' }}>Instructor</option>
                        <option value="finance" {{ $user->role == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
