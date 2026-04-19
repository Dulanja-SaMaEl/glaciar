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
use App\Http\Controllers\Admin\Reports\PestControlController;
use App\Http\Controllers\Admin\Reports\TrainingAttendanceController;
use App\Http\Controllers\Admin\Reports\TankCleaningController;
use App\Http\Controllers\Admin\Reports\RawWaterTestingController;
use App\Http\Controllers\Admin\Reports\RawMaterialInspectionController;
use App\Http\Controllers\Admin\Reports\TreatedWaterTestingController;
use App\Http\Controllers\Admin\Reports\DailyCleaningController;
use App\Http\Controllers\Admin\Reports\UvBulbMonitoringController;
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
    
    // Quality & Compliance Reports
    Route::get('/reports/pest-control', [PestControlController::class, 'index'])->name('pest-control.index');
    Route::post('/reports/pest-control', [PestControlController::class, 'store'])->name('pest-control.store');
    Route::get('/reports/pest-control/{id}', [PestControlController::class, 'show'])->name('pest-control.show');
    Route::put('/reports/pest-control/{id}', [PestControlController::class, 'update'])->name('pest-control.update');
    Route::delete('/reports/pest-control/{id}', [PestControlController::class, 'destroy'])->name('pest-control.destroy');
    Route::get('/reports/pest-control/export/pdf', [PestControlController::class, 'exportPdf'])->name('pest-control.export.pdf');
    Route::get('/reports/pest-control/export/csv', [PestControlController::class, 'exportCsv'])->name('pest-control.export.csv');

    Route::get('/reports/training-attendance', [TrainingAttendanceController::class, 'index'])->name('training-attendance.index');
    Route::post('/reports/training-attendance', [TrainingAttendanceController::class, 'store'])->name('training-attendance.store');
    Route::get('/reports/training-attendance/{id}', [TrainingAttendanceController::class, 'show'])->name('training-attendance.show');
    Route::put('/reports/training-attendance/{id}', [TrainingAttendanceController::class, 'update'])->name('training-attendance.update');
    Route::delete('/reports/training-attendance/{id}', [TrainingAttendanceController::class, 'destroy'])->name('training-attendance.destroy');
    Route::get('/reports/training-attendance/export/pdf', [TrainingAttendanceController::class, 'exportPdf'])->name('training-attendance.export.pdf');
    Route::get('/reports/training-attendance/export/csv', [TrainingAttendanceController::class, 'exportCsv'])->name('training-attendance.export.csv');

    Route::get('/reports/tank-cleaning', [TankCleaningController::class, 'index'])->name('tank-cleaning.index');
    Route::post('/reports/tank-cleaning', [TankCleaningController::class, 'store'])->name('tank-cleaning.store');
    Route::get('/reports/tank-cleaning/{id}', [TankCleaningController::class, 'show'])->name('tank-cleaning.show');
    Route::put('/reports/tank-cleaning/{id}', [TankCleaningController::class, 'update'])->name('tank-cleaning.update');
    Route::delete('/reports/tank-cleaning/{id}', [TankCleaningController::class, 'destroy'])->name('tank-cleaning.destroy');
    Route::get('/reports/tank-cleaning/export/pdf', [TankCleaningController::class, 'exportPdf'])->name('tank-cleaning.export.pdf');
    Route::get('/reports/tank-cleaning/export/csv', [TankCleaningController::class, 'exportCsv'])->name('tank-cleaning.export.csv');

    Route::get('/reports/raw-water-testing', [RawWaterTestingController::class, 'index'])->name('raw-water-testing.index');
    Route::post('/reports/raw-water-testing', [RawWaterTestingController::class, 'store'])->name('raw-water-testing.store');
    Route::get('/reports/raw-water-testing/{id}', [RawWaterTestingController::class, 'show'])->name('raw-water-testing.show');
    Route::put('/reports/raw-water-testing/{id}', [RawWaterTestingController::class, 'update'])->name('raw-water-testing.update');
    Route::delete('/reports/raw-water-testing/{id}', [RawWaterTestingController::class, 'destroy'])->name('raw-water-testing.destroy');
    Route::get('/reports/raw-water-testing/export/pdf', [RawWaterTestingController::class, 'exportPdf'])->name('raw-water-testing.export.pdf');
    Route::get('/reports/raw-water-testing/export/csv', [RawWaterTestingController::class, 'exportCsv'])->name('raw-water-testing.export.csv');

    Route::get('/reports/raw-material-inspection', [RawMaterialInspectionController::class, 'index'])->name('raw-material-inspection.index');
    Route::post('/reports/raw-material-inspection', [RawMaterialInspectionController::class, 'store'])->name('raw-material-inspection.store');
    Route::get('/reports/raw-material-inspection/{id}', [RawMaterialInspectionController::class, 'show'])->name('raw-material-inspection.show');
    Route::put('/reports/raw-material-inspection/{id}', [RawMaterialInspectionController::class, 'update'])->name('raw-material-inspection.update');
    Route::delete('/reports/raw-material-inspection/{id}', [RawMaterialInspectionController::class, 'destroy'])->name('raw-material-inspection.destroy');
    Route::get('/reports/raw-material-inspection/export/pdf', [RawMaterialInspectionController::class, 'exportPdf'])->name('raw-material-inspection.export.pdf');
    Route::get('/reports/raw-material-inspection/export/csv', [RawMaterialInspectionController::class, 'exportCsv'])->name('raw-material-inspection.export.csv');

    Route::get('/reports/treated-water-testing', [TreatedWaterTestingController::class, 'index'])->name('treated-water-testing.index');
    Route::post('/reports/treated-water-testing', [TreatedWaterTestingController::class, 'store'])->name('treated-water-testing.store');
    Route::get('/reports/treated-water-testing/{id}', [TreatedWaterTestingController::class, 'show'])->name('treated-water-testing.show');
    Route::put('/reports/treated-water-testing/{id}', [TreatedWaterTestingController::class, 'update'])->name('treated-water-testing.update');
    Route::delete('/reports/treated-water-testing/{id}', [TreatedWaterTestingController::class, 'destroy'])->name('treated-water-testing.destroy');
    Route::get('/reports/treated-water-testing/export/pdf', [TreatedWaterTestingController::class, 'exportPdf'])->name('treated-water-testing.export.pdf');
    Route::get('/reports/treated-water-testing/export/csv', [TreatedWaterTestingController::class, 'exportCsv'])->name('treated-water-testing.export.csv');

    Route::get('/reports/daily-cleaning', [DailyCleaningController::class, 'index'])->name('daily-cleaning.index');
    Route::post('/reports/daily-cleaning', [DailyCleaningController::class, 'store'])->name('daily-cleaning.store');
    Route::get('/reports/daily-cleaning/{id}', [DailyCleaningController::class, 'show'])->name('daily-cleaning.show');
    Route::put('/reports/daily-cleaning/{id}', [DailyCleaningController::class, 'update'])->name('daily-cleaning.update');
    Route::delete('/reports/daily-cleaning/{id}', [DailyCleaningController::class, 'destroy'])->name('daily-cleaning.destroy');
    Route::get('/reports/daily-cleaning/export/pdf', [DailyCleaningController::class, 'exportPdf'])->name('daily-cleaning.export.pdf');
    Route::get('/reports/daily-cleaning/export/csv', [DailyCleaningController::class, 'exportCsv'])->name('daily-cleaning.export.csv');

    Route::get('/reports/uv-bulb-monitoring', [UvBulbMonitoringController::class, 'index'])->name('uv-bulb-monitoring.index');
    Route::post('/reports/uv-bulb-monitoring', [UvBulbMonitoringController::class, 'store'])->name('uv-bulb-monitoring.store');
    Route::get('/reports/uv-bulb-monitoring/{id}', [UvBulbMonitoringController::class, 'show'])->name('uv-bulb-monitoring.show');
    Route::put('/reports/uv-bulb-monitoring/{id}', [UvBulbMonitoringController::class, 'update'])->name('uv-bulb-monitoring.update');
    Route::delete('/reports/uv-bulb-monitoring/{id}', [UvBulbMonitoringController::class, 'destroy'])->name('uv-bulb-monitoring.destroy');
    Route::get('/reports/uv-bulb-monitoring/export/pdf', [UvBulbMonitoringController::class, 'exportPdf'])->name('uv-bulb-monitoring.export.pdf');
    Route::get('/reports/uv-bulb-monitoring/export/csv', [UvBulbMonitoringController::class, 'exportCsv'])->name('uv-bulb-monitoring.export.csv');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});
