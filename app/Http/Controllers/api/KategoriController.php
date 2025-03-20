<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\Controller;
use General;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $ambil_kategori  = Kategori::get();
        if(!empty($ambil_kategori))
        {
            $data_kategori = [
                'data'     => $ambil_kategori,
            ];
            return response()->json($data_kategori ,200);
        }
        else
        {
            return response()->json([
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }
}