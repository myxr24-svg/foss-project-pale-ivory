<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'show'])->name('home');
Route::post('/register', [StudentController::class, 'store'])->name('student.register');

Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);
Route::get('/receipt/{student}/{reference}', [PaymentController::class, 'downloadReceipt'])->name('receipt.download');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/trades', [DashboardController::class, 'storeTrade'])->name('admin.trades.store');
    Route::delete('/admin/trades/{trade}', [DashboardController::class, 'destroyTrade'])->name('admin.trades.destroy');
    Route::post('/admin/admins', [DashboardController::class, 'storeAdmin'])->name('admin.admins.store');
    Route::delete('/admin/admins/{admin}', [DashboardController::class, 'destroyAdmin'])->name('admin.admins.destroy');
});
