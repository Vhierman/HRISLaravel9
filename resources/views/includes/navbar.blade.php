<!-- Navbar -->
<div class="container">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="#">
                <img src="{{ url('frontend/images/logo/logobulat.png') }}" alt="">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <div class="d-flex" role="search">
                    <ul class="navbar-nav mx-md-0">
                        <li class="nav-item mx-md-2">
                            <a class="nav-link active" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item mx-md-2">
                            <a class="nav-link" href="{{ route('facilities') }}">Facilities</a>
                        </li>
                        <li class="nav-item mx-md-2">
                            <a class="nav-link ">Product</a>
                        </li>
                        <li class="nav-item">
                            <form class="form-inline" action="#" method="post">
                                <button class="btn btn-login btn-navbar-right mr-4 my-2 mx-2 my-sm-0 px-4"
                                    type="submit">
                                    Masuk
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- End navbar -->
