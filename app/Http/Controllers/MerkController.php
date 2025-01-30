<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Merk;
use App\Helpers\General;

class MerkController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['merks']                  = Merk::orderBy('nama')
                                                ->paginate(10);
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('merk.lihat',$data);
    }

    public function cari(Request $request) {
        $hasil_kata                     = $request->cari_kata;
        $data['hasil_kata']             = $hasil_kata;
        $url_sekarang                   = $request->fullUrl();
        $data['merks']                  = Merk::Where('nama', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orderBy('nama')
                                                    ->paginate(10);
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('merk.lihat', $data);
    }

    public function prosestambah(Request $request) {
        $aturan = [
            'nama'             => 'required|unique:merks,nama,NULL,id,deleted_at,NULL',
        ];
        $this->validate($request, $aturan);

        $cek = Merk::onlyTrashed()->where('nama',$request->nama)->first();
        if (empty($cek)) {
            $data = [
                'nama'              => $request->nama,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            Merk::insert($data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = Merk::where('nama',$request->nama)->count();
            if($cek_exist == 0) {
                Merk::where('id',$cek->id)->restore();
                
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
        $cek = Merk::find($id);
        if (!empty($cek)) {
            $hasil_kata             = session('hasil_kata');
            $data['hasil_kata']     = $hasil_kata;
            $data['merks']          = Merk::Where('nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('nama')
                                                ->paginate(10);
            $data['edit_merks']     = Merk::find($id);
            return view('merk.lihat', $data);
        } else {
            return redirect('merk');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = Merk::find($id);
        if (!empty($cek)) {
            $aturan = [
                'nama'             => 'required|unique:merks,nama,'.$id.',id',
            ];
            $this->validate($request, $aturan);
            
            $cek = Merk::onlyTrashed()->where('nama',$request->nama)->first();
            if (empty($cek)) {

                $data = [
                    'nama'              => $request->nama,
                ];
                
                Merk::find($id)->update($data);
            } else {
                Merk::find($id)->delete();

                $data = [
                    'nama'              => $request->nama,
                ];
                Merk::insert($data);
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
            return redirect('merk');
        }
    }

    public function hapus($id) {
        $cek = Merk::find($id);
        if (!empty($cek)) {
            Merk::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('merk');
        }
    }
}