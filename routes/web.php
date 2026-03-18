<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// ─── RUTAS PÚBLICAS ──────────────────────────────────────────

// Escaneo de QR → identifica producto y redirige
Route::get('/product/{product_code}',[ProductController::class, 'scan'])
     ->name('product.scan');

Route::post('/product/{product_code}/enter',[ProductController::class, 'enter'])
     ->name('product.enter');

// Home: listado de plantillas de tarjetas
Route::get('/home', [GiftController::class, 'home'])
     ->name('home');

// Crear tarjeta (POST)
Route::post('/gift/create', [GiftController::class, 'store'])
     ->name('gift.store');

// Acceso por palabra clave
Route::get('/gift/access',  [GiftController::class, 'accessForm'])
     ->name('gift.access');
Route::post('/gift/access', [GiftController::class, 'accessSubmit'])
     ->name('gift.access.submit');

// Ver tarjeta personalizada
Route::get('/gift/{access_key}', [GiftController::class, 'show'])
     ->name('gift.show');

// Página de inicio principal
Route::get('/', function () { return view('landing'); })->name('landing');

// ─── RUTAS DE AUTENTICACIÓN (Laravel Breeze o manual) ────────
// Si usas Breeze: php artisan breeze:install blade --dark
// require __DIR__.'/auth.php';

// Auth manual mínimo
Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ─── RUTAS ADMIN ─────────────────────────────────────────────
// Ruta pública para descargar QR como PNG (permitir descarga directa)
Route::get('admin/products/{product}/qr.png', [App\Http\Controllers\Admin\ProductController::class, 'downloadQr'])
     ->name('admin.products.qr.png');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', fn() => redirect()->route('admin.products.index'))->name('home');

    // Productos
    Route::resource('products', Admin\ProductController::class);
    Route::get('products/{product}/qr', [Admin\ProductController::class, 'qr'])
         ->name('products.qr');
    

    // Plantillas
    Route::resource('gift-cards', Admin\GiftCardController::class);

    // Gifts (solo index y destroy)
    Route::get('gifts',            [Admin\GiftController::class, 'index'])  ->name('gifts.index');
    Route::delete('gifts/{gift}',  [Admin\GiftController::class, 'destroy'])->name('gifts.destroy');
});