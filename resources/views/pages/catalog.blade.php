@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row g-4">
        <aside class="col-lg-3">
            <div class="card shadow-sm mb-3" style="background-color: #e5cdae">
                <div class="card-header fw-semibold">Категории</div>
                <div class="list-group list-group-flush">
                    <a style="background-color: #e5cdae" href="{{ route('catalog', ['sort' => $sort]) }}"
                       class="list-group-item list-group-item-action {{ !$catId ? '' : '' }}">Все товары</a>
                    @foreach($categories as $c)
                        <a style="background-color: #e5cdae" href="{{ route('catalog', ['cat' => $c->id, 'sort' => $sort]) }}"
                           class="list-group-item list-group-item-action {{ $catId === $c->id ? '' : '' }}">
                            {{ $c->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="card shadow-sm" style="background-color: #e5cdae">
                <div class="card-header fw-semibold">Сортировка</div>
                <div class="list-group list-group-flush" >
                    @php $sorts = [
                        'new' => 'По новизне',
                        'price_asc' => 'Цена: по возрастанию',
                        'price_desc' => 'Цена: по убыванию',
                        'name_asc' => 'Наименование: А → Я',
                        'name_desc' => 'Наименование: Я → А',
                    ]; @endphp
                    @foreach($sorts as $key => $label)
                        <a style="background-color: #e5cdae" href="{{ route('catalog', ['cat' => $catId ?: null, 'sort' => $key]) }}"
                           class="list-group-item list-group-item-action {{ $sort === $key ? '' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="col-lg-9">
            <h1 class="h3 mb-3">Каталог</h1>

            @if($products->isEmpty())
                <div class="alert alert-secondary">Товары не найдены.</div>
            @else
                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-4">
                    @foreach($products as $p)
                        <div class="col">
                            <div class="card h-100 shadow-sm product-card" style="background-color: #e5cdae">
                                <a href="{{ route('product', $p->id) }}">
                                    <img src="{{ $p->img ?: asset('public/img/no-image.png') }}"
                                         class="card-img-top" style="height:220px;object-fit:cover"
                                         alt="{{ $p->name }}">
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <span class="badge align-self-start mb-2" style="background-color: #653702">
                                        {{ $p->categoryRel->name ?? 'Без категории' }}
                                    </span>
                                    <h5 class="card-title h6 flex-grow-1">
                                        <a class="text-decoration-none" style="color: #653702;"
                                           href="{{ route('product', $p->id) }}">{{ $p->name }}</a>
                                    </h5>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fs-5 fw-bold" style="color: #653702;">
                                            {{ number_format($p->price, 0, '.', ' ') }} ₽
                                        </span>
                                        <!-- <small class="text-muted">{{ $p->year }} г.</small> -->
                                    </div>
                                    @if(auth()->check() && auth()->user()->isClient())
                                        <form method="post" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $p->id }}">
                                            <button class="btn btn-warning btn-sm w-100">
                                                <i class="bi bi-cart-plus"></i> В корзину
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection