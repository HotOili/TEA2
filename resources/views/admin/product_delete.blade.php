@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-3">Удаление товара</h1>

                <p class="mb-3">
                    Вы действительно хотите удалить товар
                    <strong>«{{ $product->name }}»</strong>?
                    Действие необратимо.
                </p>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{ $product->img ?: asset('public/img/no-image.png') }}"
                         style="width:80px;height:80px;object-fit:cover" class="rounded">
                    <div>
                        <div class="fw-semibold">{{ $product->name }}</div>
                        <div class="text-muted small">
                            {{ number_format($product->price, 0, '.', ' ') }} ₽
                        </div>
                    </div>
                </div>

                <form method="post"
                      action="{{ route('admin.products.destroy', $product->id) }}"
                      class="d-flex gap-2">
                    @csrf
                    <button class="btn btn-danger">Да, удалить</button>
                    <a href="{{ route('admin.products') }}"
                       class="btn btn-outline-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection