<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'DBIM')) - Divine Business Impact Ministry</title>

    <!-- Meta Tags -->
    <meta name="description" content="Divine Business Impact Ministry (DBIM) - Empowering believers for spiritual and kingdom impact.">
    <meta name="keywords" content="Church, Ministry, DBIM, Spiritual Growth, Live Stream, LMS, Christian Books">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'DBIM')">
    <meta property="og:description" content="Divine Business Impact Ministry (DBIM) - Empowering believers for spiritual and kingdom impact.">
    <meta property="og:image" content="{{ asset('assets/images/og-image.jpg') }}">

    <!-- Fonts -->
    <!-- CDNs -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#1754cf",
                        "primary-dark": "#103c96",
                        "primary-light": "#e0e7ff",
                        "accent": "#f59e0b",
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
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
            /* Palette (Main) */
            --primary: #1754cf;
            --primary-dark: #103c96;
            --primary-light: #e0e7ff;
            --accent: #f59e0b;
            --danger: #ef4444;
            --success: #10b981;
            
            /* Aliases for wider compatibility */
            --primary-color: var(--primary);
            --primary-color-dark: var(--primary-dark);
            --primary-color-light: var(--primary-light);
            --secondary-color: var(--accent);
            
            /* Backgrounds */
            --bg-body: #f8fafc;
            --bg-surface: #ffffff;
            --bg-glass: rgba(255, 255, 255, 0.95);
            
            /* Text */
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            
            /* UI */
            --radius-sm: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            
            --container-width: 1200px;
        }

        /* Dropdown Styles */
        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        /* Reset & Base */
        *, *::before, *::after { box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; transition: all 0.2s ease; }
        ul { list-style: none; padding: 0; margin: 0; }
        img { max-width: 100%; display: block; }
        
        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.025em;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            border: none;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(23, 84, 207, 0.3);
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }

        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: var(--text-main);
        }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }

        .btn-ghost {
            background: transparent;
            color: var(--text-muted);
        }
        .btn-ghost:hover { background: var(--primary-light); color: var(--primary); }

        /* Navigation */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            height: 72px;
            display: flex;
            align-items: center;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--text-muted);
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -24px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
        }

        /* Live Indicator */
        .live-badge {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--danger);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Mobile Menu */
        .mobile-toggle { display: none; font-size: 1.5rem; color: var(--text-main); cursor: pointer; }
        #nav-check { display: none; }

        @media (max-width: 1024px) {
            .nav-links {
                position: fixed;
                top: 72px;
                left: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                align-items: flex-start;
                padding: 1.5rem;
                gap: 1.5rem;
                transform: translateY(-150%);
                transition: transform 0.3s ease;
                box-shadow: var(--shadow-lg);
                z-index: 90;
            }
            .mobile-toggle { display: block; }
            #nav-check:checked ~ .nav-links {
                transform: translateY(0);
            }
            .nav-link.active::after { display: none; }
        }

        /* Footer */
        .site-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 4rem 0 2rem;
            margin-top: 4rem;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }
        .footer-col h4 { color: white; margin-bottom: 1.5rem; }
        .footer-link { display: block; margin-bottom: 0.75rem; }
        .footer-link:hover { color: white; }
        .copyright {
            border-top: 1px solid #1e293b;
            padding-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar">
            <div class="container nav-container">
                <a href="{{ route('index') }}" class="logo">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    DBIM
                </a>

                <input type="checkbox" id="nav-check">
                
                <div class="nav-links">
                    <a href="{{ route('index') }}" class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                    <a href="{{ route('event') }}" class="nav-link {{ request()->routeIs('event') ? 'active' : '' }}">Events</a>
                    <a href="{{ route('live') }}" class="nav-link {{ request()->routeIs('live') ? 'active' : '' }}">
                        <div class="live-badge">
                            <span class="live-dot"></span>
                            Live
                        </div>
                    </a>
                    <a href="{{ route('calendar') }}" class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">Calendar</a>
                    <a href="{{ route('store.index') }}" class="nav-link {{ request()->routeIs('store.*') ? 'active' : '' }}">Store</a>
                    <a href="{{ route('library.index') }}" class="nav-link {{ request()->routeIs('library.*') ? 'active' : '' }}">Library</a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
                        <a href="{{ route('donate') }}" class="btn btn-primary">
                            <span>❤️</span> Give
                        </a>
                    @else
                        <div style="position: relative;" class="user-dropdown">
                            <button class="btn btn-ghost dropdown-trigger" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600;">
                                👤 {{ Auth::user()->name }}
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: white; border-radius: 0.75rem; box-shadow: var(--shadow-lg); min-width: 200px; padding: 0.5rem; z-index: 200; border: 1px solid #e2e8f0;">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('home') }}" class="dropdown-item">🛠️ Admin Dashboard</a>
                                @elseif(Auth::user()->role === 'instructor')
                                    <a href="{{ route('home') }}" class="dropdown-item">📋 Instructor Panel</a>
                                @else
                                    <a href="{{ route('student.courses') }}" class="dropdown-item">🎓 My Courses</a>
                                @endif
                                <a href="{{ route('profile.show') ?? '#' }}" class="dropdown-item">👤 Profile</a>
                                <div style="height: 1px; background: #e2e8f0; margin: 0.5rem 0;"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color: var(--danger); width: 100%; text-align: left; background: none; border: none; font: inherit; cursor: pointer;">🚪 Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <label for="nav-check" class="mobile-toggle">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                </label>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-col" style="flex: 1.5;">
                        <h4 style="color: white; font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem;">DBIM</h4>
                        <p style="font-size: 1.125rem; font-style: italic; color: var(--primary-light); margin-bottom: 1rem; line-height: 1.4;">"Raising gods from amongst men on earth for Christ"</p>
                        <p>Empowering believers for spiritual and kingdom impact through digital innovation and timeless truth.</p>
                    </div>
                    <div class="footer-col">
                        <h4>Quick Links</h4>
                        <a href="{{ route('event') }}" class="footer-link">Upcoming Events</a>
                        <a href="{{ route('live') }}" class="footer-link">Live Stream</a>
                        <a href="{{ route('store.index') }}" class="footer-link">Store</a>
                        <a href="{{ route('contact') }}" class="footer-link">Contact Us</a>
                    </div>
                    <div class="footer-col">
                        <h4>Connect</h4>
                        <a href="#" class="footer-link">Facebook</a>
                        <a href="#" class="footer-link">YouTube</a>
                        <a href="#" class="footer-link">Instagram</a>
                    </div>
                </div>
                <div class="copyright">
                    &copy; {{ date('Y') }} Divine Business Impact Ministry. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownTrigger = document.querySelector('.dropdown-trigger');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            if (dropdownTrigger && dropdownMenu) {
                dropdownTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
                });

                document.addEventListener('click', function() {
                    dropdownMenu.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>
