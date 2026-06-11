<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ShopController;

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

// ============= ADMIN AUTH ROUTES =============
Route::get('/admin/login', [AuthController::class, 'showLogin']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout']);

// ============= ADMIN DASHBOARD ROUTES (Protected) =============
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::post('/admin/lock/{id}', [DashboardController::class, 'lock']);
    Route::post('/admin/unlock/{id}', [DashboardController::class, 'unlock']);
    Route::post('/admin/add-device', [DashboardController::class, 'store']);
    Route::delete('/admin/delete-device/{id}', [DashboardController::class, 'delete']);
    Route::get('/admin/device-location/{device_id}', [DashboardController::class, 'getLocation']);
    Route::get('/admin/pending-requests', [DashboardController::class, 'pendingRequests']);
    Route::post('/admin/approve-shop/{id}', [DashboardController::class, 'approveShop']);
    Route::delete('/admin/reject-shop/{id}', [DashboardController::class, 'rejectShop']);
});

// ============= SHOP AUTH ROUTES =============
Route::get('/shop-signup', [ShopController::class, 'showSignup']);
Route::post('/shop-register', [ShopController::class, 'register']);
Route::get('/shop-login', [ShopController::class, 'showLogin']);
Route::post('/shop-login', [ShopController::class, 'login']);
Route::get('/shop-logout', [ShopController::class, 'logout']);

// ============= SHOP DASHBOARD ROUTES (Protected) =============
Route::middleware('shop.auth')->group(function () {
    Route::get('/shop-dashboard', [ShopController::class, 'dashboard']);
    Route::post('/shop/add-device', [ShopController::class, 'addDevice']);
    Route::post('/shop/lock/{id}', [ShopController::class, 'lock']);
    Route::post('/shop/unlock/{id}', [ShopController::class, 'unlock']);
    Route::delete('/shop/delete-device/{id}', [ShopController::class, 'deleteDevice']);
    Route::get('/shop/device-location/{device_id}', [ShopController::class, 'getLocation']);
});
Route::delete('/admin/delete-shop/{id}', [DashboardController::class, 'deleteShop']);
Route::put('/admin/toggle-shop/{id}', [DashboardController::class, 'toggleShop']);

// OTP Routes
Route::get('/otp-verify', [ShopController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/otp-verify', [ShopController::class, 'verifyOtp']);
Route::get('/waiting-approval', [ShopController::class, 'waitingApproval'])->name('otp.waiting');
Route::post('/resend-otp', [ShopController::class, 'resendOtp'])->name('resend.otp');
Route::get('/send-test-email', function() {
    try {
        $email = 'cvmeetup.umar@gmail.com'; // Apna email
        $otp = rand(100000, 999999);

        Mail::send([], [], function($message) use ($email, $otp) {
            $message->to($email)
                    ->subject('Test Email - OTP: ' . $otp)
                    ->from('cvmeetup.umar@gmail.com', 'Shop App')
                    ->html("
                        <h2>Test Email</h2>
                        <p>Your OTP is: <strong style='font-size:24px;'>$otp</strong></p>
                        <p>Email sending is working!</p>
                    ");
        });

        return "✅ Email sent successfully! Check your inbox (or spam folder). OTP: " . $otp;

    } catch (Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});
Route::get('/admin/shop-devices/{id}', [DashboardController::class, 'shopDevices']);
Route::get('/', function () {
    return view('landing');
});
