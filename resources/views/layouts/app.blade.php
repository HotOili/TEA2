<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/bootstrap.bundle.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/bootstrap.css') }}" rel="stylesheet">

</head>
<body class="d-flex flex-column min-vh-100" style="background-color: #f2e8c9;">

@php
    use App\Models\Corzina;
    $cartCount = auth()->check() && auth()->user()->isClient()
        ? (int)Corzina::where('id_user', auth()->id())->sum('colvo')
        : 0;
@endphp

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #653702;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('about') }}">
            <i class="bi bi-printer-fill me-1"></i>Tea&nbsp;Time
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" 
                       href="{{ route('about') }}">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog','product') ? 'active' : '' }}" 
                       href="{{ route('catalog') }}">Каталог</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" 
                       href="{{ route('contacts') }}">Где нас найти?</a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-lg-center gap-lg-2">
                @auth
                    @if(auth()->user()->isClient())
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart') }}">
                                <i class="bi bi-cart3"></i> Корзина
                                <span id="cart-badge"
                                      class="badge rounded-pill text-bg-warning {{ $cartCount ? '' : 'd-none' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}"
                               href="{{ route('orders') }}">Мои заказы</a>
                        </li>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.orders') }}">
                                <i class="bi bi-speedometer2"></i> Админ-панель
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-1"></i>Выход
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm w-100" href="{{ route('login') }}">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm w-100" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1 py-4">
    <div id="toast-box" class="position-fixed top-0 end-0 p-3" style="z-index:1080"></div>
    @yield('content')
</main>

<footer class="text-white-50 py-3 mt-auto" style="background-color: #653702;">
    <div class="container d-flex flex-wrap justify-content-between gap-2 small">
        <span>&copy; {{ date('Y') }} Tea Time — лучший чай от Черпонито Ромино</span>
        <span><i class="bi bi-geo-alt"></i> г. Москва, ул. Пушкина, 1 &nbsp;·&nbsp;
              <i class="bi bi-telephone"></i> +7 (999) 123-45-67</span>
    </div>
</footer>
</body>
</html>
