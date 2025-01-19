<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController as Dashboard;
use App\Http\Controllers\AkunController as Akun;
use App\Http\Controllers\KategoriController as Kategori;
use App\Http\Controllers\TipeController as Tipe;
use App\Http\Controllers\MerkController as Merk;
use App\Http\Controllers\BarangController as Barang;
use App\Http\Controllers\SupplierController as Supplier;
use App\Http\Controllers\PenawaranController as Penawaran;
use App\Http\Controllers\AdminController as Admin;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Dashboard
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    //Akun
    Route::get('/akun', [Akun::class, 'index']);

    //Kategori
    Route::group(['prefix' => 'kategori'], function() {
        Route::get('/', [Kategori::class, 'index']);
        Route::get('/tambah', [Kategori::class, 'tambah']);
        Route::post('/prosestambah', [Kategori::class, 'prosestambah']);
        Route::get('/edit/{id}', [Kategori::class, 'edit']);
        Route::patch('/prosesedit/{id}', [Kategori::class, 'prosesedit']);
        Route::delete('/hapus/{id}', [Kategori::class, 'hapus']);
    });

    //Tipe
    Route::group(['prefix' => 'tipe'], function() {
        Route::get('/', [Tipe::class, 'index']);
        Route::get('/tambah', [Tipe::class, 'tambah']);
        Route::post('/prosestambah', [Tipe::class, 'prosestambah']);
        Route::get('/edit/{id}', [Tipe::class, 'edit']);
        Route::patch('/prosesedit/{id}', [Tipe::class, 'prosesedit']);
        Route::delete('/hapus/{id}', [Tipe::class, 'hapus']);
    });

    //Merk
    Route::group(['prefix' => 'merk'], function() {
        Route::get('/', [Merk::class, 'index']);
        Route::get('/tambah', [Merk::class, 'tambah']);
        Route::post('/prosestambah', [Merk::class, 'prosestambah']);
        Route::get('/edit/{id}', [Merk::class, 'edit']);
        Route::patch('/prosesedit/{id}', [Merk::class, 'prosesedit']);
        Route::delete('/hapus/{id}', [Merk::class, 'hapus']);
    });

    //Barang
    Route::group(['prefix' => 'barang'], function() {
        Route::get('/', [Barang::class, 'index']);
        Route::get('/tambah', [Barang::class, 'tambah']);
        Route::post('/prosestambah', [Barang::class, 'prosestambah']);
        Route::get('/edit/{id}', [Barang::class, 'edit']);
        Route::patch('/prosesedit/{id}', [Barang::class, 'prosesedit']);
        Route::delete('/hapus/{id}', [Barang::class, 'hapus']);
    });

    //Supplier
    Route::group(['prefix' => 'supplier'], function() {
        Route::get('/', [Supplier::class, 'index']);
        Route::get('/tambah', [Supplier::class, 'tambah']);
        Route::post('/prosestambah', [Supplier::class, 'prosestambah']);
        Route::get('/edit/{id}', [Supplier::class, 'edit']);
        Route::patch('/prosesedit/{id}', [Supplier::class, 'prosesedit']);
        Route::delete('/hapus/{id}', [Supplier::class, 'hapus']);
    });

    //Penawaran
    Route::group(['prefix' => 'penawaran'], function() {
        Route::get('/', [Penawaran::class, 'index']);
        Route::get('/tambah', [Penawaran::class, 'tambah']);
        Route::post('/prosestambah', [Penawaran::class, 'prosestambah']);
        Route::get('/baca/{id}', [Penawaran::class, 'baca']);
        Route::get('/edit/{id}', [Penawaran::class, 'edit']);
        Route::patch('/prosesedit/{id}', [Penawaran::class, 'prosesedit']);
        Route::delete('/hapus/{id}', [Penawaran::class, 'hapus']);
    });

    //Admin
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/', [Admin::class, 'index']);
        Route::get('/tambah', [Admin::class, 'tambah']);
        Route::post('/prosestambah', [Admin::class, 'prosestambah']);
        Route::get('/edit/{id}', [Admin::class, 'edit']);
        Route::patch('/prosesedit/{id}', [Admin::class, 'prosesedit']);
        Route::delete('/hapus/{id}', [Admin::class, 'hapus']);
    });

    //Logout
    Route::get('/logout', [Dashboard::class, 'logout']);
});
