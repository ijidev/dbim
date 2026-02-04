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

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="@yield('title', 'DBIM')">
    <meta property="twitter:description" content="Divine Business Impact Ministry (DBIM) - Empowering believers for spiritual and kingdom impact.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            --primary-color: #1754cf;
            --font-family: 'Inter', sans-serif;
        }
        
        body {
            font-family: var(--font-family);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Basic Reset */
        *, *::before, *::after {
            box-sizing: inherit;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }

        /* Mobile Nav Toggle */
        #nav-toggle { display: none; }
        .mobile-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: #64748b;
        }

        @media (max-width: 1024px) {
            .mobile-toggle { display: block; }
            nav {
                display: none !important;
                position: absolute;
                top: 64px;
                left: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
                z-index: 1000;
                gap: 1.5rem !important;
            }
            #nav-toggle:checked ~ nav {
                display: flex !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        <header style="background-color: white; padding: 1rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1000;">
            <div style="font-weight: 700; font-size: 1.25rem; color: var(--primary-color);">
                DBIM
            </div>
            
            <input type="checkbox" id="nav-toggle">
            <label for="nav-toggle" class="mobile-toggle">☰</label>

            <nav style="display: flex; gap: 1rem;">
                <a href="{{ route('index') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Home</a>
                <a href="{{ route('about') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">About</a>
                <a href="{{ route('calendar') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Calendar</a>
                <a href="{{ route('event') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Events</a>
                <a href="{{ route('store.index') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Store</a>
                <a href="{{ route('library.index') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Library</a>
                <a href="{{ route('live') }}" style="color: #f87171; font-weight: 700; font-size: 0.875rem; transition: color 0.2s; display: flex; align-items: center; gap: 0.25rem;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#f87171'">
                    <span style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                    Live
                </a>
                <a href="{{ route('contact') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Contact</a>
                <a href="{{ route('donate') }}" style="background: linear-gradient(135deg, #f87171, #ef4444); color: white; font-weight: 700; font-size: 0.875rem; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">❤️ Give</a>
                @guest
                    <a href="{{ route('login') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Login</a>
                    <a href="{{ route('register') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Register</a>
                @else
                    <span style="color: #1e293b; font-weight: 500; font-size: 0.875rem;">{{ Auth::user()->name }}</span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #ef4444; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;">Logout</a>
                @endguest
            </nav>
        </header>

        <main>
            @yield('content')
        </main>
        
        <footer style="margin-top: 2rem; padding: 1rem; text-align: center; color: #64748b; font-size: 0.875rem;">
            &copy; {{ date('Y') }} DBIM. All rights reserved.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
