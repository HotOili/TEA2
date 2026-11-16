@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-center g-4 mb-5">
        <div class="col-md-3 text-center">
            <img src="{{ asset('public/img/logo.png') }}" alt="Copy Star"
                 class="img-fluid" style="max-height:170px"
                 onerror="this.style.display='none'">
        </div>
        <div class="col-md-9">
            <h1 class="display-5 fw-bold mb-2">Tea Time</h1>
            <p class="lead text-primary mb-2">«»</p>
            <p class="text-secondary mb-0">
                
            </p>
        </div>
    </div>

    <h2 class="h3 mb-3">Чайные новинки</h2>

    @if($novelties->isEmpty())
        <div class="alert alert-secondary">Товары ещё не добавлены.</div>
    @else
    <div id="noveltySlider" class="carousel slide shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($novelties as $i => $t)
                <button type="button" data-bs-target="#noveltySlider" data-bs-slide-to="{{ $i }}"
                        class="{{ $i === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($novelties as $i => $t)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <a href="{{ route('product', $t->id) }}" class="text-decoration-none">
                        <img src="{{ $t->img ?: asset('public/img/no-image.png') }}"
                             class="d-block w-100" style="height:440px;object-fit:cover"
                             alt="{{ $t->name }}">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="bg-dark bg-opacity-75 rounded-3 d-inline-block px-4 py-2">
                                <h5 class="mb-0 text-white">{{ $t->name }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#noveltySlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#noveltySlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    @endif
</div>
@endsection