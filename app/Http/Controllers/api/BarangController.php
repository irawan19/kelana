<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\api\Controller;
use General;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index($limit)
    {
        if($limit != 0)
        {
            $ambil_barang  = Barang::selectRaw('barangs.id as id_barangs,
                                                barangs.foto as foto_barangs,
                                                barangs.nama as nama_barangs,
                                                barangs.harga_jual,
                                                barangs.stok,
                                                barangs.brosur,
                                                kategoris.nama as nama_kategoris,
                                                merks.nama as nama_merks,
                                                tipes.nama as nama_tipes')
                                        ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                        ->join('tipes','tipes.id','barangs.tipes_id')
                                        ->join('merks','merks.id','tipes.merks_id')
                                        ->orderBy('barangs.nama')
                                        ->limit($limit)
                                        ->get();
        }
        else
        {
            $ambil_barang  = Barang::selectRaw('barangs.id as id_barangs,
                                                barangs.foto as foto_barangs,
                                                barangs.nama as nama_barangs,
                                                barangs.harga_jual,
                                                barangs.stok,
                                                barangs.brosur,
                                                kategoris.nama as nama_kategoris,
                                                merks.nama as nama_merks,
                                                tipes.nama as nama_tipes')
                                        ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                        ->join('tipes','tipes.id','barangs.tipes_id')
                                        ->join('merks','merks.id','tipes.merks_id')
                                        ->orderBy('barangs.nama')
                                        ->get();
        }
        if(!empty($ambil_barang))
        {
            $data_barang = [
                'data'     => $ambil_barang,
            ];
            return response()->json($data_barang ,200);
        }
        else
        {
            return response()->json([
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }
    }
}