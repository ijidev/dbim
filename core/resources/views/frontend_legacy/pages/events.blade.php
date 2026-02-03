@extends('frontend.layouts.layout')
@section('content')

    <!-- page header
    ================================================== -->
    <section class="page-header page-header--events">

        <div class="gradient-overlay"></div>
        <div class="row page-header__content">
            <div class="column">
                <h1>Upcoming Events</h1>
            </div>
        </div>

    </section> <!-- end page-header -->


    <!-- page content
    ================================================== -->
    <section class="page-content">

        <div class="row wide block-large-1-2 block-900-full events-list">
           
            @foreach ($events as $event)
                <div class="column events-list__item">
                    <h3 class="display-1 events-list__item-title">
                        <a href="{{ route('event.single', $event->id) }}" title="">{{ $event->title }}.</a>
                    </h3>
                    <p>
                        {{ $event->description }}
                    </p>
                    <ul class="events-list__meta">
                        <li class="events-list__meta-date">{{$event->day . ',' . $event->month . ',' . $event->date . ',' . $event->year}}</li>
                        <li class="events-list__meta-time">{{$event->time}}</li>
                        <li class="events-list__meta-location">{{$event->location}}</li>
                    </ul>
                </div> <!-- end events-list__item -->
            @endforeach
        </div> <!-- end events-list -->

        {{-- <div class="row">
            <div class="column large-full">
                <nav class="pgn">
                    <ul>
                        <li><a class="pgn__prev" href="#0">Prev</a></li>
                        <li><a class="pgn__num" href="#0">1</a></li>
                        <li><span class="pgn__num current">2</span></li>
                        <li><a class="pgn__num" href="#0">3</a></li>
                        <li><a class="pgn__num" href="#0">4</a></li>
                        <li><a class="pgn__num" href="#0">5</a></li>
                        <li><span class="pgn__num dots">…</span></li>
                        <li><a class="pgn__num" href="#0">8</a></li>
                        <li><a class="pgn__next" href="#0">Next</a></li>
                    </ul>
                </nav> <!-- end pgn -->
            </div>
        </div> --}}

    </section> <!-- end page content -->


    <!-- Social
    ================================================== -->
    <section class="s-social">
            
        <div class="row social-content">
            <div class="column">
                <ul class="social-list">
                    <li class="social-list__item">
                        <a href="#0" title="">
                            <span class="social-list__icon social-list__icon--facebook"></span>
                            <span class="social-list__text">Facebook</span>
                        </a>
                    </li>
                    <li class="social-list__item">
                        <a href="#0" title="">
                            <span class="social-list__icon social-list__icon--twitter"></span>
                            <span class="social-list__text">Twitter</span>
                        </a>
                    </li>
                    <li class="social-list__item">
                        <a href="#0" title="">
                            <span class="social-list__icon social-list__icon--instagram"></span>
                            <span class="social-list__text">Instagram</span>
                        </a>
                    </li>
                    <li class="social-list__item">
                        <a href="#0" title="">
                            <span class="social-list__icon social-list__icon--email"></span>
                            <span class="social-list__text">Email</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div> <!-- end social-content -->

    </section> <!-- end s-social -->

@endsection