<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Tipe;
use App\Models\Barang;
use App\Helpers\General;

class BarangController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['barangs']                = Barang::selectRaw('barangs.id as id_barangs,
                                                            barangs.nama as nama_barangs,
                                                            barangs.harga_jual,
                                                            barangs.harga_beli,
                                                            barangs.stok,
                                                            kategoris.nama as nama_kategoris,
                                                            merks.nama as nama_merks,
                                                            tipes.nama as nama_tipes')
                                                ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                ->join('tipes','tipes.id','barangs.tipes_id')
                                                ->join('merks','merks.id','tipes.merks_id')
                                                ->orderBy('barangs.nama')
                                                ->paginate(10);
        $data['kategoris']              = Kategori::orderBy('nama')->get();
        $data['tipes']                  = Tipe::selectRaw('tipes.id as id_tipes,
                                                            tipes.nama as nama_tipes,
                                                            merks.id as id_merks,
                                                            merks.nama as nama_merks')
                                                ->join('merks','merks.id','tipes.merks_id')
                                                ->orderBy('merks.nama')
                                                ->get();
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('barang.lihat',$data);
    }

    public function cari(Request $request) {
        $hasil_kata                     = $request->cari_kata;
        $data['hasil_kata']             = $hasil_kata;
        $url_sekarang                   = $request->fullUrl();
        $data['barangs']                = Barang::selectRaw('barangs.id as id_barangs,
                                                            barangs.nama as nama_barangs,
                                                            barangs.harga_jual,
                                                            barangs.harga_beli,
                                                            barangs.stok,
                                                            kategoris.nama as nama_kategoris,
                                                            merks.nama as nama_merks,
                                                            tipes.nama as nama_tipes')
                                                ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                ->join('tipes','tipes.id','barangs.tipes_id')
                                                ->join('merks','merks.id','tipes.merks_id')
                                                ->orderBy('barangs.nama')
                                                ->paginate(10);
        $data['kategoris']              = Kategori::orderBy('nama')->get();
        $data['tipes']                  = Tipe::selectRaw('tipes.id as id_tipes,
                                                tipes.nama as nama_tipes,
                                                merks.id as id_merks,
                                                merks.nama as nama_merks')
                                                ->join('merks','merks.id','tipes.merks_id')
                                                ->orderBy('merks.nama')
                                                ->get();
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('barang.lihat', $data);
    }

    public function prosestambah(Request $request) {
        $aturan = [
            'kategoris_id'      => 'required',
            'tipes_id'          => 'required',
            'nama'              => 'required|unique:barangs,nama,NULL,id,deleted_at,NULL',
            'harga_jual'        => 'required',
            'harga_beli'        => 'required',
            'stok'              => 'required',
        ];
        $this->validate($request, $aturan);

        $cek = Barang::onlyTrashed()->where('nama',$request->nama)->first();
        if (empty($cek)) {
            $data = [
                'kategoris_id'      => $request->kategoris_id,
                'tipes_id'          => $request->tipes_id,
                'nama'              => $request->nama,
                'harga_jual'        => $request->harga_jual,
                'harga_beli'        => $request->harga_beli,
                'stok'              => $request->stok,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            Barang::insert($data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = Barang::where('nama',$request->nama)->count();
            if($cek_exist == 0) {
                Barang::where('id',$cek->id)->restore();
                
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
        $cek = Barang::find($id);
        if (!empty($cek)) {
            $hasil_kata             = session('hasil_kata');
            $data['hasil_kata']     = $hasil_kata;
            $data['barangs']        = Barang::selectRaw('barangs.id as id_barangs,
                                                        barangs.nama as nama_barangs,
                                                        barangs.harga_jual,
                                                        barangs.harga_beli,
                                                        barangs.stok,
                                                        kategoris.nama as nama_kategoris,
                                                        merks.nama as nama_merks,
                                                        tipes.nama as nama_tipes')
                                            ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                            ->join('tipes','tipes.id','barangs.tipes_id')
                                            ->join('merks','merks.id','tipes.merks_id')
                                            ->orderBy('barangs.nama')
                                            ->paginate(10);
            $data['edit_barangs']   = Barang::find($id);
            $data['tipes']          = Tipe::selectRaw('tipes.id as id_tipes,
                                                        tipes.nama as nama_tipes,
                                                        merks.id as id_merks,
                                                        merks.nama as nama_merks')
                                            ->join('merks','merks.id','tipes.merks_id')
                                            ->orderBy('merks.nama')
                                            ->get();
            return view('barang.lihat', $data);
        } else {
            return redirect('barang');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = Barang::find($id);
        if (!empty($cek)) {

            $aturan = [
                'kategoris_id'      => 'required',
                'tipes_id'          => 'required',
                'nama'              => 'required|unique:barangs,nama,NULL,id,deleted_at,NULL',
                'harga_jual'        => 'required',
                'harga_beli'        => 'required',
                'stok'              => 'required',
            ];
            $this->validate($request, $aturan);

            $cek = Barang::onlyTrashed()->where('nama',$request->nama)->first();
            if (empty($cek)) {
                $data = [
                    'kategoris_id'      => $request->kategoris_id,
                    'tipes_id'          => $request->tipes_id,
                    'nama'              => $request->nama,
                    'harga_jual'        => $request->harga_jual,
                    'harga_beli'        => $request->harga_beli,
                    'stok'              => $request->stok,
                    'created_at'        => date('Y-m-d H:i:s'),
                ];
                
                Barang::find($id)->update($data);
                
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
                Barang::find($id)->delete();

                $data = [
                    'kategoris_id'      => $request->kategoris_id,
                    'tipes_id'          => $request->tipes_id,
                    'nama'              => $request->nama,
                    'harga_jual'        => $request->harga_jual,
                    'harga_beli'        => $request->harga_beli,
                    'stok'              => $request->stok,
                    'created_at'        => date('Y-m-d H:i:s'),
                ];
                Barang::insert($data);
    
                $setelah_simpan = [
                    'alert'                     => 'sukses',
                    'text'                      => 'Data '.$request->nama.' berhasil diperbarui',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            }

        } else {
            return redirect('barang');
        }
    }

    public function hapus($id) {
        $cek = Barang::find($id);
        if (!empty($cek)) {
            Barang::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('barang');
        }
    }
}