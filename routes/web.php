<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PengeluaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'getLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-owner', [DashboardController::class, 'indexOwner']);
    Route::get('/dashboard-karyawan', [DashboardController::class, 'indexKaryawan']);
    Route::get('/dashboard-barang', [DashboardController::class, 'getBarangs'])->name('getBarangs');
    Route::get('/dashboard-profit', [DashboardController::class, 'getProfit'])->name('getProfit');

    Route::group(['prefix' => 'barang', 'as' => 'barang.'], function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('create', [BarangController::class, 'create'])->name('create');
        Route::post('create', [BarangController::class, 'store'])->name('store');
        Route::get('edit/{barang}', [BarangController::class, 'edit'])->name('edit');
        Route::patch('edit/{barang}', [BarangController::class, 'update'])->name('update');
        Route::delete('delete/{barang}', [BarangController::class, 'destroy'])->name('delete');
        Route::get('stok', [BarangController::class, 'getStok'])->name('getStok');
        Route::patch('stok', [BarangController::class, 'postStok'])->name('postStok');
        Route::get('cetak', [BarangController::class, 'cetak'])->name('cetak');
    });

    Route::group(['prefix' => 'karyawan', 'as' => 'karyawan.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('create', [UserController::class, 'store'])->name('store');
        Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::patch('edit/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('delete/{user}', [UserController::class, 'destroy'])->name('delete');
        Route::put('editStatus/{user}', [UserController::class, 'updateStatus'])->name('editStatus');
    });

    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::put('editpass/{user}', [UserController::class, 'updatePass'])->name('editpass');

    Route::group(['prefix' => 'penjualan', 'as' => 'penjualan.'], function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('index');
        Route::get('create', [PenjualanController::class, 'create'])->name('create');
        Route::get('getBarang', [PenjualanController::class, 'getBarang'])->name('getBarang');
        Route::post('create', [PenjualanController::class, 'store'])->name('store');
        Route::patch('/{penjualan}', [PenjualanController::class, 'update'])->name('editStatus');
        Route::delete('delete/{penjualan}', [PenjualanController::class, 'destroy'])->name('delete');
        Route::get('cetak', [PenjualanController::class, 'cetak'])->name('cetak');
        Route::get('nota', [PenjualanController::class, 'nota'])->name('nota');
        Route::get('cetak-nota', [PenjualanController::class, 'cetakNota'])->name('cetakNota');
    });

    Route::group(['prefix' => 'pengeluaran', 'as' => 'pengeluaran.'], function () {
        Route::get('/', [PengeluaranController::class, 'index'])->name('index');
        Route::post('/', [PengeluaranController::class, 'store'])->name('store');
        Route::patch('/edit/{pengeluaran}', [PengeluaranController::class, 'update'])->name('update');
        Route::delete('delete/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('delete');
        Route::get('cetak', [PengeluaranController::class, 'cetak'])->name('cetak');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});