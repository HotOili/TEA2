@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row align-items-center justify-content-center text-center my-5 p-4 rounded-4 shadow-sm bg-light">
            <div class="col-md-4 mb-3 mb-md-0">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Логотип компании"
                     class="img-fluid"
                     style="max-height: 100px;">
            </div>
            <div class="col-md-8">
                <h2 class="mb-2 fw-bold text-primary">«Инновации, которым доверяют»</h2>
                <p class="mb-0 text-muted fs-5">Мы создаём технологии для комфортной жизни</p>
            </div>
        </div>

        <h3 class="text-center mb-4 fw-semibold position-relative">
            Новинки компании
        </h3>

        <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade shadow rounded-4 overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('public/img/kozlik.jpg') }}" style="height: 400px; object-fit: cover;" class="d-block w-100" alt="1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="fw-bold">Новинка 1</h5>
                        <p>Современное решение для вашего дома</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('public/img/DieHard.webp') }}" style="height: 400px; object-fit: cover;" class="d-block w-100" alt="2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="fw-bold">Новинка 2</h5>
                        <p>Инновационные технологии</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('public/img/kozlik.jpg') }}" style="height: 400px; object-fit: cover;" class="d-block w-100" alt="3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="fw-bold">Новинка 3</h5>
                        <p>Качество, проверенное временем</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div>
@endsection
