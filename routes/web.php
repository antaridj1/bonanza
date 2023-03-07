<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenjualanController;

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
    Route::get('/dashboard-produk', [DashboardController::class, 'getProduks'])->name('getProduks');
    Route::get('/dashboard-profit', [DashboardController::class, 'getProfit'])->name('getProfit');

    Route::group(['prefix' => 'produk', 'as' => 'produk.'], function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::get('create', [ProdukController::class, 'create'])->name('create');
        Route::post('create', [ProdukController::class, 'store'])->name('store');
        Route::get('edit/{produk}', [ProdukController::class, 'edit'])->name('edit');
        Route::patch('edit/{produk}', [ProdukController::class, 'update'])->name('update');
        Route::delete('delete/{produk}', [ProdukController::class, 'destroy'])->name('delete');
        Route::get('stok', [ProdukController::class, 'getStok'])->name('getStok');
        Route::patch('stok', [ProdukController::class, 'postStok'])->name('postStok');
        Route::get('cetak', [ProdukController::class, 'cetak'])->name('cetak');
        Route::get('stok-kosong', [ProdukController::class, 'stokKosong'])->name('stokKosong');
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

    Route::group(['prefix' => 'pesanan', 'as' => 'pesanan.'], function () {
        Route::get('/', [PesananController::class, 'index'])->name('index');
        Route::get('create', [PesananController::class, 'create'])->name('create');
        Route::get('getProduk', [PesananController::class, 'getProduk'])->name('getProduk');
        Route::post('create', [PesananController::class, 'store'])->name('store');
        Route::patch('/{pesanan}', [PesananController::class, 'update'])->name('editStatus');
        Route::delete('delete/{pesanan}', [PesananController::class, 'destroy'])->name('delete');
        Route::get('cetak', [PesananController::class, 'cetak'])->name('cetak');
        Route::get('nota', [PesananController::class, 'nota'])->name('nota');
        Route::get('cetak-nota', [PesananController::class, 'cetakNota'])->name('cetakNota');
    });

    Route::group(['prefix' => 'pengeluaran', 'as' => 'pengeluaran.'], function () {
        Route::get('/', [PengeluaranController::class, 'index'])->name('index');
        Route::post('/', [PengeluaranController::class, 'store'])->name('store');
        Route::patch('/edit/{pengeluaran}', [PengeluaranController::class, 'update'])->name('update');
        Route::delete('delete/{pengeluaran}', [PengeluaranController::class, 'destroy'])->name('delete');
        Route::get('cetak', [PengeluaranController::class, 'cetak'])->name('cetak');
    });

    Route::group(['prefix' => 'penjualan', 'as' => 'penjualan.'], function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('index');
        Route::get('cetak', [PenjualanController::class, 'cetak'])->name('cetak');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});