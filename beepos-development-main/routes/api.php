<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Middleware\ApiMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/auth/user', [ApiController::class, 'auth_user'])->middleware(ApiMiddleware::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [ApiController::class, 'register'])->name('api.register');
Route::post('/generate-sound', [ApiController::class, 'proc_sound'])->name('api.generate_sound');
Route::post('/proc_sound', [ApiController::class, 'proc_sound'])->name('api.proc_sound'); // Alias for TTS

// Midtrans Payment Callback
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('api.midtrans.callback');
Route::post('/midtrans/test', [MidtransCallbackController::class, 'test'])->name('api.midtrans.test'); // For testing only
Route::get('/midtrans/payment-events', [MidtransCallbackController::class, 'getPaymentEvents'])->name('api.midtrans.payment_events');
