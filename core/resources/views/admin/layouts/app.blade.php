<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DBIM') }} - Admin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#1754cf",
                        "primary-dark": "#103c96",
                        "primary-light": "#e0e7ff",
                        "accent": "#f59e0b",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Lexend', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Force Material Symbols Font */
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        :root {
            --primary-color: #1754cf;
            --primary-hover: #1346a8;
            --sidebar-width: 260px;
            --header-height: 64px;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        
        .nav-section { margin-bottom: 1.5rem; }
        
        .nav-section-title {
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9375rem;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .nav-item:hover { background: #f8fafc; color: #1e293b; }
        .nav-item.active {
            background: #eff6ff;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }
        
        .nav-icon { width: 24px; height: 24px; font-size: 24px; }
        
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }
        
        .user-name { font-weight: 600; font-size: 0.875rem; }
        .user-role { font-size: 0.75rem; color: #94a3b8; }
        
        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .admin-header {
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .header-title { font-size: 1.25rem; font-weight: 700; }
        
        .header-actions { display: flex; gap: 1rem; align-items: center; }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        .btn-primary:hover { background: var(--primary-hover); }
        
        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }
        .btn-outline:hover { background: #f8fafc; color: #1e293b; }
        
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        
        .admin-content { padding: 2rem; }
        
        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }
        
        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stat-icon.blue { background: #eff6ff; color: var(--primary-color); }
        .stat-icon.green { background: #f0fdf4; color: #22c55e; }
        .stat-icon.yellow { background: #fefce8; color: #eab308; }
        .stat-icon.red { background: #fef2f2; color: #ef4444; }
        .stat-icon.purple { background: #faf5ff; color: #a855f7; }
        
        .stat-value { font-size: 2rem; font-weight: 800; color: #1e293b; }
        .stat-label { font-size: 0.875rem; color: #64748b; margin-top: 0.25rem; }
        
        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            margin-top: 0.75rem;
        }
        
        .stat-change.up { background: #f0fdf4; color: #22c55e; }
        .stat-change.down { background: #fef2f2; color: #ef4444; }
        
        /* Data Table */
        .data-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .data-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .data-card-title { font-size: 1rem; font-weight: 700; }
        
        .data-table { width: 100%; border-collapse: collapse; }
        
        .data-table th {
            text-align: left;
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .data-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9375rem;
        }
        
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover { background: #fafafa; }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success { background: #f0fdf4; color: #22c55e; }
        .badge-warning { background: #fefce8; color: #eab308; }
        .badge-danger { background: #fef2f2; color: #ef4444; }
        .badge-info { background: #eff6ff; color: var(--primary-color); }
        
        /* Form Styles */
        .form-group { margin-bottom: 1.5rem; }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(23, 84, 207, 0.1);
        }
        
        textarea.form-input { min-height: 120px; resize: vertical; }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            color: #1e293b;
        }
        
        .mobile-menu-toggle svg {
            width: 24px;
            height: 24px;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }
        
        .sidebar-overlay.active { display: block; }
        
        .sidebar-close {
            display: none;
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
        }
        
        /* Responsive - Tablet */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .mobile-menu-toggle { display: block; }
            .sidebar-close { display: block; }
            
            .data-table th, .data-table td {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            .admin-content { padding: 1.5rem; }
            .admin-header { padding: 0 1.5rem; }
        }
        
        /* Responsive - Mobile */
        @media (max-width: 768px) {
            :root {
                --sidebar-width: 280px;
            }
            
            .admin-header {
                padding: 0 1rem;
                height: 56px;
            }
            
            .header-title { font-size: 1rem; }
            
            .admin-content { padding: 1rem; }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .stat-card { padding: 1rem; }
            .stat-value { font-size: 1.5rem; }
            
            /* Responsive Table - Horizontal Scroll */
            .data-card {
                border-radius: 0.75rem;
            }
            
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .data-table {
                min-width: 600px;
            }
            
            .data-table th, .data-table td {
                padding: 0.625rem 0.75rem;
                font-size: 0.8125rem;
                white-space: nowrap;
            }
            
            /* Buttons */
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8125rem;
            }
            
            /* Forms */
            .form-input {
                padding: 0.625rem 0.75rem;
                font-size: 0.875rem;
            }
            
            /* Hide some columns on mobile */
            .hide-mobile { display: none !important; }
            
            /* Stack form grids */
            [style*="grid-template-columns: 1fr 1fr"] {
                display: block !important;
            }
            
            [style*="grid-template-columns: 1fr 1fr"] > * {
                margin-bottom: 1rem;
            }
        }
        
        /* Responsive - Small Mobile */
        @media (max-width: 480px) {
            .admin-header {
                flex-wrap: wrap;
                height: auto;
                padding: 0.75rem 1rem;
                gap: 0.5rem;
            }
            
            .header-actions {
                width: 100%;
                justify-content: flex-end;
            }
            
            .admin-content { padding: 0.75rem; }
            
            .data-table th, .data-table td {
                padding: 0.5rem;
            }
            
            .badge {
                padding: 0.125rem 0.5rem;
                font-size: 0.6875rem;
            }
            
            .nav-item {
                padding: 0.625rem 1.25rem;
                font-size: 0.875rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="admin-sidebar" id="adminSidebar">
        <button class="sidebar-close" id="sidebarClose">&times;</button>
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="sidebar-logo">DBIM</a>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">dashboard</span>
                    Dashboard
                </a>
            </div>
            
            @php $role = Auth::user()->role ?? 'student'; @endphp

            @if(in_array($role, ['admin', 'instructor', 'media']))
            <div class="nav-section">
                <div class="nav-section-title">Content</div>
                @if(in_array($role, ['admin', 'media']))
                <a href="{{ route('events.index') }}" class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">calendar_month</span>
                    Events
                </a>
                @endif
                @if(in_array($role, ['admin', 'instructor']))
                <a href="{{ route('instructor.courses.index') }}" class="nav-item {{ request()->routeIs('instructor.courses.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">school</span>
                    Courses (LMS)
                </a>
                @endif
                @if(in_array($role, ['admin', 'media']))
                <a href="{{ route('livestream.index') }}" class="nav-item {{ request()->routeIs('livestream.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">live_tv</span>
                    Live Stream
                </a>
                @endif
            </div>
            @endif
            
            @if(in_array($role, ['admin', 'finance']))
            <div class="nav-section">
                <div class="nav-section-title">Store & Finance</div>
                <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">shopping_bag</span>
                    Products
                </a>
                <a href="{{ route('admin.finance.index') }}" class="nav-item {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">payments</span>
                    Finance
                </a>
                <a href="{{ route('admin.donations.index') }}" class="nav-item {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                     <span class="material-symbols-outlined nav-icon">volunteer_activism</span>
                    Donations
                </a>
            </div>
            @endif
            
            @if(in_array($role, ['admin', 'author']))
            <div class="nav-section">
                <div class="nav-section-title">Library</div>
                <a href="{{ route('admin.books.index') }}" class="nav-item {{ request()->routeIs('admin.books.*') && !request()->routeIs('admin.library.settings') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">menu_book</span>
                    Books
                </a>
                <a href="{{ route('admin.library.settings') }}" class="nav-item {{ request()->routeIs('admin.library.settings') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">settings_applications</span>
                    Library Settings
                </a>
            </div>
            @endif
            
            @if(in_array($role, ['admin', 'media']))
            <div class="nav-section">
                <div class="nav-section-title">Meetings</div>
                <a href="{{ route('admin.meetings.index') }}" class="nav-item {{ request()->routeIs('admin.meetings.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">video_call</span>
                    Meetings
                </a>
            </div>
            @endif
            
            @if($role === 'admin')
            <div class="nav-section">
                <div class="nav-section-title">System</div>
                <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">group</span>
                    Users
                </a>
                <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined nav-icon">settings</span>
                    Settings
                </a>
            </div>
            @endif
        </nav>

        
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-header">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>
                <h1 class="header-title">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="header-actions">
                <a href="{{ route('index') }}" class="btn btn-outline" target="_blank" title="View Site">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span class="hide-mobile">View Site</span>
                </a>
                <a href="{{ route('logout') }}" class="btn btn-outline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="hide-mobile">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </header>
        
        <main class="admin-content">
            @yield('content')
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('mobileMenuToggle');
            const close = document.getElementById('sidebarClose');

            function toggleSidebar() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
            }

            if(toggle) toggle.addEventListener('click', toggleSidebar);
            if(close) close.addEventListener('click', toggleSidebar);
            if(overlay) overlay.addEventListener('click', toggleSidebar);

            // Close sidebar on window resize if open
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024 && sidebar.classList.contains('open')) {
                    toggleSidebar();
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
