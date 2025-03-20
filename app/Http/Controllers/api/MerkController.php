<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\Controller;
use General;
use App\Models\Merk;

class MerkController extends Controller
{
    public function index()
    {
        $ambil_merk  = Merk::get();
        if(!empty($ambil_merk))
        {
            $data_merk = [
                'data'     => $ambil_merk,
            ];
            return response()->json($data_merk ,200);
        }
        else
        {
            return response()->json([
                'message' => 'Merk tidak ditemukan'
            ], 404);
        }
    }
}