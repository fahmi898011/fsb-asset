<?php

use Illuminate\Support\Facades\Route;
// Import Semua Controller agar tidak error class not found
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuditController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// ========================================================================
// 1. RUTE TAMU (GUEST)
// ========================================================================
Route::middleware(['guest'])->group(function () {
    // Redirect halaman depan (root) ke /login agar rapi
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Halaman Form Login (GET)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Proses Submit Login (POST)
    // URL disamakan '/login' agar sesuai dengan action form
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// ========================================================================
// 2. RUTE TERPROTEKSI (HARUS LOGIN)
// ========================================================================
Route::middleware(['auth'])->group(function () {
    
    // --- AUTHENTICATION ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // --- MODUL ASET / INVENTARIS ---
    
    // Custom Routes Aset (Letakkan SEBELUM resource 'assets' agar tidak bentrok ID)
    Route::get('assets/{id}/print-label', [AssetController::class, 'printLabel'])->name('assets.print-label');
    
    Route::get('assets/{id}/handover', [AssetController::class, 'handover'])->name('assets.handover');
    Route::put('assets/{id}/handover', [AssetController::class, 'processHandover'])->name('assets.process-handover');
    
    Route::get('assets/{id}/maintenance', [MaintenanceController::class, 'create'])->name('maintenances.create');
    Route::post('assets/{id}/maintenance', [MaintenanceController::class, 'store'])->name('maintenances.store');

    // Resource Utama Aset (Index, Create, Store, Show, Edit, Update, Destroy)
    Route::resource('assets', AssetController::class);


    // --- MASTER DATA ---
    Route::resource('categories', CategoryController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('users', UserController::class);


    // --- LAPORAN (REPORTING) ---
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');


    // --- STOCK OPNAME (AUDIT) ---
    
    // AJAX Search (Untuk pencarian manual di modal opname)
    Route::get('ajax/assets/search', [AuditController::class, 'searchAjax'])->name('audits.search-ajax');

    // Custom Routes Audit
    Route::post('audits/{id}/scan', [AuditController::class, 'scan'])->name('audits.scan');
    Route::get('audits/{id}/report', [AuditController::class, 'report'])->name('audits.report');
    Route::post('audits/{id}/close', [AuditController::class, 'close'])->name('audits.close');
    Route::post('audits/{id}/reopen', [AuditController::class, 'reopen'])->name('audits.reopen');
    Route::post('audits/{id}/mark-found/{assetId}', [AuditController::class, 'markFound'])->name('audits.mark-found');

    // Resource Audit (Kecuali Create/Edit/Update/Destroy karena custom flow)
    Route::resource('audits', AuditController::class)->except(['create', 'edit', 'update', 'destroy']);

});