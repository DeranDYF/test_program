<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;


Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('home', [HomeController::class, 'index'])->name('home');

// Customer
Route::get('customer', [CustomerController::class, 'index'])->name('customer');
Route::get('get_customer', [CustomerController::class, 'getCustomer'])->name('get_customer');
Route::any('tambah_customer', [CustomerController::class, 'addCustomer'])->name('tambah_customer');
Route::get('get_customer_by/{id}', [CustomerController::class, 'getCustomerById'])->name('get_customer_by');
Route::any('edit_customer', [CustomerController::class, 'editCustomer'])->name('edit_customer');
Route::any('delete_customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete_customer');

// Barang
Route::get('barang', [BarangController::class, 'index'])->name('barang');
Route::get('get_barang', [BarangController::class, 'getBarang'])->name('get_barang');
Route::any('tambah_barang', [BarangController::class, 'addBarang'])->name('tambah_barang');
Route::get('get_barang_by/{id}', [BarangController::class, 'getBarangById'])->name('get_barang_by');
Route::any('edit_barang', [BarangController::class, 'editBarang'])->name('edit_barang');
Route::any('delete_barang/{id}', [BarangController::class, 'deleteBarang'])->name('delete_barang');

// Transaksi
Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::get('get_transaksi', [TransaksiController::class, 'getTransaksi'])->name('get_transaksi');
Route::get('get_transaksi_by/{id}', [TransaksiController::class, 'getTransaksiById'])->name('get_transaksi_by');
Route::any('tambah_transaksi', [TransaksiController::class, 'addTransaksi'])->name('tambah_transaksi');
Route::any('edit_transaksi', [TransaksiController::class, 'editTransaksi'])->name('edit_transaksi');
Route::any('delete_transaksi/{id}', [TransaksiController::class, 'deleteTransaksi'])->name('delete_transaksi');

// Setting
Route::get('setting', [SettingController::class, 'index'])->name('setting');
Route::get('get_setting_user', [SettingController::class, 'getUser'])->name('get_setting_user');
Route::any('update_setting_user', [SettingController::class, 'updateUser'])->name('update_setting_user');
Route::any('update_setting_password', [SettingController::class, 'updateUserPassword'])->name('update_setting_password');
Route::any('update_setting_avatar', [SettingController::class, 'updateUserAvatar'])->name('update_setting_avatar');
