<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Tipe;
use App\Models\Barang;
use App\Helpers\General;
use Storage;

class BarangController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['barangs']                = Barang::selectRaw('barangs.id as id_barangs,
                                                            barangs.nama as nama_barangs,
                                                            barangs.foto as foto_barangs,
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
                                                            barangs.foto as foto_barangs,
                                                            barangs.harga_jual,
                                                            barangs.stok,
                                                            barangs.brosur,
                                                            kategoris.nama as nama_kategoris,
                                                            merks.nama as nama_merks,
                                                            tipes.nama as nama_tipes')
                                                ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                ->join('tipes','tipes.id','barangs.tipes_id')
                                                ->join('merks','merks.id','tipes.merks_id')
                                                ->where('kategoris.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orWhere('merks.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orWhere('tipes.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orWhere('barangs.nama', 'LIKE', '%'.$hasil_kata.'%')
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
        $cek = Barang::onlyTrashed()->where('nama',$request->nama)->first();
        if (empty($cek)) {
            $aturan = [
                'kategoris_id'      => 'required',
                'tipes_id'          => 'required',
                'nama'              => 'required|unique:barangs,nama,NULL,id,deleted_at,NULL',
                'harga_jual'        => 'required',
                'stok'              => 'required',
            ];
            $this->validate($request, $aturan);

            $data = [
                'kategoris_id'      => $request->kategoris_id,
                'tipes_id'          => $request->tipes_id,
                'nama'              => $request->nama,
                'harga_jual'        => General::ubahHargaKeDB($request->harga_jual),
                'stok'              => $request->stok,
                'created_at'        => date('Y-m-d H:i:s'),
            ];

            if(!empty($request->brosur)) {
                $aturan = [
                    'brosur'            => 'required|mimes:pdf',
                ];
                $this->validate($request, $aturan);

                $id_barang = Barang::insertGetId($data);

                $nama_brosur = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('brosur')->getClientOriginalName())));
                $path_brosur = 'barang/';
                Storage::disk('public')->put($path_brosur.$nama_brosur, file_get_contents($request->file('brosur')));

                $data = [
                    'brosur'            => $path_brosur.$nama_brosur,
                ];
                Barang::find($id_barang)->update($data);
            }

            if(!empty($request->foto)) {
                $aturan = [
                    'foto'            => 'required|mimes:jpg,jpeg,png',
                ];
                $this->validate($request, $aturan);
                
                $id_barang = Barang::insertGetId($data);

                $nama_foto = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('foto')->getClientOriginalName())));
                $path_foto = 'barang/';
                Storage::disk('public')->put($path_foto.$nama_foto, file_get_contents($request->file('foto')));

                $data = [
                    'foto'            => $path_foto.$nama_foto,
                ];
                Barang::find($id_barang)->update($data);
            }

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = Barang::where('nama',$request->nama)->count();
            if($cek_exist == 0) {
                Barang::where('id',$cek->id)->restore();
                $id = $cek->id;
                
                if(!empty($request->brosur)) {
                    $aturan = [
                        'brosur'            => 'required|mimes:pdf',
                    ];
                    $this->validate($request, $aturan);

                    $brosur_lama        = $cek->brosur;
                    if (Storage::disk('public')->exists($brosur_lama))
                        Storage::disk('public')->delete($brosur_lama);

                    $nama_brosur = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('brosur')->getClientOriginalName())));
                    $path_brosur = 'barang/';
                    Storage::disk('public')->put($path_brosur.$nama_brosur, file_get_contents($request->file('brosur')));

                    $data = [
                        'brosur'            => $path_brosur.$nama_brosur,
                    ];
                    Barang::find($id)->update($data);
                }

                if(!empty($request->foto)) {
                    $aturan = [
                        'foto'            => 'required|mimes:jpg,jpeg,png',
                    ];
                    $this->validate($request, $aturan);
                    
                    $foto_lama        = $cek->foto;
                    if (Storage::disk('public')->exists($foto_lama))
                        Storage::disk('public')->delete($foto_lama);
    
                    $nama_foto = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('foto')->getClientOriginalName())));
                    $path_foto = 'barang/';
                    Storage::disk('public')->put($path_foto.$nama_foto, file_get_contents($request->file('foto')));
    
                    $data = [
                        'foto'            => $path_foto.$nama_foto,
                    ];
                    Barang::find($id)->update($data);
                }
                
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
            $data['barangs']                = Barang::selectRaw('barangs.id as id_barangs,
                                                                barangs.nama as nama_barangs,
                                                                barangs.foto as foto_barangs,
                                                                barangs.harga_jual,
                                                                barangs.stok,
                                                                barangs.brosur,
                                                                kategoris.nama as nama_kategoris,
                                                                merks.nama as nama_merks,
                                                                tipes.nama as nama_tipes')
                                                    ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                    ->join('tipes','tipes.id','barangs.tipes_id')
                                                    ->join('merks','merks.id','tipes.merks_id')
                                                    ->where('kategoris.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orWhere('merks.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orWhere('tipes.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orWhere('barangs.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orderBy('barangs.nama')
                                                    ->paginate(10);
            $data['edit_barangs']   = Barang::find($id);
            $data['kategoris']              = Kategori::orderBy('nama')->get();
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
            $cek_deleted = Barang::onlyTrashed()->where('nama',$request->nama)->first();
            if (empty($cek_deleted)) {
                $aturan = [
                    'kategoris_id'      => 'required',
                    'tipes_id'          => 'required',
                    'nama'              => 'required|unique:merks,nama,'.$id.',id',
                    'harga_jual'        => 'required',
                    'stok'              => 'required',
                ];
                $this->validate($request, $aturan);

                $data = [
                    'kategoris_id'      => $request->kategoris_id,
                    'tipes_id'          => $request->tipes_id,
                    'nama'              => $request->nama,
                    'harga_jual'        => General::ubahHargaKeDB($request->harga_jual),
                    'stok'              => $request->stok,
                ];
                Barang::find($id)->update($data);

                if(!empty($request->brosur)) {
                    $aturan = [
                        'brosur'            => 'required|mimes:pdf',
                    ];
                    $this->validate($request, $aturan);

                    $brosur_lama        = $cek->brosur;
                    if (Storage::disk('public')->exists($brosur_lama))
                        Storage::disk('public')->delete($brosur_lama);

                    $nama_brosur = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('brosur')->getClientOriginalName())));
                    $path_brosur = 'barang/';
                    Storage::disk('public')->put($path_brosur.$nama_brosur, file_get_contents($request->file('brosur')));

                    $data = [
                        'brosur'            => $path_brosur.$nama_brosur,
                    ];
                    Barang::find($id)->update($data);
                }

                if(!empty($request->foto)) {
                    $aturan = [
                        'foto'            => 'required|mimes:jpg,jpeg,png',
                    ];
                    $this->validate($request, $aturan);
                    
                    $foto_lama        = $cek->foto;
                    if (Storage::disk('public')->exists($foto_lama))
                        Storage::disk('public')->delete($foto_lama);
    
                    $nama_foto = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('foto')->getClientOriginalName())));
                    $path_foto = 'barang/';
                    Storage::disk('public')->put($path_foto.$nama_foto, file_get_contents($request->file('foto')));
    
                    $data = [
                        'foto'            => $path_foto.$nama_foto,
                    ];
                    Barang::find($id)->update($data);
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
                $cek_barang         = Barang::find($id);
                $brosur_lama        = $cek_barang->brosur;
                if (Storage::disk('public')->exists($brosur_lama))
                    Storage::disk('public')->delete($brosur_lama);

                $foto_lama        = $cek_barang->foto;
                if (Storage::disk('public')->exists($foto_lama))
                    Storage::disk('public')->delete($foto_lama);

                Barang::find($id)->delete();

                $aturan = [
                    'kategoris_id'      => 'required',
                    'tipes_id'          => 'required',
                    'nama'              => 'required|unique:barangs,nama,NULL,id,deleted_at,NULL',
                    'harga_jual'        => 'required',
                    'stok'              => 'required',
                ];
                $this->validate($request, $aturan);
    
                $data = [
                    'kategoris_id'      => $request->kategoris_id,
                    'tipes_id'          => $request->tipes_id,
                    'nama'              => $request->nama,
                    'harga_jual'        => General::ubahHargaKeDB($request->harga_jual),
                    'stok'              => $request->stok,
                    'created_at'        => date('Y-m-d H:i:s'),
                ];
    
                if(!empty($cek_barang->brosur)) {
                    $aturan = [
                        'brosur'            => 'required|mimes:pdf',
                    ];
                    $this->validate($request, $aturan);
    
                    $id_barang = Barang::insertGetId($data);
    
                    $nama_brosur = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('brosur')->getClientOriginalName())));
                    $path_brosur = 'barang/';
                    Storage::disk('public')->put($path_brosur.$nama_brosur, file_get_contents($request->file('brosur')));
    
                    $data = [
                        'brosur'            => $path_brosur.$nama_brosur,
                    ];
                    Barang::find($id_barang)->update($data);
                }
    
                if(!empty($request->foto)) {
                    $aturan = [
                        'foto'            => 'required|mimes:jpg,jpeg,png',
                    ];
                    $this->validate($request, $aturan);
                    
                    $id_barang = Barang::insertGetId($data);
    
                    $nama_foto = date('Ymd').date('His').str_replace(')','',str_replace('(','',str_replace(' ','-',$request->file('foto')->getClientOriginalName())));
                    $path_foto = 'barang/';
                    Storage::disk('public')->put($path_foto.$nama_foto, file_get_contents($request->file('foto')));
    
                    $data = [
                        'foto'            => $path_foto.$nama_foto,
                    ];
                    Barang::find($id_barang)->update($data);
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