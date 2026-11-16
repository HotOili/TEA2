@extends('layouts.admin')

@section('content')
<h1 class="h4 mb-4">Категории</h1>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">Добавить категорию</div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.categories.store') }}"
                      class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Например: МФУ" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th class="text-center">Товаров</th>
                            <th class="text-end">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->name }}</td>
                            <td class="text-center">{{ $c->tovars_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.confirmDelete', $c->id) }}"
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
    </div>
</div>
@endsection