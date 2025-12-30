@extends('frontend.layouts.layout')
@section('content')
    <!-- hero
    ================================================== -->
    <section class="s-hero" data-parallax="scroll" data-image-src="{{ asset('assets/images/hero-bg-3000.jpg')}}" data-natural-width=3000 data-natural-height=2000 data-position-y=center>

        <div class="hero-left-bar"></div>

        <div class="row hero-content">

            <div class="column large-full hero-content__text">
                <h1>
                    Raising Gods <br>
                    Among Men <br>
                </h1>
                {{-- <h1>
                    NON-Denominational <br>
                    & Deliverance Service <br>
                </h1> --}}

                <div class="hero-content__buttons">
                    {{-- <a href="{{route('event')}}" class="btn btn--stroke">Upcoming Events</a>
                    <a href="{{route('about')}}" class="btn btn--stroke">About Us</a> --}}
                </div>
            </div> <!-- end hero-content__text -->

        </div> <!-- end hero-content -->

        <ul class="hero-social">
            <li class="hero-social__title">Follow Us</li>
            <li>
                <a href="#0" title="">Facebook</a>
            </li>
            <li>
                <a href="#0" title="">YouTube</a>
            </li>
            <li>
                <a href="#0" title="">Instagram</a>
            </li>
        </ul> <!-- end hero-social -->

        <div class="hero-scroll">
            <a href="#about" class="scroll-link smoothscroll">
                Scroll For More
            </a>
        </div> <!-- end hero-scroll -->

    </section> <!-- end s-hero -->


    <!-- about
    ================================================== -->
    <section id="about" class="s-about">
        
        <div class="row row-y-center about-content">

            <div class="column large-full medium-full">
                <h3 class="subhead">Welcome to DBIM</h3>
                <p class="lead">
                 Destiny Blessings int'l Ministries Seating at Igwuruta Set On A Divine Mandate And Vision to Produce 
                 Mighty People And Nation For Christ, Raising gods 
                 Among Men In Christ For God's Kingdom & Dominion On Earth

                </p>
                <a href="{{ route('about') }}" class="btn btn--primary btn--about">More About DBIM</a>
            </div>

            <div style="background:#112; margin:0; padding:20px; align-items:center; text-align:center;">
                <h3 class="subhead">Church Activities</h3>
                <ul class="row row-y-center about-sched">

                    <li class="large-4 medium-4 tab-half mob-12">
                        <h4>Sunday School Service</h4>
                        <p>
                        Sunday - 7:30 AM | 8:30 PM 
                        </p>
                    </li>
            
                    <li class="large-4 medium-4 tab-half mob-12">
                        <h4>Main Church Service</h4>
                        <p>
                        Sunday - 8:30 AM | 12:00 PM
                        </p>
                    </li>

                    <li class="large-4 medium-4 tab-half mob-12">
                        <h4>Prophetic School</h4>
                        <p>
                        Sunday - 3:30 PM | 7:00 PM 
                        </p>
                    </li>

                    <li class="large-4 medium-4 tab-half mob-12">
                        <h4>Communion Service</h4>
                        <p>
                        Tusday - 5:00 PM 
                        </p>
                    </li>

                    <li class="large-4 medium-4 tab-half mob-12">
                        <h4>NON-Denominational & Delivrance Service</h4>
                        <p>
                        Thusday - 8:00 AM 
                        </p>
                    </li>
                </ul> <!-- end about-sched-->
            </div>

        </div> <!-- end about-content -->

    </section> <!-- end s-about -->


    <!-- connect
    ================================================== -->
    {{-- <section class="s-connect">

        <div class="row connect-content">
            <div class="column large-half tab-full">
                <h3 class="display-1">Volunteer With Us.</h3>
                <p>
                Delectus distinctio fuga commodi quod temporibus consequatur. 
                Voluptatem dolor vel impedit. Totam ut vel nihil ab. Nostrum ipsa 
                necessitatibus. Iste voluptatibus qui velit et voluptatem laudantium 
                et explicabo. Dignissimos ut voluptatum laboriosam nisi fugiat.
                Nulla dolores voluptate sit unde in doloribus est. Eveniet qui et 
                quia pariatur consequatur officia facere aut.
                </p>

                <a href="volunteer.html" class="btn btn--primary h-full-width">I'm Interested</a>
            </div>
            <div class="column large-half tab-full">
                <h3 class="display-1">Join a Connect Group.</h3>
                <p>
                Officia earum at quia recusandae. Tempora beatae est 
                aliquam fugiat sed et. Exercitationem vitae molestiae 
                officia eos aut id ad. Et exercitationem quae perspiciatis 
                mollitia. Laborum quasi inventore eaque quia non.
                Ipsa dignissimos ipsum nisi qui eos et iste magnam. Aut dolorum 
                mollitia illum. Iste iure similique nobis fuga est amet. 
                </p>

                <a href="connect-group.html" class="btn btn--primary h-full-width">Learn More</a>
            </div>
        </div> <!-- end connect-content  -->

    </section> <!-- end s-connect --> --}}


    <!-- events
    ================================================== -->
    <section class="s-events">

        <div class="row events-header">
            <div class="column">
                <h2 class="subhead">Upcoming Events and Programs.</h2>
            </div>
        </div> <!-- end event-header -->

        <div class="row block-large-1-2 block-900-full events-list">
            @foreach ($events as $event)
                <div class="column events-list__item">
                    <h3 class="display-1 events-list__item-title">
                        <a href="{{ route('event.single'), $event->id }}" title="">{{ $event->title }}.</a>
                    </h3>
                    <p>
                        {{ $event->description }}
                    </p>
                    <ul class="events-list__meta">
                        <li class="events-list__meta-date">{{$event->day . '/' . $event->date . '/' . $event->month . '/' . $event->year}}</li>
                        <li class="events-list__meta-time">{{$event->time}}</li>
                        <li class="events-list__meta-location">{{$event->location}}</li>
                    </ul>
                </div> <!-- end events-list__item -->
            @endforeach



        </div> <!-- end events-list -->

    </section> <!-- end s-events -->


    <!-- series
    ================================================== -->
    <section class="s-series">

        <div class="series-img" style="background-image: url('images/series-2000.jpg');"></div>

        <div class="row row-y-center series-content">

            <div class="column large-half medium-full">
                <h3 class="subhead">Life Transformation</h3>
                <h2>Shape Your Life with the Words of Life.</h2>
                <p>
                Aut sed amet et quis aliquid laborum minus consequatur. Animi repellendus quas. 
                Est voluptates minima ut dolorum aliquid sint. Ratione et et molestias rerum 
                quibusdam. Deserunt suscipit ut expedita. Non numquam aut eum perferendis 
                molestiae praesentium aliquid voluptatum numquam dolorum aliquid sint minima.
                </p>
            </div> <!-- end column -->

            <div class="column large-half medium-full">
                <div class="series-content__buttons">
                    <a href="" class="btn btn--large h-full-width">Listen To our Messages</a>
                    {{-- <a href="" class="btn btn--large h-full-width">Watch the Video</a> --}}
                </div>

                {{-- <div class="series-content__subscribe">
                    <p>
                    Never missed a message. Subscribe to our YouTube and Podcast channels.
                    </p>
                    
                    <ul class="series-content__subscribe-links">
                        <li class="ss-apple-podcast"><a href="#0">Apple Podcast</a></li>
                        <li class="ss-spotify"><a href="#0">Spotify</a></li>
                        <li class="ss-soundcloud"><a href="#0">SoundCloud</a></li>
                        <li class="ss-youtube"><a href="#0">Youtube</a></li>
                    </ul>
                </div> --}}
            </div> <!-- end column -->
            
        </div> <!-- series-content -->

    </section> <!-- end s-series -->


    <!-- Social
    ================================================== -->
    {{-- <section class="s-social">
            
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

    </section> <!-- end s-social --> --}}

@endsection


 