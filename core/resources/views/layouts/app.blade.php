<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'DBIM')) - Destiny Blessings int'l Ministry</title>

    <!-- Meta Tags -->
    <meta name="description" content="Destiny Blessings int'l Ministry (DBIM) - Empowering believers for spiritual and kingdom impact.">
    <meta name="keywords" content="Church, Ministry, DBIM, Spiritual Growth, Live Stream, LMS, Christian Books">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'DBIM')">
    <meta property="og:description" content="Destiny Blessings int'l Ministry (DBIM) - Empowering believers for spiritual and kingdom impact.">
    <meta property="og:image" content="{{ asset('assets/images/og-image.jpg') }}">

    <!-- CDNs -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0f49bd",
                        "primary-dark": "#103c96",
                        "primary-light": "#e0e7ff",
                        "accent": "#f59e0b",
                        "accent-gold": "#D4AF37",
                        "background-light": "#f6f6f8",
                        "background-dark": "#05070a",
                        "surface-dark": "#101622",
                        "border-dark": "#1d2533",
                        "highlight-gold": "#ffd700",
                        "highlight-blue": "#93c5fd",
                        "highlight-green": "#86efac",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                        "serif": ["Lora", "serif"],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
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

        html, body {
            overflow-x: clip;
            max-width: 100%;
            width: 100%;
            position: relative;
            margin: 0;
            padding: 0;
        }
        
        #app {
            max-width: 100vw;
            overflow-x: clip;
        }
        
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
            height: 64px;
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

        /* Mobile Premium Menu */
        .mobile-toggle { display: none; cursor: pointer; z-index: 210; position: relative; }

        .hamburger-icon {
            width: 24px;
            height: 18px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .hamburger-icon span {
            display: block;
            height: 2px;
            width: 100%;
            background: var(--text-main);
            border-radius: 2px;
            transition: all 0.35s cubic-bezier(0.77, 0, 0.175, 1);
            transform-origin: center;
        }
        .hamburger-icon.active span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
            background: white;
        }
        .hamburger-icon.active span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }
        .hamburger-icon.active span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
            background: white;
        }

        .mobile-fullscreen-menu {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #05070a 0%, #0f172a 100%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s cubic-bezier(0.77, 0, 0.175, 1);
            padding: 0;
        }
        .mobile-fullscreen-menu.open {
            opacity: 1;
            visibility: visible;
        }
        
        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .close-menu-btn {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
            cursor: pointer;
            transition: all 0.3s;
        }
        .close-menu-btn:active { transform: scale(0.9); }

        .menu-content {
            flex: 1;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .menu-nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            color: rgba(255,255,255,0.5);
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform: translateY(15px);
            opacity: 0;
        }
        .mobile-fullscreen-menu.open .menu-nav-item {
            transform: translateY(0);
            opacity: 1;
        }
        .mobile-fullscreen-menu .menu-nav-item:nth-child(1) { transition-delay: 0.1s; }
        .mobile-fullscreen-menu .menu-nav-item:nth-child(2) { transition-delay: 0.15s; }
        .mobile-fullscreen-menu .menu-nav-item:nth-child(3) { transition-delay: 0.2s; }
        .mobile-fullscreen-menu .menu-nav-item:nth-child(4) { transition-delay: 0.25s; }
        .mobile-fullscreen-menu .menu-nav-item:nth-child(5) { transition-delay: 0.3s; }
        .mobile-fullscreen-menu .menu-nav-item:nth-child(6) { transition-delay: 0.35s; }
        .mobile-fullscreen-menu .menu-nav-item:nth-child(7) { transition-delay: 0.4s; }
        
        .menu-nav-item.active-link {
            color: white;
            padding-left: 1rem;
        }
        .menu-nav-item.active-link::before {
            content: '';
            position: absolute;
            left: -1rem;
            width: 4px;
            height: 24px;
            background: var(--primary);
            border-radius: 2px;
        }
        .menu-nav-item:hover { color: white; }

        @media (max-width: 1024px) {
            .nav-links { display: none !important; }
            .mobile-toggle { display: flex; align-items: center; justify-content: center; }
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
                <a href="{{ route('home') }}" class="logo">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    DBIM
                </a>

                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                    <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a>
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
                                    <a href="{{ route('instructor.dashboard') }}" class="dropdown-item">📋 Instructor Panel</a>
                                @else
                                    <a href="{{ route('student.dashboard') }}" class="dropdown-item">🎓 My Courses</a>
                                    <a href="{{ route('student.bookings') }}" class="dropdown-item">📅 My Bookings</a>
                                @endif
                                <a href="{{ route('student.profile') }}" class="dropdown-item">👤 Profile</a>
                                <div style="height: 1px; background: #e2e8f0; margin: 0.5rem 0;"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color: var(--danger); width: 100%; text-align: left; background: none; border: none; font: inherit; cursor: pointer;">🚪 Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Premium Mobile Toggle -->
                <button class="mobile-toggle" id="mobileMenuToggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                    <div class="hamburger-icon" id="hamburgerIcon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </nav>

        <!-- Premium Full-Screen Mobile Menu -->
        <div class="mobile-fullscreen-menu" id="mobileFullMenu">
            <div class="menu-header">
                <div class="logo" style="color: white;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    DBIM
                </div>
                <button class="close-menu-btn" onclick="toggleMobileMenu()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="menu-content">
                <div style="margin-bottom: 2rem;">
                    <p style="font-size: 0.75rem; font-weight: 800; letter-spacing: 0.3em; text-transform: uppercase; color: rgba(255,255,255,0.2);">Menu</p>
                </div>

                <nav>
                    <a href="{{ route('home') }}" class="menu-nav-item {{ request()->routeIs('home') ? 'active-link' : '' }}">
                        <span class="material-symbols-outlined">home</span> Home
                    </a>
                    <a href="{{ route('about') }}" class="menu-nav-item {{ request()->routeIs('about') ? 'active-link' : '' }}">
                        <span class="material-symbols-outlined">info</span> About
                    </a>
                    <a href="{{ route('events.index') }}" class="menu-nav-item {{ request()->routeIs('events.*') ? 'active-link' : '' }}">
                        <span class="material-symbols-outlined">event</span> Events
                    </a>
                    <a href="{{ route('live') }}" class="menu-nav-item {{ request()->routeIs('live') ? 'active-link' : '' }}">
                        <span class="material-symbols-outlined" style="color:#ef4444;">sensors</span>
                        Live
                    </a>
                    <a href="{{ route('calendar') }}" class="menu-nav-item {{ request()->routeIs('calendar') ? 'active-link' : '' }}">
                        <span class="material-symbols-outlined">calendar_month</span> Calendar
                    </a>
                    <a href="{{ route('library.index') }}" class="menu-nav-item {{ request()->routeIs('library.*') ? 'active-link' : '' }}">
                        <span class="material-symbols-outlined">local_library</span> Library
                    </a>
                </nav>

                <div style="margin-top: auto; padding-top: 3rem;">
                    @guest
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ route('login') }}" style="flex:1; display:flex; align-items:center; justify-content:center; gap:0.5rem; padding:1.25rem; background:rgba(255,255,255,0.05); color:white; font-weight:800; font-size:0.875rem; border-radius:1.25rem; border:1px solid rgba(255,255,255,0.1);">
                                Sign In
                            </a>
                            <a href="{{ route('donate') }}" style="flex:1; display:flex; align-items:center; justify-content:center; gap:0.5rem; padding:1.25rem; background:var(--primary); color:white; font-weight:800; font-size:0.875rem; border-radius:1.25rem; box-shadow: 0 10px 25px -5px rgba(23,84,207,0.5);">
                                ❤️ Give
                            </a>
                        </div>
                    @else
                        <div style="padding: 1.5rem; background: rgba(255,255,255,0.03); border-radius: 1.5rem; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem;">
                                <div style="width:52px; height:52px; border-radius:16px; background:var(--primary); display:flex; align-items:center; justify-content:center; color:white; font-weight:800; font-size:1.2rem; border:2px solid rgba(255,255,255,0.1);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div style="flex:1;">
                                    <p style="color:white; font-weight:800; font-size:1rem; line-height:1.2;">{{ Auth::user()->name }}</p>
                                    <p style="color:rgba(255,255,255,0.4); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.1em; margin-top:2px;">{{ Auth::user()->role }}</p>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                                <a href="{{ route('student.dashboard') }}" style="padding:0.875rem; text-align:center; background:rgba(255,255,255,0.05); color:white; font-weight:700; font-size:0.75rem; border-radius:1rem; text-transform:uppercase; letter-spacing:0.05em; border:1px solid rgba(255,255,255,0.05);">Dashboard</a>
                                <a href="{{ route('student.profile') }}" style="padding:0.875rem; text-align:center; background:rgba(255,255,255,0.05); color:white; font-weight:700; font-size:0.75rem; border-radius:1rem; text-transform:uppercase; letter-spacing:0.05em; border:1px solid rgba(255,255,255,0.05);">Profile</a>
                                <form action="{{ route('logout') }}" method="POST" style="grid-column: span 2;">
                                    @csrf
                                    <button type="submit" style="width:100%; padding:1rem; text-align:center; background:rgba(239,68,68,0.1); color:#ef4444; font-weight:800; font-size:0.875rem; border-radius:1rem; text-transform:uppercase; letter-spacing:0.1em; border:none; cursor:pointer;">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

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
                        <a href="{{ route('events.index') }}" class="footer-link">Upcoming Events</a>
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
                    &copy; {{ date('Y') }} Destiny Blessings int'l Ministry. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
    <script>
        // Desktop Dropdown
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

        // Premium Mobile Menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileFullMenu');
            const icon = document.getElementById('hamburgerIcon');
            const isOpen = menu.classList.contains('open');

            if (isOpen) {
                menu.classList.remove('open');
                icon.classList.remove('active');
                document.body.style.overflow = '';
            } else {
                menu.classList.add('open');
                icon.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
    </script>
</body>
</html>
