<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tipe;
use App\Models\Merk;
use App\Helpers\General;

class TipeController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['tipes']                  = Tipe::selectRaw('merks.id as id_merks,
                                                            merks.nama as nama_merks,
                                                            tipes.id as id_tipes,
                                                            tipes.nama as nama_tipes')
                                                ->Join('merks','merks.id','tipes.merks_id')
                                                ->orderBy('merks.nama')
                                                ->paginate(10);
        $data['merks']                  = Merk::orderBy('nama')->get();
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('tipe.lihat',$data);
    }

    public function cari(Request $request) {
        $hasil_kata                     = $request->cari_kata;
        $data['hasil_kata']             = $hasil_kata;
        $url_sekarang                   = $request->fullUrl();
        $data['tipes']                  = Tipe::selectRaw('merks.id as id_merks,
                                                        merks.nama as nama_merks,
                                                        tipes.id as id_tipes,
                                                        tipes.nama as nama_tipes')
                                                ->Join('merks','merks.id','tipes.merks_id')
                                                ->Where('tipes.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orWhere('merks.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('merks.nama')
                                                ->paginate(10);
        $data['merks']                  = Merk::orderBy('nama')->get();
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('tipe.lihat', $data);
    }

    public function prosestambah(Request $request) {
        $aturan = [
            'merks_id'          => 'required',
            'nama'              => 'required|unique:tipes,nama,NULL,id,deleted_at,NULL',
        ];
        $this->validate($request, $aturan);

        $cek = Tipe::onlyTrashed()->where('nama',$request->nama)->first();
        if (empty($cek)) {
            $data = [
                'merks_id'          => $request->merks_id,
                'nama'              => $request->nama,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            Tipe::insert($data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = Tipe::where('nama',$request->nama)->count();
            if($cek_exist == 0) {
                Tipe::where('id',$cek->id)->restore();
                
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
        $cek = Tipe::find($id);
        if (!empty($cek)) {
            $hasil_kata             = session('hasil_kata');
            $data['hasil_kata']     = $hasil_kata;
            $data['tipes']          = Tipe::selectRaw('merks.id as id_merks,
                                                    merks.nama as nama_merks,
                                                    tipes.id as id_tipes,
                                                    tipes.nama as nama_tipes')
                                            ->Join('merks','merks.id','tipes.merks_id')
                                            ->Where('tipes.nama', 'LIKE', '%'.$hasil_kata.'%')
                                            ->orWhere('merks.nama', 'LIKE', '%'.$hasil_kata.'%')
                                            ->orderBy('merks.nama')
                                            ->paginate(10);
            $data['merks']          = Merk::orderBy('nama')->get();
            $data['edit_tipes']     = Tipe::find($id);
            return view('tipe.lihat', $data);
        } else {
            return redirect('tipe');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = Tipe::find($id);
        if (!empty($cek)) {
            $aturan = [
                'merks_id'          => 'required',
                'nama'              => 'required|unique:tipes,nama,'.$id.',id',
            ];
            $this->validate($request, $aturan);
            
            $cek = Tipe::onlyTrashed()->where('nama',$request->nama)->first();
            if (empty($cek)) {
                $data = [
                    'merks_id'          => $request->merks_id,
                    'nama'              => $request->nama,
                ];
                
                Tipe::find($id)->update($data);
            } else {
                Tipe::find($id)->delete();

                $data = [
                    'nama'              => $request->nama,
                ];
                Tipe::insert($data);
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
            return redirect('tipe');
        }
    }

    public function hapus($id) {
        $cek = Tipe::find($id);
        if (!empty($cek)) {
            Tipe::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('tipe');
        }
    }
}