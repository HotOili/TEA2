@extends('layouts.admin')

@section('content')
<h1 class="h4 mb-4">Заказы</h1>

<ul class="nav nav-pills mb-3">
    @php $filters = ['' => 'Все', 'Новый' => 'Новые',
                     'Подтверждён' => 'Подтверждённые',
                     'Отменён' => 'Отменённые']; @endphp
    @foreach($filters as $key => $label)
        <li class="nav-item">
            <a class="nav-link {{ $filter === $key ? 'active' : '' }}"
               href="{{ route('admin.orders', $key ? ['status' => $key] : []) }}">
                {{ $label }}
            </a>
        </li>
    @endforeach
</ul>

@if($orders->isEmpty())
    <div class="alert alert-secondary">Заказов нет.</div>
@else
    @php $badges = [
        'Новый'       => 'text-bg-primary',
        'Подтверждён' => 'text-bg-success',
        'Отменён'     => 'text-bg-danger',
    ]; @endphp

    @foreach($orders as $o)
        <details class="card shadow-sm mb-2">
            <summary class="card-header d-flex flex-wrap gap-3 align-items-center"
                     style="cursor: pointer; list-style: none;">
                <span class="fw-semibold">№{{ $o->id_order }}</span>
                <span class="badge {{ $badges[$o->status] ?? 'text-bg-secondary' }}">
                    {{ $o->status }}
                </span>
                <span class="text-muted small">
                    {{ date('d.m.Y H:i', strtotime($o->date)) }}
                </span>
                <span class="small">{{ $o->fio }}</span>
                <span class="ms-auto small text-muted">
                    товаров: {{ $o->cnt }}
                </span>
            </summary>

            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    @foreach($o->items as $it)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $it->tovar->name }}</span>
                            <span>{{ $it->colvo }} шт.</span>
                        </li>
                    @endforeach
                </ul>

                @if($o->status === 'Отменён' && $o->reson)
                    <div class="alert alert-danger py-2">
                        <strong>Причина отмены:</strong> {{ $o->reson }}
                    </div>
                @endif

                <form method="post"
                      action="{{ route('admin.orders.status', $o->id_order) }}"
                      class="row g-2 align-items-end">
                    @csrf
                    <input type="hidden" name="back_status" value="{{ $filter }}">

                    <div class="col-md-3">
                        <label class="form-label small mb-1">Статус</label>
                        <select name="status" class="form-select form-select-sm">
                            @foreach(['Новый','Подтверждён','Отменён'] as $s)
                                <option value="{{ $s }}" @selected($o->status === $s)>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small mb-1">Причина отмены</label>
                        <input type="text" name="reason"
                               class="form-control form-control-sm"
                               value="{{ $o->reson }}"
                               placeholder="Заполняется при отмене">
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm w-100">Сохранить</button>
                    </div>
                </form>
            </div>
        </details>
    @endforeach
@endif
@endsection