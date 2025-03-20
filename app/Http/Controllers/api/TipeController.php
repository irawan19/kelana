<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\Controller;
use General;
use App\Models\Tipe;

class TipeController extends Controller
{
    public function index()
    {
        $ambil_tipe  = Tipe::get();
        if(!empty($ambil_tipe))
        {
            $data_tipe = [
                'data'     => $ambil_tipe,
            ];
            return response()->json($data_tipe ,200);
        }
        else
        {
            return response()->json([
                'message' => 'Tipe tidak ditemukan'
            ], 404);
        }
    }
}