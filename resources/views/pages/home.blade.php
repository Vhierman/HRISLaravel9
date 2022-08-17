@extends('layouts.app')
@section('content')
    <!-- Slider -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ url('frontend/images/sliders/Slides1.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ url('frontend/images/sliders/Slides2.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ url('frontend/images/sliders/Slides3.jpg') }}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- End Slider -->

    <!-- Company Overview -->
    <section class="section-company-overview">
        <div class="container">
            <div class="col text-center section-company-overview-heading">
                <h2 data-aos="fade-down">COMPANY OVERVIEW</h2>
                <div class="section-content-company-overview row justify-content-center">
                    <div class="col-sm-10 col-md-12 col-lg-10">
                        <blockquote class="blockquote mb-0">
                            <h3 data-aos="fade-up"> "PT PRIMA KOMPONEN INDONESIA IS A TRUSTWORTHY COMPANY WITH A STRONG
                                HISTORY AND EXPERIENCE AS AN OEM IN THIS COUNTRY"</h3>
                            <p class="patas" data-aos="fade-down">PT Prima Komponen Indonesia was established
                                in 2003 as one of the most reliable manufactures in Indonesia. With more than 15 years
                                of experience in the industry, PT Prima Komponen Indonesia has had a deep knowledge of
                                local market preference and many experience in handling labour resources, these two
                                important factor has enabled us to create the best solutions for our customers.</p>
                            <p data-aos="fade-up">We have strong commitment for our core business plastic injection
                                parts, electrical parts, and mechanical parts with sales contribution in Off Line,
                                Dealer Option and OEM parts. We assembled raw material and parts, and deliver them into
                                ready-to-use auto components for our many satisfied clients in the following list.</p>
                            <br>
                            <footer class="blockquote-footer">Achmad Firmansyah <cite title="Source Title">2022</cite>
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Company Overview-->

    <!-- Vision Mision -->
    <section class="section-visi-misi mt-2">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-lg-5 order-lg-2">
                    <div class="p-5">
                        <img data-aos="zoom-in-up" class="img-fluid rounded-circle"
                            src="{{ url('frontend/images/visi-misi/image-vision.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7 order-lg-1 heading">
                    <div class="p-5">
                        <h2 data-aos="fade-up" class="display-4">VISION</h2>
                        <p data-aos="fade-up">TO BE THE BEST AND THE LARGEST AUTOMOTIVE COMPONENT PARTS MANUFACTURER
                            IN INDONESIA.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="p-5">
                        <img data-aos="zoom-in-up" class="img-fluid rounded-circle"
                            src="{{ url('frontend/images/visi-misi/image-vission.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-7 heading">
                    <div class="p-5">
                        <h2 data-aos="fade-up" class="display-4">MISSION</h2>
                        <p data-aos="fade-up">CUSTOMERS SATISFACTION IS OUR FIRST PRIORITY BY PROVIDING BEST QUALITY
                            GUARANTEE, COMPETITIVE PRICE, ON-TIME SERVICE, AND CONTINUOUS AFTER-SALES SERVICE AND
                            SUPPORT WITH THE APPLICATION OF QUAALITY SAFETY AND ENVIRONMENTAL MANAGEMENT AS WELL AS OF
                            RISKS AND OPPORTUNITIES IN ALL ASPECTS OF OPERATIONAL AND BUSINESS ACTIVITIES.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Vision Mision -->

    <!-- Core Value -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#0099ff" fill-opacity="0.6"
            d="M0,96L48,85.3C96,75,192,53,288,42.7C384,32,480,32,576,48C672,64,768,96,864,112C960,128,1056,128,1152,112C1248,96,1344,64,1392,48L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
        </path>
    </svg>
    <section class="section-core-value">
        <div class="container">
            <div class="col text-center section-core-value-heading">

                <!-- Mobile Button-->
                <form class="form-inline d-sm-block d-md-none">
                    <h2 data-aos="zoom-in-down" class="mobile justify-content-center">CORE VALUE</h2>
                </form>
                <!-- End Mobile Button-->
                <!-- Desktop Button -->
                <form class="form-inline d-none d-md-block">
                    <h2 data-aos="zoom-in-down" class="desktop">CORE VALUE</h2>
                </form>
                <!-- End Desktop Button -->

                <div class="section-core-value row justify-content-center">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="container-images">
                            <div class="media d-flex align-items-center">
                                <div class="images flex-shrink-0">
                                    <img src="{{ url('frontend/images/core-values/LogoG.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 data-aos="flip-down">GRATITUDE IS OUR ATTITUDE</h5>
                                    <p data-aos="flip-down">As our number one company value, we put gratitude in the
                                        ﬁrst amongst the others. We believe that when we know how to be greateful then
                                        we know how to be greatness. Being grateful to almightly, appreciation to each
                                        person and return the kindness to the society are ours company’s motto. We are
                                        sleﬂess, we are humble and we are thankful also greatful of the opportunities
                                        and trustworthy given to us. With gratitude comes happines, your happiness is
                                        our happiness.
                                    </p>
                                </div>
                            </div>
                            <div class="media d-flex align-items-center">
                                <div class="images flex-shrink-0">
                                    <img src="{{ url('frontend/images/core-values/LogoR.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 data-aos="flip-down">REABILITY</h5>
                                    <p data-aos="flip-down">Is the precondition of trust. Our Customers, Partners and
                                        Clients’s satisfaction is our ﬁrst priority. We are professional trustworthy,
                                        responsible, and dependable, we strive to providing consistently in quality
                                        guarantee, a competitive price within budget, on time service and delivery,
                                        continuous after sales service and support.
                                    </p>
                                </div>
                            </div>
                            <div class="media d-flex align-items-center">
                                <div class="images flex-shrink-0">
                                    <img src="{{ url('frontend/images/core-values/LogoO.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 data-aos="flip-down">OPEN-MINDEDNESS</h5>
                                    <p data-aos="flip-down">Helps us to learn and grow, strengthening our belief in
                                        ourself. We are respective to new ideas for continuous improvement. We value the
                                        diversity experiences, skills and ideas. We listen to our customers, employees,
                                        partners, and stakeholders to explore new opportunities. We are open-mindedness
                                        and collective Intelligence to act with common purpose : enhancement of
                                        stakeholder’s satisfaction.
                                    </p>
                                </div>
                            </div>
                            <div class="media d-flex align-items-center">
                                <div class="images flex-shrink-0">
                                    <img src="{{ url('frontend/images/core-values/LogoW.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 data-aos="flip-down">WILLPOWER OF WINNING</h5>
                                    <p data-aos="flip-down">We strive to be the best and the largest automotive
                                        component parts manufacturer in Indonesia. We remain humble, learn from our
                                        competition, grow our perspectives, and strive towards to be a winner. We
                                        develop, share and use our willpower to win as a team. We respect each other,
                                        our Customers, Partners and Clients. Using our willpower for winning means we
                                        get things done.
                                    </p>
                                </div>
                            </div>
                            <div class="media d-flex align-items-center">
                                <div class="images flex-shrink-0">
                                    <img src="{{ url('frontend/images/core-values/LogoT.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 data-aos="flip-down">TEAMWORK AND COLLABORATION</h5>
                                    <p data-aos="flip-down"> We are one company, one team, one spirit and one goals. We
                                        collaborate in all aspects, we work as a team, we work together to be more
                                        eﬀective, eﬃcient and fulﬁlled great achievement for together success. We
                                        consistently demonstrate an unselﬁsh commitment, an atmosphere of trust, trating
                                        our colleagues, clients and partners with respect and supporting each other to
                                        work as a team. We recognize and value the contribution of individuals and teams
                                        in achieving company’s vision, mission and goals.
                                    </p>
                                </div>
                            </div>
                            <div class="media d-flex align-items-center">
                                <div class="images flex-shrink-0">
                                    <img src="{{ url('frontend/images/core-values/LogoH.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 data-aos="flip-down">HONESTY AND INTEGRITY</h5>
                                    <p data-aos="flip-down">We believe that Honesty and Integrity from the foundations
                                        of trustworthiness that are essential for company’s success. We area committed
                                        to speaking with honesty, thinking with sincerity, and acting with integrity as
                                        a team and company representation to our customers, business partners and
                                        clients also within our colleagues. Honesty and Integrity from trust that were
                                        the fundamental of a good reputation.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0099ff" fill-opacity="0.5"
                d="M0,128L60,128C120,128,240,128,360,149.3C480,171,600,213,720,218.7C840,224,960,192,1080,186.7C1200,181,1320,203,1380,213.3L1440,224L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
            </path>
        </svg>
    </section>
    <!-- End Core Value -->
@endsection
