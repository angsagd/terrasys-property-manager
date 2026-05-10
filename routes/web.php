<?php

use App\Http\Controllers\AdditionalCertificateController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified', 'permission:view_dashboard'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('properties', PropertyController::class);
    Route::resource('certificates', CertificateController::class)->only(['index', 'show']);
    Route::resource('additional-certificates', AdditionalCertificateController::class)->except(['show']);
    Route::resource('documents', DocumentController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    Route::get('map', [MapController::class, 'index'])->name('map.index');
    Route::get('map/data', [MapController::class, 'data'])->name('map.data');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('assets-by-region', [ReportController::class, 'assetsByRegion'])->name('assets-by-region');
        Route::get('assets-by-land-right', [ReportController::class, 'assetsByLandRight'])->name('assets-by-land-right');
        Route::get('idle-properties', [ReportController::class, 'idleProperties'])->name('idle-properties');
        Route::get('expiring-certificates', [ReportController::class, 'expiringCertificates'])->name('expiring-certificates');
    });

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('roles', [RolePermissionController::class, 'index'])->name('roles.index');
        Route::get('roles/{role}/edit', [RolePermissionController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RolePermissionController::class, 'update'])->name('roles.update');
        Route::get('master-data', [MasterDataController::class, 'index'])->name('master-data.index');
        Route::get('master-data/{type}/create', [MasterDataController::class, 'create'])->name('master-data.create');
        Route::post('master-data/{type}', [MasterDataController::class, 'store'])->name('master-data.store');
        Route::get('master-data/{type}/{id}/edit', [MasterDataController::class, 'edit'])->name('master-data.edit');
        Route::put('master-data/{type}/{id}', [MasterDataController::class, 'update'])->name('master-data.update');
        Route::delete('master-data/{type}/{id}', [MasterDataController::class, 'destroy'])->name('master-data.destroy');
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('system-settings', [SystemSettingController::class, 'index'])->name('system-settings.index');
    });
});

require __DIR__.'/auth.php';
