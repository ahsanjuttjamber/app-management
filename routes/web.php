<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/rty', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('download');
});

// Admin Auth Routes
Route::get('/admin/login', [AuthController::class, 'showLogin']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout']);

// Admin Dashboard Routes (Protected)
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::post('/admin/lock/{id}', [DashboardController::class, 'lock']);
    Route::post('/admin/unlock/{id}', [DashboardController::class, 'unlock']);
});
