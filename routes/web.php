<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SellerWalletController;
use App\Http\Controllers\ProductQuestionController;
use App\Http\Controllers\OrderMessageController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/footer/{page}', [FooterController::class, 'show'])->name('footer.show');
Route::post('/contact', [FooterController::class, 'sendContact'])->name('contact.send');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');

/*
|--------------------------------------------------------------------------
| Rutas Autenticadas (Usuarios Generales)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard general con redirección por rol
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/become-seller', [ProfileController::class, 'showBecomeSellerForm'])->name('profile.become-seller');
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])->name('profile.become-seller.store');
    Route::post('/profile/address', [ProfileController::class, 'storeAddress'])->name('addresses.store');

    // Preguntas y Respuestas sobre Productos
    Route::post('/products/{product}/questions', [ProductQuestionController::class, 'store'])->name('products.questions.store');
    Route::post('/questions/{question}/answer', [ProductQuestionController::class, 'answer'])->name('questions.answer');

    // Favoritos
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Pedidos (Compras)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/confirm-delivery', [OrderController::class, 'confirmDeliveryPage'])->name('orders.confirm-delivery');
    Route::post('/orders/{order}/confirm-delivery', [OrderController::class, 'processConfirmDelivery'])->name('orders.confirm-delivery.store');

    // Chat del pedido (comprador y vendedor comparten el mismo controlador)
    Route::get('/orders/{order}/messages', [OrderMessageController::class, 'index'])->name('orders.messages.index');
    Route::post('/orders/{order}/messages', [OrderMessageController::class, 'store'])->name('orders.messages.store');

    // Reportes de publicaciones
    Route::post('/products/{product}/report', [ProductReportController::class, 'store'])->name('products.report');
});

/*
|--------------------------------------------------------------------------
| Rutas de Vendedor
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    
    // Billetera del vendedor
    Route::get('/wallet', [SellerWalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/withdraw', [SellerWalletController::class, 'withdraw'])->name('wallet.withdraw');

    // Gestión de Ventas (Pedidos)
    Route::get('/orders', [SellerController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{order}', [SellerController::class, 'ordersShow'])->name('orders.show');
    Route::post('/orders/{order}/ship', [SellerController::class, 'shipOrder'])->name('orders.ship');
    Route::get('/orders/{order}/label', [SellerController::class, 'printLabel'])->name('orders.label');

    // Chat del pedido (vendedor)
    Route::get('/orders/{order}/messages', [OrderMessageController::class, 'index'])->name('orders.messages.index');
    Route::post('/orders/{order}/messages', [OrderMessageController::class, 'store'])->name('orders.messages.store');

    Route::get('/products', [SellerController::class, 'index'])->name('products.index');
    Route::get('/products/create', [SellerController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [SellerController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerController::class, 'destroy'])->name('products.destroy');

    // Membresía Premium
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
    Route::post('/membership/activate', [MembershipController::class, 'activate'])->name('membership.activate');
    Route::post('/membership/cancel', [MembershipController::class, 'cancel'])->name('membership.cancel');
});

/*
|--------------------------------------------------------------------------
| Rutas de Administrador
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestión de usuarios
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Gestión de productos
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Gestión de categorías
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'show', 'edit']);

    // Gestión de órdenes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Reportes de publicaciones
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{report}', [AdminReportController::class, 'update'])->name('reports.update');

    // Gestión de membresías
    Route::patch('/users/{user}/membership', [AdminUserController::class, 'toggleMembership'])->name('users.membership');
});

require __DIR__.'/auth.php';
