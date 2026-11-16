@extends('layouts.admin')

@php $edit = (bool)$product->id; @endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">{{ $edit ? 'Редактирование товара' : 'Новый товар' }}</h1>
    <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary btn-sm">← К списку</a>
</div>

<form method="post"
      action="{{ $edit ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
      enctype="multipart/form-data" class="card shadow-sm">
    @csrf

    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Наименование <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Цена, ₽ <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" min="1"
                       value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Категория <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="">— выберите —</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}"
                            @selected((int)old('category'>
                            {{ $c->name }}
                        </option>
                    @endforeach                                                                                 
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Страна-производитель</label>
                <input type="text" name="country" class="form-control"
                       value="{{ old('country', $product->country) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Год выпуска</label>
                <input type="number" name="year" class="form-control" min="1990" max="2100"
                       value="{{ old('year', $product->year) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Модель</label>
                <input type="text" name="model" class="form-control"
                       value="{{ old('model', $product->model) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Количество в наличии</label>
                <input type="number" name="nalichie" class="form-control" min="0"
                       value="{{ old('nalichie', $product->nalichie) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Путь к изображению</label>
                <input type="text" name="img" class="form-control"
                       value="{{ old('img', $product->img) }}" placeholder="/public/img/file.webp">
            </div>
            <div class="col-md-4">
                <label class="form-label">…или загрузить файл</label>
                <input type="file" name="img_file" class="form-control" accept="image/*">
            </div>

            <div class="col-12">
                <label class="form-label">Описание</label>
                <textarea name="discription" rows="4" class="form-control">{{ old('discription', $product->discription) }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_published" id="pub" value="1"
                        @checked(old('is_published', $product)
                    <label class="form-check-label" for="pub">Опубликован</label>
                </div>
            </div>

            <div class="col-12"><button class="btn btn-primary">Сохранить</button></div>
        </div>
    </div>
</form>
@endsection