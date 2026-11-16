@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4">Мои заказы</h1>

    @if($orders->isEmpty())
        <div class="alert alert-secondary">У вас пока нет заказов.</div>
    @else
    <div class="accordion" id="ordersAccordion">
        @php $badges = ['Новый' => 'text-bg-primary', 'Подтверждён' => 'text-bg-success', 'Отменён' => 'text-bg-danger']; @endphp
        @foreach($orders as $i => $o)
            <div class="accordion-item shadow-sm mb-2" data-order="{{ $o->id_order }}">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#order{{ $i }}">
                        <div class="d-flex flex-wrap gap-3 align-items-center w-100 pe-3">
                            <span class="fw-semibold">Заказ №{{ $o->id_order }}</span>
                            <span class="badge {{ $badges[$o->status] ?? 'text-bg-secondary' }}">{{ $o->status }}</span>
                            <span class="text-muted small">{{ date('d.m.Y H:i', strtotime($o->date)) }}</span>
                            <span class="ms-auto small text-muted">
                                позиций: {{ $o->items->count() }} · товаров: {{ $o->total_qty }}
                            </span>
                        </div>
                    </button>
                </h2>

                <div id="order{{ $i }}" class="accordion-collapse collapse"
                     data-bs-parent="#ordersAccordion">
                    <div class="accordion-body">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($o->items as $it)
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="{{ route('product', $it->id_tovar) }}" class="text-decoration-none">
                                        {{ $it->tovar->name }}
                                    </a>
                                    <span>{{ $it->colvo }} × {{ number_format($it->tovar->price, 0, '.', ' ') }} ₽</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-5">
                                Итого:
                                <strong>{{ number_format($o->items->sum(fn($x) => $x->colvo * $x->tovar->price), 0, '.', ' ') }} ₽</strong>
                            </span>

                            @if($o->status === 'Новый')
                                <button class="btn btn-outline-danger btn-sm js-order-delete"
                                        data-order="{{ $o->id_order }}">
                                    <i class="bi bi-x-circle"></i> Удалить заказ
                                </button>
                            @endif
                        </div>

                        @if($o->status === 'Отменён' && $o->reson)
                            <div class="alert alert-danger mt-3 mb-0">
                                <strong>Причина отмены:</strong> {{ $o->reson }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection