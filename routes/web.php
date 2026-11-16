<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, PageController, CartController, OrderController};
use App\Http\Controllers\Admin\{OrderController as AdminOrder, ProductController, CategoryController};

Route::get('/', [PageController::class, 'about'])->name('about');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog');
Route::get('/product/{id}', [PageController::class, 'product'])->name('product');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');

Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
     ->middleware('auth')->name('logout');

Route::middleware('client')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add',    [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/set',    [CartController::class, 'setQty'])->name('cart.set');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/order',  [CartController::class, 'createOrder'])->name('cart.order');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::post('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    // ---- Заказы ----
    Route::get('/', [AdminOrder::class, 'index'])->name('orders');
    Route::post('/orders/{id}/status', [AdminOrder::class, 'setStatus'])
         ->name('orders.status');

    // ---- Товары ----
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{id}', [ProductController::class, 'update'])->name('products.update');

    // Удаление — сначала страница подтверждения, потом сам POST
    Route::get('/products/{id}/delete', [ProductController::class, 'confirmDelete'])
         ->name('products.confirmDelete');
    Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])
         ->name('products.destroy');

    // ---- Категории ----
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/categories/{id}/delete', [CategoryController::class, 'confirmDelete'])
         ->name('categories.confirmDelete');
    Route::post('/categories/{id}/delete', [CategoryController::class, 'destroy'])
         ->name('categories.destroy');
});