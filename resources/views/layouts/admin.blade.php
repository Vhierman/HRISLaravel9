<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Achmad Firmansyah" />
    <meta name="author" content="Achmad Firmansyah" />
    <link rel="icon" href="">
    <title>HRD-GA</title>

    {{-- Css --}}
    @include('includes.style')
    {{-- End Css --}}

</head>

<body class="sb-nav-fixed">

    {{-- Topbar --}}
    @include('includes.topbar')
    {{-- End Topbar --}}

    <div id="layoutSidenav">
        {{-- Sidebar --}}
        @include('includes.sidebar')
        {{-- End Sidebar --}}
        {{-- Content --}}
        @include('sweetalert::alert')
        @yield('content')
        {{-- End Content --}}
    </div>

    {{-- Script --}}
    @include('includes.script')
    {{-- End Script --}}

</body>

</html>
