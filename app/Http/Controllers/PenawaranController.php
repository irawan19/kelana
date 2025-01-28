<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Penawaran;
use App\Models\Barang;
use App\Models\Penawaran_barang;
use App\Helpers\General;

class PenawaranController extends Controller {

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
                                                ->get();
        $data['penawarans']             = Penawaran::orderBy('no')
                                                ->paginate(10);
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('penawaran.lihat',$data);
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
                                                ->get();
        $data['penawarans']             = Penawaran::Penawaran::Where('no', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orderBy('no')
                                                    ->paginate(10);
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('penawaran.lihat', $data);
    }

    public function prosestambah(Request $request) {
        $aturan = [
            'nama'              => 'required',
            'perusahaan'        => 'required',
            'alamat'            => 'required',
            'cp'                => 'required',
            'kontak_cp'         => 'required',
        ];
        $this->validate($request, $aturan);

        $cek = Penawaran::onlyTrashed()->where('nama',$request->nama)->first();
        if (empty($cek)) {
            $data = [
                'no'                => \App\Helpers\General::generateNoPenawaran(),
                'nama'              => $request->nama,
                'perusahaan'        => $request->perusahaan,
                'alamat'            => $request->alamat,
                'cp'                => $request->cp,
                'kontak_cp'         => $request->kontak_cp,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            Penawaran::insert($data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = Penawaran::where('nama',$request->nama)->count();
            if($cek_exist == 0) {
                Penawaran::where('id',$cek->id)->restore();
                
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
        $cek = Penawaran::find($id);
        if (!empty($cek)) {
            $hasil_kata             = session('hasil_kata');
            $data['hasil_kata']     = $hasil_kata;
            $data['penawarans']     = Penawaran::Where('nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('nama')
                                                ->paginate(10);
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
                                                    ->get();
            $data['edit_penawarans']= Penawaran::find($id);
            return view('penawaran.lihat', $data);
        } else {
            return redirect('penawaran');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = Penawaran::find($id);
        if (!empty($cek)) {
            $aturan = [
                'nama'              => 'required',
                'perusahaan'        => 'required',
                'alamat'            => 'required',
                'cp'                => 'required',
                'kontak_cp'         => 'required',
            ];
            $this->validate($request, $aturan);
            
            $cek = Penawaran::onlyTrashed()->where('nama',$request->nama)->first();
            if (empty($cek)) {

                $data = [
                    'nama'              => $request->nama,
                    'perusahaan'        => $request->perusahaan,
                    'alamat'            => $request->alamat,
                    'cp'                => $request->cp,
                    'kontak_cp'         => $request->kontak_cp,
                ];
                
                Penawaran::find($id)->update($data);
                
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
                Penawaran::find($id)->delete();

                $data = [
                    'nama'              => $request->nama,
                    'perusahaan'        => $request->perusahaan,
                    'alamat'            => $request->alamat,
                    'cp'                => $request->cp,
                    'kontak_cp'         => $request->kontak_cp,
                ];
                Penawaran::insert($data);
    
                $setelah_simpan = [
                    'alert'                     => 'sukses',
                    'text'                      => 'Data '.$request->nama.' berhasil diperbarui',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            }

        } else {
            return redirect('penawaran');
        }
    }

    public function hapus($id) {
        $cek = Penawaran::find($id);
        if (!empty($cek)) {
            Penawaran_barang::where('penawarans_id',$id)->delete();
            Penawaran::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('penawaran');
        }
    }

    public function cetak($id) {
        $cek = Penawaran::find($id);
        if (!empty($cek)) {
            $data['penawaran']          = $cek;
            $data['penawaran_barangs']  = Penawaran_barang::selectRaw('barangs.id as id_barangs,
                                                                        barangs.nama as nama_barangs,
                                                                        kategoris.nama as nama_kategoris,
                                                                        merks.nama as nama_merks,
                                                                        tipes.nama as nama_tipes,
                                                                        penawaran_barangs.harga')
                                                            ->join('barangs','barangs.id','penawaran_barangs.barangs_id')
                                                            ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                            ->join('tipes','tipes.id','barangs.tipes_id')
                                                            ->join('merks','merks.id','tipes.merks_id')
                                                            ->where('penawarans_id',$cek->id)
                                                            ->get();
            return view('penawaran.cetak', $data);
        } else {
            return redirect('penawaran');
        }
    }
    
}