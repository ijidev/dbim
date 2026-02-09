@extends('layouts.app')

@section('title', 'Settings - Grace LMS')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 {
        font-variation-settings: 'FILL' 1;
    }
    
    .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .settings-nav-item:hover, .settings-nav-item.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.2s;
    }
    
    .form-input:focus {
        background: white;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(23, 84, 207, 0.1);
        outline: none;
    }
    
    .btn-save {
        background: var(--primary);
        color: white;
        font-weight: 700;
        padding: 12px 24px;
        border-radius: 12px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-save:hover {
        background: #1346b0;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(23, 84, 207, 0.3);
    }
</style>
@endpush

@section('content')
<div class="flex h-[calc(100vh-64px)] overflow-hidden bg-[#f6f6f8]">
    <!-- Sidebar -->
    <aside class="hidden lg:flex w-72 flex-col border-r border-slate-200 bg-white h-full shrink-0">
        <nav class="flex-1 px-6 py-8 space-y-2">
            <a href="{{ route('student.dashboard') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('student.catalog') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">book_2</span>
                <span>Course Catalog</span>
            </a>
            <a href="{{ route('student.learning') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">school</span>
                <span>My Learning</span>
            </a>
            <a href="{{ route('calendar') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">groups</span>
                <span>Community</span>
            </a>
        </nav>
        
        <div class="p-6 border-t border-slate-100">
            <a href="{{ route('student.profile') }}" class="flex items-center gap-4 p-2 hover:bg-slate-50 rounded-xl transition-colors group">
                <div class="size-11 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-xs border border-primary/20 group-hover:bg-primary group-hover:text-white transition-colors">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="flex flex-col">
                    <p class="text-sm font-black text-slate-900 group-hover:text-primary transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">View Profile</p>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto px-6 lg:px-12 py-10 max-w-5xl mx-auto w-full">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Settings</h1>
                <p class="text-slate-500 font-medium mt-1">Manage your account preferences and personal information.</p>
            </div>
            <a href="{{ route('student.profile') }}" class="text-slate-500 hover:text-primary font-bold text-sm flex items-center gap-2 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Profile
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Settings Nav -->
            <div class="lg:col-span-3 space-y-2">
                <button class="settings-nav-item active w-full" onclick="switchTab('general', this)">
                    <span class="material-symbols-outlined">person</span>
                    General
                </button>
                <button class="settings-nav-item w-full" onclick="switchTab('security', this)">
                    <span class="material-symbols-outlined">lock</span>
                    Security
                </button>
                <button class="settings-nav-item w-full" onclick="switchTab('notifications', this)">
                    <span class="material-symbols-outlined">notifications</span>
                    Notifications
                </button>
            </div>
            
            <!-- Settings Content -->
            <div class="lg:col-span-9">
                <!-- General Tab -->
                <div id="tab-general" class="settings-tab">
                    <form action="{{ route('student.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="section" value="general">
                        
                        <!-- Avatar -->
                        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                            <h2 class="text-lg font-bold text-slate-900 mb-6">Profile Picture</h2>
                            <div class="flex items-center gap-6">
                                <div class="relative group">
                                    <div class="size-24 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-3xl font-black overflow-hidden border-4 border-white shadow-lg">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr(Auth::user()->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <label for="avatar-input" class="absolute bottom-0 right-0 size-8 bg-primary text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-primary-dark transition-colors shadow-lg">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </label>
                                    <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-slate-900">Upload new image</h3>
                                    <p class="text-sm text-slate-500 mb-3">Max file size 2MB. JPG, PNG supported.</p>
                                    <button type="button" class="text-red-500 text-sm font-bold hover:underline">Remove Image</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Personal Info -->
                        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                            <h2 class="text-lg font-bold text-slate-900 mb-6">Personal Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-input">
                                </div>
                                <div>
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-input" disabled style="opacity: 0.7; cursor: not-allowed;">
                                    <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">lock</span>
                                        Contact support to change email
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" rows="4" class="form-input leading-relaxed" placeholder="Tell us about yourself...">{{ Auth::user()->bio }}</textarea>
                                <p class="text-xs text-slate-400 mt-2">Brief description for your profile. URLs are hyperlinked.</p>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="btn-save">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Security Tab -->
                <div id="tab-security" class="settings-tab hidden">
                    <form action="{{ route('student.settings.password') }}" method="POST" class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 mb-2">Change Password</h2>
                            <p class="text-slate-500 text-sm mb-6">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                        
                        <div>
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-input" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-input" required>
                            </div>
                        </div>
                        
                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="btn-save">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Notifications Tab -->
                <div id="tab-notifications" class="settings-tab hidden">
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                         <div class="text-center py-12">
                             <div class="size-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                 <span class="material-symbols-outlined text-3xl">notifications_off</span>
                             </div>
                             <h3 class="text-lg font-bold text-slate-900 mb-2">Notification Preferences</h3>
                             <p class="text-slate-500">This feature involves backend mailer configuration and is coming soon.</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    function switchTab(tabId, btn) {
        // Hide all tabs
        document.querySelectorAll('.settings-tab').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Show selected tab
        document.getElementById('tab-' + tabId).classList.remove('hidden');
        
        // Update nav buttons
        document.querySelectorAll('.settings-nav-item').forEach(item => {
            item.classList.remove('active');
        });
        btn.classList.add('active');
    }
    
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Find the image element and set src
                // This is a simple implementation, ideally specific ID targeting
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
