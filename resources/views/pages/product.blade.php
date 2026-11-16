@extends('layouts.app')

@section('content')
<div class="container">
    <nav><ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('catalog') }}">Каталог</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol></nav>

    <div class="row g-4">
        <div class="col-lg-6">
            <img src="{{ $product->img ?: asset('public/img/no-image.png') }}"
                 class="img-fluid rounded shadow-sm w-100"
                 style="max-height:480px;object-fit:cover" alt="{{ $product->name }}">
        </div>

        <div class="col-lg-6">
            <span class="badge text-bg-light mb-2">
                {{ $product->categoryRel->name ?? 'Без категории' }}
            </span>
            <h1 class="h3">{{ $product->name }}</h1>
            <p class="display-6 fw-bold text-primary">
                {{ number_format($product->price, 0, '.', ' ') }} ₽
            </p>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Страна-производитель</span>
                    <strong>{{ $product->country ?: '—' }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Год выпуска</span>
                    <strong>{{ $product->year ?: '—' }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Модель</span>
                    <strong>{{ $product->model ?: '—' }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">В наличии</span>
                    <strong>{{ $product->nalichie }} шт.</strong>
                </li>
            </ul>

            @auth
                @if(auth()->check() && auth()->user()->isClient())
                    <form method="post" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $p->id }}">
                        <button class="btn btn-warning btn-sm w-100">
                            <i class="bi bi-cart-plus"></i> В корзину
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Войдите, чтобы купить</a>
            @endauth

            <hr class="my-4">
            <h2 class="h5">Описание</h2>
            <p class="text-secondary">{!! nl2br(e($product->discription)) !!}</p>
        </div>
    </div>
</div>
@endsection