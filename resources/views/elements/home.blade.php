<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome.css') }}">
    <script src="{{ asset('vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap.min.js') }}"></script>
</head>
<body>
<nav class="navbar bg-light navbar-light">
    <ul class="nav justify-content-end">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbardrop" data-toggle="dropdown">
                Team management
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('team.search')}}">Search</a>
                <a class="dropdown-item" href="{{route('team.create')}}">Create</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbardrop" data-toggle="dropdown">
                Employee management
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('employee.search')}}">Search</a>
                <a class="dropdown-item" href="{{route('employee.create')}}">Create</a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('logout')}}">Logout</a>
        </li>
    </ul>
</nav>
<br>

<div class="container">
    @yield('content')
</div>

</body>
<footer class="page-footer font-small blue pt-4" style="margin-top: 50px">
    <div class="footer-copyright text-center py-3">© 2022 Copyright:
        <a href="#"> nam.com</a>
    </div>
</footer>
</html>



