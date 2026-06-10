<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AuthMiddleware;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

// Landing page baru
Route::get('/', function () {
    return view('landing');
});

// Akses tetap untuk halaman welcome default Laravel (opsional)
Route::get('/welcome', function () {
    return view('welcome');
});

// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login/process', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register/process', [AuthController::class, 'register'])->name('auth.register');

Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin')->middleware(AuthMiddleware::class);
Route::get('/dashboard/admin/stats', [DashboardController::class, 'stats'])->name('dashboard.admin.stats')->middleware(AuthMiddleware::class);
Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user')->middleware(AuthMiddleware::class);

// POS - Manajemen Pesanan
Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('/dashboard/admin/pesanan', [OrderController::class, 'index'])->name('admin.pesanan.index');
    Route::post('/dashboard/admin/pesanan/orders', [OrderController::class, 'store'])->name('admin.pesanan.store');
    Route::get('/dashboard/admin/pesanan/recent', [OrderController::class, 'recent'])->name('admin.pesanan.recent');

    // New routes for orders table
    Route::get('/admin/pesanan/all', [OrderController::class, 'allOrders'])->name('admin.pesanan.all');
    Route::get('/admin/pesanan/{id}', [OrderController::class, 'show'])->name('admin.pesanan.show');
    Route::put('/admin/pesanan/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');

    // Laporan Pesanan
    Route::get('/dashboard/admin/report/pesanan', [OrderController::class, 'report'])->name('admin.report.pesanan');
    Route::get('/dashboard/admin/report/pesanan/data', [OrderController::class, 'reportData'])->name('admin.report.pesanan.data');
    Route::get('/dashboard/admin/report/pesanan/export', [OrderController::class, 'export'])->name('admin.report.pesanan.export');
});

// Manajemen Menu
Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('/dashboard/admin/menu', [MenuController::class, 'index'])->name('admin.menu.index');
    Route::post('/dashboard/admin/menu', [MenuController::class, 'store'])->name('admin.menu.store');
    Route::put('/dashboard/admin/menu/{menu}', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/dashboard/admin/menu/{menu}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');

    // Manajemen Kategori
    Route::get('/dashboard/admin/kategori', [CategoryController::class, 'index'])->name('admin.kategori.index');
    Route::post('/dashboard/admin/kategori', [CategoryController::class, 'store'])->name('admin.kategori.store');
    Route::put('/dashboard/admin/kategori/{kategori}', [CategoryController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/dashboard/admin/kategori/{kategori}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
});

Route::get('/testing', function () {
    return view('hehe');
});
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Payment API
Route::post('/api/payment/create-charge', [PaymentController::class, 'createCharge'])->name('payment.create-charge');

Route::get('/receipt/{order}', [\App\Http\Controllers\ReceiptController::class, 'show']);
