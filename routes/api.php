<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected routes (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
        Route::get('/routes/today', [DashboardController::class, 'routeToday']);

        Route::get('/customers', [CustomerController::class, 'index']);
        Route::post('/customers', [CustomerController::class, 'store']);
        Route::get('/customers/{id}', [CustomerController::class, 'show']);
        Route::put('/customers/{id}', [CustomerController::class, 'update']);

        Route::get('/deliveries', [DeliveryController::class, 'index']);
        Route::post('/deliveries', [DeliveryController::class, 'store']);
        Route::put('/deliveries/{id}', [DeliveryController::class, 'update']);

        Route::get('/payments', [PaymentController::class, 'index']);
        Route::post('/payments', [PaymentController::class, 'store']);
        Route::get('/invoices/{id}', [PaymentController::class, 'invoice']);

        Route::post('/complaints', [ComplaintController::class, 'store']);

        Route::post('/attendance/checkin', [AttendanceController::class, 'checkin']);
        Route::post('/attendance/checkout', [AttendanceController::class, 'checkout']);

        Route::post('/location/update', [LocationController::class, 'update']);

        // Sales & Salary (for Flutter app)
        Route::post('/sales', [SalesController::class, 'store']);
        Route::get('/sales', [SalesController::class, 'index']);
        Route::get('/sales/{id}', [SalesController::class, 'show']);
        Route::get('/sales/summary/month', [SalesController::class, 'summaryForMonth']);
        Route::get('/case-prices', [SalesController::class, 'casePrices']);
        
        // Products (with real-time stock)
        Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
        
        // Expose current authenticated user instance
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
