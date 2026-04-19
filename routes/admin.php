<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RepController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LiveMapController;
use App\Http\Controllers\Admin\SalesController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', 'admin'])->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('reps', RepController::class)->only(['index', 'show']);
    Route::get('/map', [LiveMapController::class, 'index'])->name('map');
    
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);
    
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    
    Route::resource('complaints', ComplaintController::class)->only(['index', 'show', 'update']);
    
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    
    // Sales & Salary
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/salary', [SalesController::class, 'salary'])->name('sales.salary.index');
    Route::get('/sales/salary/{repId}', [SalesController::class, 'repDetail'])->name('sales.salary.detail');
    Route::post('/sales/salary/{repId}/verify', [SalesController::class, 'verifyRepMonth'])->name('sales.salary.verify');
    Route::post('/sales/verify/{sale}', [SalesController::class, 'verify'])->name('sales.verify.record');
    Route::get('/sales/salary/{repId}/pdf', [SalesController::class, 'repSalaryPdf'])->name('sales.salary.pdf');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});
