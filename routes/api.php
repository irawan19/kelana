<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\BarangController as Barang;
use App\Http\Controllers\api\PenawaranController;

Route::get('/barang/{limit}', [Barang::class, 'index']);
Route::post('/penawaran', [Penawaran::class, 'index']);
