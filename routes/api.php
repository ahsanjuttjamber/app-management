<?php

use App\Http\Controllers\EmiController;
use Illuminate\Support\Facades\Route;

// ✅ EMI API Routes (Base: api/emi)
Route::prefix('emi')->group(function () {

    // Customer App APIs
    Route::post('/register-device', [EmiController::class, 'registerDevice']);
    Route::get('/check-status/{device_id}', [EmiController::class, 'checkStatus']);
    Route::post('/location', [EmiController::class, 'receiveLocation']);

    // Admin Panel APIs
    Route::post('/admin/soft-block', [EmiController::class, 'softBlock']);
    Route::post('/admin/full-lock', [EmiController::class, 'fullLock']);
    Route::post('/admin/unblock', [EmiController::class, 'unblock']);
    Route::post('/admin/mark-paid', [EmiController::class, 'markFullyPaid']);
    Route::get('/admin/devices', [EmiController::class, 'getAllDevices']);
});
