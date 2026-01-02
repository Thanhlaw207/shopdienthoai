<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Admin') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body { overflow-x: hidden; }
        /* Sidebar Styling */
        .wrapper { display: flex; width: 100%; align-items: stretch; }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #343a40; /* Màu tối như hình mẫu */
            color: #fff;
            transition: all 0.3s;
        }
        #sidebar .sidebar-header { padding: 20px; background: #2c3136; border-bottom: 1px solid #474d52; }
        #sidebar ul p { color: #fff; padding: 10px; }
        #sidebar ul li a {
            padding: 15px 20px;
            display: block;
            color: #adb5bd;
            text-decoration: none;
            transition: 0.3s;
        }
        #sidebar ul li a:hover { color: #fff; background: rgba(255,255,255,0.1); }
        #sidebar ul li a i { margin-right: 10px; width: 20px; }
        
        /* Content Styling */
        #content { width: 100%; }
        .navbar { margin-bottom: 0; }
    </style>
</head>
<body>
    <div id="app" class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>NHÓM 4</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="{{ Request::is('products*') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}"><i class="fas fa-mobile-alt"></i> Quản lý điện thoại</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-table"></i> Data Tables</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-envelope"></i> Mail</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-chart-line"></i> Charts</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-map-marker-alt"></i> Maps</a>
                </li>
                <hr style="border-color: #474d52;">
                <li>
                    <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login Page</a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                @endif
                                @if (Route::has('register'))
                                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4 px-3">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>