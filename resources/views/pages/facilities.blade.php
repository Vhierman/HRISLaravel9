@extends('layouts.app')
@section('content')
    <!-- Header Facilities -->
    <section class="section-header-facilities">
        <header class="text-center">
            <h1 data-aos="fade-down">
                OUR FACTORY IS EQUIPPED
                <br>BEST PERFORMING
                <br>INJECTION MACHINES
            </h1>
        </header>
        <main>
            <div class="container">
                <section class="section-stats row justify-content-center" id="stats">
                    <div class="col-3 col-md-2 stats-detail">
                        <h2>Plant 1</h2>
                        <p>5 Machines</p>
                    </div>
                    <div class="col-3 col-md-2 stats-detail">
                        <h2>Plant 2</h2>
                        <p>10 Machines</p>
                    </div>
                    <div class="col-3 col-md-2 stats-detail">
                        <h2>Plant 3</h2>
                        <p>7 Machines</p>
                    </div>
                    <div class="col-3 col-md-2 stats-detail">
                        <h2>Plant 4</h2>
                        <p>8 Machines</p>
                    </div>
                </section>
            </div>
        </main>
    </section>
    <!-- End Header Facilities -->

    <!-- Content Facilities -->
    <section class="section-content-facilities text-center">

        <!-- Title -->
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h3 class="fw-light" data-aos="fade-up">A COMPANY THAT ALWAYS TAKING CARE OF THEIR ASSETS WILL MAKE THE BEST
                    WORKING ENVIRONMENT AND THE BEST RESULTS</h3>
            </div>
        </div>
        <!-- Title -->

        <!-- ALbum -->
        <div class="album px-2 ">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <div class="col" data-aos="fade-down" data-aos-duration="3000">
                        <div class="card shadow-sm">
                            <img src="{{ url('frontend/images/facilities/facilities-1.jpg') }}" alt="">

                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill text-bg-primary">Primary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-down" data-aos-duration="3000">
                        <div class="card shadow-sm">
                            <img src="{{ url('frontend/images/facilities/facilities-1.jpg') }}" alt="">

                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill text-bg-primary">Primary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-down" data-aos-duration="3000">
                        <div class="card shadow-sm">
                            <img src="{{ url('frontend/images/facilities/facilities-1.jpg') }}" alt="">

                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill text-bg-primary">Primary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-up" data-aos-duration="3000">
                        <div class="card shadow-sm">
                            <img src="{{ url('frontend/images/facilities/facilities-1.jpg') }}" alt="">

                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill text-bg-primary">Primary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-up" data-aos-duration="3000">
                        <div class="card shadow-sm">
                            <img src="{{ url('frontend/images/facilities/facilities-1.jpg') }}" alt="">

                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill text-bg-primary">Primary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-up" data-aos-duration="3000">
                        <div class="card shadow-sm">
                            <img src="{{ url('frontend/images/facilities/facilities-1.jpg') }}" alt="">

                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge rounded-pill text-bg-primary">Primary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ALbum -->
    </section>
    <!-- Content Facilities -->
@endsection
