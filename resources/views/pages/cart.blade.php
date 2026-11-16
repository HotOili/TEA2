@extends('layouts.app')

@section('title', 'Корзина — Copy Star')

@section('content')
<div class="container">

    <h1 class="h3 mb-4">Корзина</h1>

    {{-- Flash-сообщения --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($items->isEmpty())

        <div class="alert alert-secondary">
            Корзина пуста.
            <a href="{{ route('catalog') }}" class="alert-link">Перейти в каталог</a>
        </div>

    @else

    <div class="row g-4">

        {{-- ==================== Список товаров ==================== --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Товар</th>
                                <th class="text-center" style="width:180px">Кол-во</th>
                                <th class="text-end" style="width:130px">Сумма</th>
                                <th style="width:60px"></th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($items as $i)
                            <tr>
                                {{-- Фото + название + цена --}}
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $i->tovar->img ?: asset('public/img/no-image.png') }}"
                                             alt="{{ $i->tovar->name }}"
                                             style="width:64px;height:64px;object-fit:cover"
                                             class="rounded">

                                        <div>
                                            <a class="text-decoration-none fw-semibold"
                                               href="{{ route('product', $i->tovar->id) }}">
                                                {{ $i->tovar->name }}
                                            </a>
                                            <div class="text-muted small">
                                                {{ number_format($i->tovar->price, 0, '.', ' ') }} ₽ / шт.
                                                &middot; в наличии {{ $i->tovar->nalichie }} шт.
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Управление количеством --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1">

                                        {{-- Минус --}}
                                        <form method="post" action="{{ route('cart.set') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="row"   value="{{ $i->id }}">
                                            <input type="hidden" name="delta" value="-1">
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    title="Уменьшить">−</button>
                                        </form>

                                        <span class="px-2 fw-semibold">{{ $i->colvo }}</span>

                                        {{-- Плюс --}}
                                        <form method="post" action="{{ route('cart.set') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="row"   value="{{ $i->id }}">
                                            <input type="hidden" name="delta" value="1">
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    title="Увеличить">+</button>
                                        </form>

                                    </div>
                                </td>

                                {{-- Сумма по позиции --}}
                                <td class="text-end fw-semibold">
                                    {{ number_format($i->tovar->price * $i->colvo, 0, '.', ' ') }} ₽
                                </td>

                                {{-- Удалить --}}
                                <td class="text-end">
                                    <form method="post" action="{{ route('cart.remove') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="row" value="{{ $i->id }}">
                                        <button class="btn btn-sm btn-outline-danger"
                                                title="Удалить позицию">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('catalog') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Продолжить покупки
                </a>
            </div>
        </div>

        {{-- ==================== Оформление заказа ==================== --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h2 class="h5 mb-3">Оформление заказа</h2>

                    <div class="d-flex justify-content-between mb-3 fs-5">
                        <span>Итого:</span>
                        <strong>{{ number_format($total, 0, '.', ' ') }} ₽</strong>
                    </div>

                    <form method="post" action="{{ route('cart.order') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Подтвердите пароль
                            </label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   autocomplete="current-password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Введите пароль от вашего аккаунта, чтобы подтвердить заказ.
                            </div>
                        </div>

                        <button class="btn btn-success w-100">
                            <i class="bi bi-check2-circle"></i> Сформировать заказ
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection