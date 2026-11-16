@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4">Где нас найти?</h1>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm h-100"><div class="card-body" style="background-color: #e5cdae">
                <h2 class="h5 mb-3">Контакты</h2>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3"><i class="bi bi-geo-alt-fill text-primary me-2"></i>
                        <strong>Адрес:</strong><br>г. Москва, ул. Пушкина, д. 1, офис 42</li>
                    <li class="mb-3"><i class="bi bi-telephone-fill text-primary me-2"></i>
                        <strong>Телефон:</strong><br>
                        <a href="tel:+79991234567" class="text-decoration-none">+7 (999) 123-45-67</a></li>
                    <li><i class="bi bi-envelope-fill text-primary me-2"></i>
                        <strong>Email:</strong><br>
                        <a href="mailto:info@copy-star.ru" class="text-decoration-none">info@copy-star.ru</a></li>
                </ul>
            </div></div>
        </div>
        <div class="col-lg-8">
            <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
                <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=37.61,55.75,37.63,55.76&layer=mapnik"
                        style="border:0" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection