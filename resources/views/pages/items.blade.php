@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-hover">
                    <img src="{{asset($item->img)}}" class="card-img-top" alt="Товар" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{$item->name}}</h5>
                        <p class="card-text text-muted small flex-grow-1">{{$item->discription}}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-5 fw-bold text-primary">{{$item->price}}₽</span>
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3"><a href="...">В корзину</a></button>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection
