@extends('frontend.layouts.layout')
@section('content')

    <!-- page header
    ================================================== -->
    <section class="page-header page-header--events">

        <div class="gradient-overlay"></div>
        <div class="row page-header__content">
            <div class="column">
                <h1>Upcoming Events & Programs</h1>
            </div>
        </div>

    </section> <!-- end page-header -->


    <!-- page content
    ================================================== -->
    <section class="page-content">

        <div class="row">
            <div class="column">

                <div class="media-wrap event-thumb">
                        <img src="{{ asset('assets/images/thumbs/events/event-1000.jpg') }}" 
                          srcset="{{ asset('assets/images/thumbs/events/event-2000.jpg 2000w, 
                                  assets/images/thumbs/events/event-1000.jpg 1000w, 
                                  assets/images/thumbs/events/event-500.jpg 500w') }}" sizes="(max-width: 2000px) 100vw, 2000px" alt="">
                </div> <!-- end media-wrap -->

                <div class="event-content">

                    <div class="event-title">
                        <h2 class="display-1">2019 Kids Church Camp</h2>
                    </div>

                    <p>
                    A placeat dolorem quia explicabo nisi enim. Voluptatem sit 
                    voluptatem molestiae et dolores. Hic saepe id quis perspiciatis. 
                    Est error tenetur est facere est atque possimus est iste.
                    Sequi et iure delectus ut tempore soluta nihil. Voluptatem enim 
                    possimus ipsum perspiciatis sunt. Corporis quo expedita ut odio 
                    ducimus at debitis nobis dolorum. Hic saepe id quis perspiciatis.
                    Fugit placeat qui tenetur aperiam deleniti hic.
                    </p>

                    <p>
                    Nesciunt eius aspernatur. Veniam deleniti iusto est corrupti voluptatem 
                    adipisci. Et cupiditate repellendus omnis. Quos ipsam praesentium ea 
                    facere repudiandae. Minus ea maiores nemo libero unde saepe ut 
                    voluptates. Cupiditate ut in voluptatem veritatis sed dolores ex 
                    eum totam. Et earum et recusandae laboriosam ipsam.
                    </p>

                    <ul class="event-meta">
                        <li><strong>Age</strong>7-12 Years Old</li>
                        <li><strong>Cost</strong>150 USD</li>
                        <li><strong>Date</strong>Saturday, September 28, 2019</li>
                        <li><strong>Time</strong>8:00AM - 5:30PM</li>
                        <li><strong>Place</strong>1600 Amphitheatre Parkway, Mt. View</li>
                    </ul>

                </div> <!-- end event-content -->


            </div>
        </div>

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