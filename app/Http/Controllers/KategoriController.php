<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Helpers\General;

class KategoriController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['kategoris']              = Kategori::orderBy('nama')->paginate(10);
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('kategori.lihat',$data);
    }

    public function cari(Request $request) {
        $hasil_kata                     = $request->cari_kata;
        $data['hasil_kata']             = $hasil_kata;
        $url_sekarang                   = $request->fullUrl();
        $data['kategoris']              = Kategori::Where('nama', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orderBy('nama')
                                                    ->paginate(10);
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('kategori.lihat', $data);
    }

    public function tambah(Request $request) {
        return view('kategori.tambah');
    }

    public function prosestambah(Request $request) {
        $aturan = [
            'nama_kategoris'             => 'required',
        ];
        $this->validate($request, $aturan);

        $data = [
            'nama_kategoris'     => $request->nama_kategoris,
            'created_at'        => date('Y-m-d H:i:s'),
        ];

        Kategori::insert($data);
        
        if(request()->session()->get('halaman') != '')
            $redirect_halaman  = request()->session()->get('halaman');
        else
            $redirect_halaman  = 'kategori';

        return redirect($redirect_halaman);
    }

    public function edit(Request $request, $idkategori) {
        $cek_kategoris = Kategori::find($idkategori);
        if (!empty($cek_kategoris)) {
            $data['kategoris'] = Kategori::find($idkategori);
            return view('kategori.edit', $data);
        } else {
            return redirect('kategori');
        }
    }

    public function prosesedit(Request $request, $idkategori) {
        $cek_kategoris = Kategori::find($idkategori);
        if (!empty($cek_kategoris)) {
            $aturan = [
                'nama_kategoris'             => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'nama_kategoris'     => $request->nama_kategoris,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            
            Kategori::find($idkategori)->update($data);
            
            if(request()->session()->get('halaman') != '')
                $redirect_halaman  = request()->session()->get('halaman');
            else
                $redirect_halaman  = 'kategori';

            return redirect($redirect_halaman);
        } else {
            return redirect('kategori');
        }
    }

    public function hapus($idkategori) {
        $cek_kategoris = Kategori::find($idkategori);
        if (!empty($cek_kategoris)) {
            Kategori::find($idkategori)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('kategori');
        }
    }
}