<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\BarangController;
use App\Http\Controllers\api\PenawaranController;

Route::apiResource('/barang/{limit}', BarangController::class);
Route::apiResource('/penawaran', PenawaranController::class);
