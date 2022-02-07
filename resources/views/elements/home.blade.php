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
<body class="d-flex flex-column min-vh-100">
<nav class="bg-light navbar-right" style="height: 60px; line-height: 35px;">
    <ul class="nav justify-content-end">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{route('home')}}">
                Team management
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route('team.search')}}">Search</a>
                <a class="dropdown-item" href="{{route('team.create')}}">Create</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{route('home')}}">
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

<div class="container" style="margin-top: 50px;">
    @yield('content')
</div>

</body>
<footer class="mt-auto">
    <div class="footer-copyright text-center py-3">© 2022 Copyright:
        <a href="{{route('home')}}"> nam.com</a>
    </div>
</footer>
</html>
@stack('scripts')
<style>.dropdown:hover > .dropdown-menu {
        display: block;
    }
</style>



