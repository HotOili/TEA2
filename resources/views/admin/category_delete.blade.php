@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-3">Удаление категории</h1>

                <p>
                    Удалить категорию <strong>«{{ $category->name }}»</strong>?
                </p>

                @if($category->tovars_count > 0)
                    <div class="alert alert-warning">
                        В категории {{ $category->tovars_count }} товаров.
                        Сначала удалите или перенесите их.
                    </div>
                    <a href="{{ route('admin.categories') }}"
                       class="btn btn-outline-secondary">Назад</a>
                @else
                    <form method="post"
                          action="{{ route('admin.categories.destroy', $category->id) }}"
                          class="d-flex gap-2">
                        @csrf
                        <button class="btn btn-danger">Да, удалить</button>
                        <a href="{{ route('admin.categories') }}"
                           class="btn btn-outline-secondary">Отмена</a>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection