<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HutangPiutangController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\MarketingReportController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\PiutangDetailController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HutangPiutangController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [AuthController::class, 'redirectTo']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Ajax
    Route::get('/ajax/customer-list', [AjaxController::class, 'get_customer_list']);
    Route::get('/ajax/customer-detail/{id}', [AjaxController::class, 'get_customer_detail']);

    // Common routes
    Route::get('/produk/list', [ProdukController::class, 'produk_list'])->name('ajax.produk.list');
    Route::get('/produk/list', [ProdukController::class, 'list'])->name('produk.list');
    Route::get('/customer/list', [CustomerController::class, 'list'])->name('customer.list');
    Route::post('/customer/store', [CustomerController::class, 'save'])->name('customer.store');
    Route::resource('settings', SettingController::class)->only(['index', 'edit', 'update']);
    
    // Marketing Report
    Route::prefix('marketing-report')->group(function () {
        Route::get('/', [MarketingReportController::class, 'index']);
    });

    // Hutang
    Route::prefix('hutang')->group(function () {
        Route::get('/hutang-customer', [HutangPiutangController::class, 'hutang_customer']);
    });

    // Produk
    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index']);
        Route::get('/list', [ProdukController::class, 'list']);
        Route::get('/create', [ProdukController::class, 'create']);
        Route::post('/', [ProdukController::class, 'store']);
        Route::get('/{id}/edit', [ProdukController::class, 'edit']);
        Route::put('/{id}', [ProdukController::class, 'update']);
        Route::get('/{id}/delete', [ProdukController::class, 'confirm']);
        Route::delete('/{id}/delete', [ProdukController::class, 'delete']);
        Route::get('/import', [ProdukController::class, 'import']);
        Route::get('/export_excel', [ProdukController::class, 'export_excel']);
        Route::get('/export_pdf', [ProdukController::class, 'export_pdf']);
    });

    // Stok
    Route::prefix('stok')->group(function () {
        Route::get('/', [StokController::class, 'index']);
        Route::get('/list', [StokController::class, 'list']);
        Route::get('/create', [StokController::class, 'create']);
        Route::post('/', [StokController::class, 'store']);
        Route::get('/{id}/edit', [StokController::class, 'edit']);
        Route::put('/{id}', [StokController::class, 'update']);
        Route::get('/{id}/delete', [StokController::class, 'confirm']);
        Route::delete('/{id}/delete', [StokController::class, 'delete']);
        Route::get('/import', [StokController::class, 'import']);
        Route::get('/export_excel', [StokController::class, 'export_excel']);
        Route::get('/export_pdf', [StokController::class, 'export_pdf']);
    });

    // Customer
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('/list', [CustomerController::class, 'list']);
        Route::get('/create', [CustomerController::class, 'create']);
        Route::post('/', [CustomerController::class, 'store']);
        Route::get('/{id}/edit', [CustomerController::class, 'edit']);
        Route::put('/{id}', [CustomerController::class, 'update']);
        Route::get('/{id}/delete', [CustomerController::class, 'confirm']);
        Route::get('/{id}/history', [CustomerController::class, 'history_transaksi']);
        Route::delete('/{id}/delete', [CustomerController::class, 'delete']);
        Route::get('/import', [CustomerController::class, 'import']);
        Route::get('/export_excel', [CustomerController::class, 'export_excel']);
        Route::get('/export_pdf', [CustomerController::class, 'export_pdf']);
    });

    // Penjualan
    Route::prefix('penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index']);
        Route::get('/create', [PenjualanController::class, 'create']);
        Route::put('/{id}', [PenjualanController::class, 'update']);
        Route::get('/edit/{id}', [PenjualanController::class, 'edit'])->name('penjualan.edit');
        Route::post('/edit/{penjualanId}/detail', [PenjualanDetailController::class, 'store']);
        Route::post('edit/{penjualanId}/detail/update', [PenjualanDetailController::class, 'updateDetailPenjualan'])->name('penjualan.updateDetail');
        Route::post('edit/{penjualanId}/detail/delete', [PenjualanDetailController::class, 'deleteDetailPenjualan'])->name('penjualan.deleteDetail');
        Route::post('/{produkId}/update-stok', [PenjualanDetailController::class, 'updateStok'])->name('penjualan.updateStok');
        Route::post('/{penjualan_id}/add-cicilan', [PenjualanController::class, 'addCicilan'])->name('cicilan.add');
        Route::get('/{id}/delete', [PenjualanController::class, 'confirm']);
        Route::delete('/{id}/delete', [PenjualanController::class, 'delete']);
        Route::get('/import', [PenjualanController::class, 'import']);
        Route::get('/export_excel', [PenjualanController::class, 'export_excel']);
        Route::get('/export_pdf', [PenjualanController::class, 'export_pdf']);
        Route::get('/{id}/invoice', [PenjualanController::class, 'invoice'])->name('penjualan.invoice');
    });

    // Piutang
    Route::prefix('piutang')->group(function () {
        Route::get('/', [PiutangController::class, 'index']);
        Route::get('/create', [PiutangController::class, 'create']);
        Route::put('/{id}', [PiutangController::class, 'update']);
        Route::get('/edit/{id}', [PiutangController::class, 'edit'])->name('piutang.edit');
        Route::post('/edit/{piutangId}/detail', [PiutangDetailController::class, 'store']);
        Route::post('edit/{piutangId}/detail/update', [PiutangDetailController::class, 'updateDetailPiutang'])->name('piutang.updateDetail');
        Route::post('edit/{piutangId}/detail/delete', [PiutangDetailController::class, 'deleteDetailPiutang'])->name('piutang.deleteDetail');
        Route::post('/{produkId}/update-stok', [PiutangDetailController::class, 'updateStok'])->name('piutang.updateStok');
        Route::post('/{piutang_id}/add-cicilan', [PiutangController::class, 'addCicilan'])->name('cicilan.add');
        Route::get('/{id}/delete', [PiutangController::class, 'confirm']);
        Route::delete('/{id}/delete', [PiutangController::class, 'delete']);
        Route::get('/import', [PiutangController::class, 'import']);
        Route::get('/export_excel', [PiutangController::class, 'export_excel']);
        Route::get('/export_pdf', [PiutangController::class, 'export_pdf']);
    });

    // Marketing
    Route::prefix('marketing')->group(function () {
        Route::get('/', [MarketingController::class, 'index']);
        Route::get('/marketing/list', [MarketingController::class, 'list'])->name('marketing.list');
        Route::get('/create', [MarketingController::class, 'create']);
        Route::post('/', [MarketingController::class, 'store']);
        Route::get('/{id}/edit', [MarketingController::class, 'edit']);
        Route::put('/{id}', [MarketingController::class, 'update']);
        Route::get('/{id}/delete', [MarketingController::class, 'confirm']);
        Route::delete('/{id}/delete', [MarketingController::class, 'delete']);
        Route::get('/export_excel', [MarketingController::class, 'export_excel']);
        Route::get('/export_pdf', [MarketingController::class, 'export_pdf']);
    });

    // User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/list', [UserController::class, 'list']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/{id}/delete', [UserController::class, 'confirm']);
        Route::delete('/{id}/delete', [UserController::class, 'delete']);
        Route::get('/import', [UserController::class, 'import']);             // opsional: jika ingin impor user
        Route::get('/export_excel', [UserController::class, 'export_excel']); // opsional
        Route::get('/export_pdf', [UserController::class, 'export_pdf']);     // opsional
    });
});



