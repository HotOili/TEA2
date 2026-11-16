@extends('layouts.app')

@section('content')
<div class="container"><div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm"><div class="card-body p-4">
            <h1 class="h4 mb-4 text-center">Регистрация</h1>

            <form method="post" action="{{ route('register.post') }}" novalidate>
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Имя <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Фамилия <span class="text-danger">*</span></label>
                        <input type="text" name="surname"
                               value="{{ old('surname') }}"
                               class="form-control @error('surname') is-invalid @enderror">
                        @error('surname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Отчество</label>
                        <input type="text" name="patronymic"
                               value="{{ old('patronymic') }}"
                               class="form-control @error('patronymic') is-invalid @enderror">
                        @error('patronymic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Логин <span class="text-danger">*</span></label>
                        <input type="text" name="login"
                               value="{{ old('login') }}"
                               class="form-control @error('login') is-invalid @enderror"
                               autocomplete="username">
                        @error('login')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Пароль <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Повтор пароля <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               autocomplete="new-password">
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input @error('rules') is-invalid @enderror"
                                   type="checkbox" name="rules" id="rules"
                                   value="1" @checked(old('rules'))>
                            <label class="form-check-label" for="rules">
                                Я согласен с правилами регистрации
                            </label>
                            @error('rules')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100">Зарегистрироваться</button>
                    </div>
                </div>
            </form>

            <p class="text-center text-muted mt-3 mb-0">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
            </p>
        </div></div>
    </div>
</div></div>
@endsection