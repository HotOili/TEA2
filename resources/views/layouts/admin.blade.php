<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Админ-панель') — Copy Star</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Bootstrap JS нужен ТОЛЬКО для navbar-toggler на узких экранах.
         Если хочешь совсем без JS — удали строку ниже,
         но тогда на мобильных меню не будет разворачиваться. --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="bg-body-tertiary">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('admin.orders') }}">
            <i class="bi bi-speedometer2"></i> Copy Star · Админ
        </a>

        <ul class="navbar-nav me-auto flex-row">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}"
                   href="{{ route('admin.orders') }}"><i class="bi bi-receipt"></i> Заказы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}"
                   href="{{ route('admin.products') }}"><i class="bi bi-box-seam"></i> Товары</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}"
                   href="{{ route('admin.categories') }}"><i class="bi bi-tags"></i> Категории</a>
            </li>
        </ul>

        <ul class="navbar-nav flex-row">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}" target="_blank">
                    <i class="bi bi-box-arrow-up-right"></i> На сайт
                </a>
            </li>
            <li class="nav-item">
                <form method="post" action="{{ route('logout') }}">@csrf
                    <button class="btn btn-link nav-link">
                        <i class="bi bi-box-arrow-right"></i> Выход
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<main class="container-fluid px-4 py-4">

    {{-- Ошибки валидации --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    {{-- Успех --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

</body>
</html>