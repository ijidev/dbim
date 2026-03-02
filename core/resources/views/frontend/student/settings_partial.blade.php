{{-- Settings Partial (loaded via AJAX into profile settings tab) --}}
<div class="max-w-4xl mx-auto w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Settings Nav -->
        <div class="lg:col-span-3 space-y-2">
            <button class="settings-nav-item active w-full" onclick="switchSettingsTab('general', this)">
                <span class="material-symbols-outlined">person</span>
                General
            </button>
            <button class="settings-nav-item w-full" onclick="switchSettingsTab('security', this)">
                <span class="material-symbols-outlined">lock</span>
                Security
            </button>
            <button class="settings-nav-item w-full" onclick="switchSettingsTab('notifications', this)">
                <span class="material-symbols-outlined">notifications</span>
                Notifications
            </button>
        </div>
        
        <!-- Settings Content -->
        <div class="lg:col-span-9">
            <!-- General Tab -->
            <div id="settings-tab-general" class="settings-inner-tab">
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
                                        <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover" id="avatar-preview">
                                    @else
                                        <span id="avatar-initials">{{ substr(Auth::user()->name, 0, 2) }}</span>
                                    @endif
                                </div>
                                <label for="avatar-input" class="absolute bottom-0 right-0 size-8 bg-primary text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-primary-dark transition-colors shadow-lg">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </label>
                                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewAvatarFile(this)">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900">Upload new image</h3>
                                <p class="text-sm text-slate-500 mb-3">Max file size 2MB. JPG, PNG supported.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Personal Info -->
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                        <h2 class="text-lg font-bold text-slate-900 mb-6">Personal Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[13px] font-bold text-slate-500 uppercase tracking-wide mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-900 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-[13px] font-bold text-slate-500 uppercase tracking-wide mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-900 opacity-70 cursor-not-allowed" disabled>
                                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">lock</span>
                                    Contact support to change email
                                </p>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-[13px] font-bold text-slate-500 uppercase tracking-wide mb-2">Bio</label>
                            <textarea name="bio" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-900 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all leading-relaxed resize-none" placeholder="Tell us about yourself...">{{ Auth::user()->bio }}</textarea>
                            <p class="text-xs text-slate-400 mt-2">Brief description for your profile. URLs are hyperlinked.</p>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 bg-primary text-white font-bold px-6 py-3 rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Security Tab -->
            <div id="settings-tab-security" class="settings-inner-tab hidden">
                <form action="{{ route('student.password.update') }}" method="POST" class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                    @csrf
                    @method('post')
                    
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-2">Change Password</h2>
                        <p class="text-slate-500 text-sm mb-6">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    
                    <div>
                        <label class="block text-[13px] font-bold text-slate-500 uppercase tracking-wide mb-2">Current Password</label>
                        <input type="password" name="current_password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-900 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all" required>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[13px] font-bold text-slate-500 uppercase tracking-wide mb-2">New Password</label>
                            <input type="password" name="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-900 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="block text-[13px] font-bold text-slate-500 uppercase tracking-wide mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-900 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all" required>
                        </div>
                    </div>
                    
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 bg-primary text-white font-bold px-6 py-3 rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Notifications Tab -->
            <div id="settings-tab-notifications" class="settings-inner-tab hidden">
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
</div>

<script>
    function switchSettingsTab(tabId, btn) {
        document.querySelectorAll('.settings-inner-tab').forEach(tab => tab.classList.add('hidden'));
        document.getElementById('settings-tab-' + tabId).classList.remove('hidden');
        document.querySelectorAll('.settings-nav-item').forEach(item => item.classList.remove('active'));
        btn.classList.add('active');
    }

    function previewAvatarFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const container = input.closest('.relative').querySelector('.size-24');
                const existingImg = container.querySelector('img');
                const initials = container.querySelector('#avatar-initials');
                if (existingImg) {
                    existingImg.src = e.target.result;
                } else {
                    if (initials) initials.remove();
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    img.id = 'avatar-preview';
                    container.appendChild(img);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
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
</style>
