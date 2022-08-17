<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Achmad Firmansyah" />
    <meta name="author" content="Achmad Firmansyah" />
    <title>Achmad Firmansyah</title>
    {{-- Style --}}
    @include('includes.style')
    {{-- Style --}}

</head>

<body>

    {{-- Navbar --}}
    @include('includes.navbar')
    {{-- Navbar --}}

    {{-- Content --}}
    @yield('content')
    {{-- Content --}}

    {{-- Footer --}}
    @include('includes.footer')
    {{-- Footer --}}
    
    {{-- Script --}}
    @include('includes.script')
    {{-- Script --}}
</body>

</html>
