@extends('layouts.app')

@section('content')
<div class="container"><div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm"><div class="card-body p-4">
            <h1 class="h4 mb-4 text-center">Вход</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="post" action="{{ route('login.post') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Логин</label>
                    <input type="text" name="login"
                           value="{{ old('login') }}"
                           class="form-control @error('login') is-invalid @enderror"
                           autocomplete="username" autofocus>
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>

                <button class="btn btn-primary w-100">Войти</button>
            </form>

            <p class="text-center text-muted mt-3 mb-0">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </p>
        </div></div>
    </div>
</div></div>
@endsection