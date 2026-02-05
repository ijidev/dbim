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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            /* Palette */
            --primary: #1754cf;
            --primary-dark: #103c96;
            --primary-light: #e0e7ff;
            --accent: #f59e0b;
            --danger: #ef4444;
            --success: #10b981;
            
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
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="font-weight: 500;">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-ghost" style="color: var(--danger);">Logout</button>
                            </form>
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
                    <div class="footer-col">
                        <h4>About DBIM</h4>
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
</body>
</html>
