@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Товары</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> Добавить товар
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:70px">Фото</th>
                    <th>Наименование</th>
                    <th>Категория</th>
                    <th class="text-end">Цена</th>
                    <th class="text-center">Год</th>
                    <th class="text-center">В наличии</th>
                    <th class="text-center">Статус</th>
                    <th class="text-end">Действия</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $p)
                <tr>
                    <td>
                        <img src="{{ $p->img ?: asset('public/img/no-image.png') }}"
                             style="width:48px;height:48px;object-fit:cover" class="rounded">
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $p->name }}</div>
                        <div class="text-muted small">
                            {{ $p->model ?: '—' }} · {{ $p->country ?: '—' }}
                        </div>
                    </td>
                    <td>{{ $p->categoryRel->name ?? '—' }}</td>
                    <td class="text-end">{{ number_format($p->price, 0, '.', ' ') }} ₽</td>
                    <td class="text-center">{{ $p->year ?: '—' }}</td>
                    <td class="text-center">{{ $p->nalichie }}</td>
                    <td class="text-center">
                        @if($p->is_published)
                            <span class="badge text-bg-success">Опубликован</span>
                        @else
                            <span class="badge text-bg-secondary">Скрыт</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $p->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        {{-- никакого confirm() — ведём на страницу подтверждения --}}
                        <a href="{{ route('admin.products.confirmDelete', $p->id) }}"
                           class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection