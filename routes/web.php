<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController as AdminProfile;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;
use App\Http\Controllers\Customer\ProfileController;

// ─── Landing / Auth ───────────────────────────────────────────────
Route::get('/', function () {
    $featuredProducts = \App\Models\Product::where('is_featured', true)
        ->where('is_available', true)
        ->with('category')
        ->latest()
        ->take(6)
        ->get();
    return view('welcome', compact('featuredProducts'));
})->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin Routes ─────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggleFeatured');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Orders
    Route::get('/orders', [AdminOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/recap', [AdminOrder::class, 'recap'])->name('orders.recap');
    Route::get('/orders/{order}', [AdminOrder::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.updateStatus');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Admin Profile
    Route::get('/profile', [AdminProfile::class, 'edit'])->name('profile');
    Route::put('/profile', [AdminProfile::class, 'update'])->name('profile.update');
});

// ─── Customer Routes ──────────────────────────────────────────────
Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {

    Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    Route::get('/product/{product}', [CustomerDashboard::class, 'show'])->name('product.show');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Orders
    Route::get('/checkout', [CustomerOrder::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CustomerOrder::class, 'placeOrder'])->name('checkout.place');
    Route::get('/orders', [CustomerOrder::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}', [CustomerOrder::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/receipt', [CustomerOrder::class, 'receipt'])->name('orders.receipt');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
