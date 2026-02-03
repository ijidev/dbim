<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>DBIM</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">

    <!-- script
    ================================================== -->
    <script src="{{ asset('assets/js/modernizr.js')}}"></script>

    <!-- favicons
    ================================================== -->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

</head>

<body id="top">

    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader" class="dots-jump">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>


    <!-- header
    ================================================== -->
    <header class="s-header">

        <div class="header-logo">
            <a class="site-logo" href="{{ route('index') }}">
                <h2 style="color: white; margin-top:0;">DBIM</h2>
                {{-- <img src="{{ asset('assets/images/logo.svg') }}" alt="Homepage"> --}}
            </a>
        </div>

        <nav class="header-nav-wrap">
            <ul class="header-nav">
                <li class="current"><a href="{{ route('index') }}" title="Home">Home</a></li>
                <li><a href="{{ route('about') }}" title="About">About</a></li>
                <li><a href="{{ route('event') }}" title="Services">Events</a></li>
                <li><a href="{{ route('calendar') }}" title="Calendar">Calendar</a></li>
                <li><a href="{{ route('live') }}" title="Live Stream">Live</a></li>
                <li><a href="{{ route('student.courses') }}" title="LMS">Courses</a></li>
                <li><a href="{{ route('contact') }}" title="Contact us">Contact</a></li>
                @auth
                    @if(Auth::user()->role == 'admin')
                        <li><a href="{{ route('home') }}" title="Admin">Admin</a></li>
                    @else
                        <li><a href="{{ route('student.courses') }}" title="My Learning">My Learning</a></li>
                    @endif
                    <li>
                         <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" title="Login">Login</a></li>
                @endauth
            </ul>
        </nav>

        <a class="header-menu-toggle" href="#0"><span>Menu</span></a>

    </header> <!-- end s-header -->

        @yield('content')

   <!-- footer
    ================================================== -->
    <footer class="s-footer" style="padding: 0 3px 3px 3px;">

        <div class="row footer-top">
            <div class="column large-4 medium-5 tab-full">
                <div class="footer-logo">
                    <a class="site-footer-logo" href="{{ route('index') }}">
                        <h2 style="color: white; margin-top:0;">DBIM</h2>
                    </a>
                </div>  <!-- footer-logo -->
                <p>
                Destiny Blessings int'l Ministries - Raising Gods Among Men.
                </p>
            </div>
            <div class="column large-half tab-full">
                <div class="row">
                    <div class="column large-7 medium-full">
                        <h4 class="h6">Our Location</h4>
                        <p>
                        Omuohia New Layout, by Mountain of Fire Estate, Road 2, Beside Amechi Pillar, By Alikor's Close Igwuruta
                        </p>
        
                        <p>
                        <a href="https://goo.gl/maps/bc7C7eYtSmnNs6216" target="_blank" class="btn btn--footer">Get Direction</a>
                        </p>
                    </div>
                    <div class="column large-5 medium-full">
                        <h4 class="h6">Quick Links</h4>
                        <ul class="footer-list">
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('event') }}">Upcoming Events</a></li>
                            <li><a href="{{ route('student.courses') }}">LMS/Courses</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- end footer-top -->

        <div class="row footer-bottom">
            <div class="column ss-copyright">
                <span>© Copyright DBIM {{ date('Y') }}</span> 
                <span>Design by <a href="#">DBIM Media</a></span>
            </div>
        </div> <!-- footer-bottom -->

        <div class="ss-go-top">
            <a class="smoothscroll" title="Back to Top" href="#top">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0l8 9h-6v15h-4v-15h-6z"/></svg>
            </a>
        </div> <!-- ss-go-top -->

    </footer> <!-- end s-footer -->


    <!-- Java Script
    ================================================== -->
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>