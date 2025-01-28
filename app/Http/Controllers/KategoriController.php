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

    public function prosestambah(Request $request) {
        $aturan = [
            'nama'             => 'required|unique:kategoris,nama,NULL,id,deleted_at,NULL',
        ];
        $this->validate($request, $aturan);

        $cek = Kategori::onlyTrashed()->where('nama',$request->nama)->first();
        if (empty($cek)) {
            $data = [
                'nama'              => $request->nama,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            Kategori::insert($data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = Kategori::where('nama',$request->nama)->count();
            if($cek_exist == 0) {
                Kategori::where('id',$cek->id)->restore();
                
                $setelah_simpan = [
                    'alert'                     => 'sukses',
                    'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            } else {
                $setelah_simpan = [
                    'alert'                     => 'error',
                    'text'                      => 'Data '.$request->nama.' sudah ada',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            }
        }
    }

    public function edit(Request $request, $id) {
        $cek = Kategori::find($id);
        if (!empty($cek)) {
            $hasil_kata             = session('hasil_kata');
            $data['hasil_kata']     = $hasil_kata;
            $data['kategoris']      = Kategori::Where('nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('nama')
                                                ->paginate(10);
            $data['edit_kategoris'] = Kategori::find($id);
            return view('kategori.lihat', $data);
        } else {
            return redirect('kategori');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = Kategori::find($id);
        if (!empty($cek)) {
            $aturan = [
                'nama'             => 'required|unique:kategoris,nama,'.$id.',id',
            ];
            $this->validate($request, $aturan);

            $cek = Kategori::onlyTrashed()->where('nama',$request->nama)->first();
            if (empty($cek)) {
                $data = [
                    'nama'              => $request->nama,
                ];
                
                Kategori::find($id)->update($data);
            } else {
                Kategori::find($id)->delete();

                $data = [
                    'nama'              => $request->nama,
                ];
                Kategori::insert($data);
            }

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil diperbarui',
            ];

            if(request()->session()->get('halaman') != '') {
                $url = request()->session()->get('halaman');
                return redirect($url)->with('setelah_simpan', $setelah_simpan);
            }
            else
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            return redirect('kategori');
        }
    }

    public function hapus($id) {
        $cek = Kategori::find($id);
        if (!empty($cek)) {
            Kategori::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('kategori');
        }
    }
}