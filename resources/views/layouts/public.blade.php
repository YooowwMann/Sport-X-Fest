<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SportXFest')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg topbar">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">
            <img src="{{ asset('images/LOGO.png') }}" alt="SportXFest" height="40" class="me-2">
            SportXFest
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'fw-bold' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('events.public') ? 'fw-bold' : '' }}" href="{{ route('events.public') }}">Events</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('daftar') ? 'fw-bold' : '' }}" href="{{ route('daftar') }}">Registrasi</a>
                </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dokumentasi') ? 'fw-bold' : '' }}" href="{{ route('dokumentasi') }}">Dokumentasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'fw-bold' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'fw-bold' : '' }}" href="{{ route('profile') }}">Profil Tim</a>
                </li>
                @auth
                    <li class="nav-item ms-2">
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-warning fw-bold">Admin</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-sm" style="background:rgba(255,255,255,.2);color:#fff;">Dashboard</a>
                        @endif
                    </li>
                    <li class="nav-item ms-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Keluar</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item ms-2">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light fw-bold">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer class="footer">
    <div class="container text-center">
        <p class="mb-1">© 2026 SportXFest. All Rights Reserved.</p>
        <p class="small">Made with ❤️ by SportXFest Team</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
