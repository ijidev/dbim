@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">All Users</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manage user accounts and roles</p>
        </div>
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
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="hide-mobile">Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 32px; height: 32px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600;">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge" style="background: #fef2f2; color: #ef4444;">Admin</span>
                            @elseif($user->role == 'instructor')
                                <span class="badge" style="background: #faf5ff; color: #a855f7;">Instructor</span>
                            @elseif($user->role == 'finance')
                                <span class="badge" style="background: #f0fdf4; color: #22c55e;">Finance</span>
                            @else
                                <span class="badge badge-info">Member</span>
                            @endif
                        </td>
                        <td class="hide-mobile">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                             <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">Edit</a>
                                <button class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;" onclick="openRoleModal({{ $user->id }}, '{{ $user->role }}')">Role</button>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #94a3b8;">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $users->links() }}
    </div>

    <!-- Role Modal -->
    <div class="modal-overlay" id="roleModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 1rem; width: 100%; max-width: 400px; padding: 2rem;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Change User Role</h3>
            <form id="roleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select name="role" id="roleSelect" class="form-input">
                        <option value="user">Member</option>
                        <option value="instructor">Instructor</option>
                        <option value="finance">Finance</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">Update Role</button>
                    <button type="button" class="btn btn-outline" onclick="closeRoleModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openRoleModal(userId, currentRole) {
        document.getElementById('roleModal').style.display = 'flex';
        document.getElementById('roleForm').action = '/admin/users/' + userId;
        document.getElementById('roleSelect').value = currentRole;
    }
    
    function closeRoleModal() {
        document.getElementById('roleModal').style.display = 'none';
    }
    
    document.getElementById('roleModal').addEventListener('click', function(e) {
        if (e.target === this) closeRoleModal();
    });
</script>
@endpush
