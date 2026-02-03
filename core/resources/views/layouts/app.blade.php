<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DBIM') }}</title>

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
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        <header style="background-color: white; padding: 1rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 700; font-size: 1.25rem; color: var(--primary-color);">
                DBIM
            </div>
            <nav style="display: flex; gap: 1rem;">
                <a href="{{ route('index') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Home</a>
                <a href="{{ route('calendar') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Calendar</a>
                <a href="{{ route('event') }}" style="color: #64748b; font-weight: 500; font-size: 0.875rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='#64748b'">Events</a>
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
