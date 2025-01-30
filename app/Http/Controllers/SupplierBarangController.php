<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Supplier_barang;
use App\Helpers\General;

class SupplierBarangController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['barangs']                = Barang::selectRaw('barangs.id as id_barangs,
                                                        barangs.nama as nama_barangs,
                                                        barangs.harga_jual,
                                                        barangs.stok,
                                                        kategoris.nama as nama_kategoris,
                                                        merks.nama as nama_merks,
                                                        tipes.nama as nama_tipes')
                                                ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                ->join('tipes','tipes.id','barangs.tipes_id')
                                                ->join('merks','merks.id','tipes.merks_id')
                                                ->orderBy('barangs.nama')
                                                ->get();
        $data['suppliers']              = Supplier::orderBy('nama')->get();
        $data['supplier_barangs']       = Supplier_barang::selectRaw('supplier_barangs.id as id_supplier_barangs,
                                                                        suppliers.id as id_suppliers,
                                                                        suppliers.nama as nama_suppliers,
                                                                        suppliers.telepon as telepon_suppliers,
                                                                        suppliers.alamat as alamat_suppliers,
                                                                        supplier_barangs.harga_beli as harga_beli,
                                                                        kategoris.nama as nama_kategoris,
                                                                        merks.nama as nama_merks,
                                                                        tipes.nama as nama_tipes,
                                                                        barangs.id as id_barangs,
                                                                        barangs.nama as nama_barangs,
                                                                        barangs.harga_jual,
                                                                        barangs.stok')
                                                        ->join('suppliers','suppliers.id','supplier_barangs.suppliers_id')
                                                        ->join('barangs','barangs.id','supplier_barangs.barangs_id')
                                                        ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                        ->join('tipes','tipes.id','barangs.tipes_id')
                                                        ->join('merks','merks.id','tipes.merks_id')
                                                        ->orderBy('suppliers.nama')
                                                        ->orderBy('barangs.nama')
                                                        ->paginate(10);
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('supplier_barang.lihat',$data);
    }

    public function cari(Request $request) {
        $hasil_kata                     = $request->cari_kata;
        $data['hasil_kata']             = $hasil_kata;
        $url_sekarang                   = $request->fullUrl();
        $data['barangs']                = Barang::selectRaw('barangs.id as id_barangs,
                                                        barangs.nama as nama_barangs,
                                                        barangs.harga_jual,
                                                        barangs.stok,
                                                        kategoris.nama as nama_kategoris,
                                                        merks.nama as nama_merks,
                                                        tipes.nama as nama_tipes')
                                                ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                ->join('tipes','tipes.id','barangs.tipes_id')
                                                ->join('merks','merks.id','tipes.merks_id')
                                                ->orderBy('barangs.nama')
                                                ->get();
        $data['suppliers']              = Supplier::orderBy('nama')->get();
        $data['supplier_barangs']       = Supplier_barang::selectRaw('supplier_barangs.id as id_supplier_barangs,
                                                                        suppliers.id as id_suppliers,
                                                                        suppliers.nama as nama_suppliers,
                                                                        suppliers.telepon as telepon_suppliers,
                                                                        suppliers.alamat as alamat_suppliers,
                                                                        supplier_barangs.harga_beli as harga_beli,
                                                                        kategoris.nama as nama_kategoris,
                                                                        merks.nama as nama_merks,
                                                                        tipes.nama as nama_tipes,
                                                                        barangs.id as id_barangs,
                                                                        barangs.nama as nama_barangs,
                                                                        barangs.harga_jual,
                                                                        barangs.stok')
                                                        ->join('suppliers','suppliers.id','supplier_barangs.suppliers_id')
                                                        ->join('barangs','barangs.id','supplier_barangs.barangs_id')
                                                        ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                        ->join('tipes','tipes.id','barangs.tipes_id')
                                                        ->join('merks','merks.id','tipes.merks_id')
                                                        ->where('suppliers.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('suppliers.telepon', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('suppliers.alamat', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('kategoris.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('merks.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('barangs.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orderBy('suppliers.nama')
                                                        ->paginate(10);
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('supplier_barang.lihat', $data);
    }

    public function prosestambah(Request $request) {
        $cek_data = Supplier_barang::where('suppliers_id',$request->suppliers_id)->where('barangs_id',$request->barangs_id)->count();
        if ($cek_data == 0) {
            $aturan = [
                'suppliers_id'              => 'required',
                'barangs_id'                => 'required',
                'harga_beli'                => 'required',
            ];
            $this->validate($request, $aturan);

            $cek = Supplier_barang::onlyTrashed()->where('suppliers_id',$request->suppliers_id)->where('barangs_id',$request->barangs_id)->first();
            if (empty($cek)) {
                $data = [
                    'suppliers_id'          => $request->suppliers_id,
                    'barangs_id'            => $request->barangs_id,
                    'harga_beli'            => General::ubahHargaKeDB($request->harga_beli),
                    'created_at'            => date('Y-m-d H:i:s'),
                ];
                Supplier_barang::insert($data);

                $setelah_simpan = [
                    'alert'                     => 'sukses',
                    'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            } else {
                $cek_exist = Supplier_barang::where('suppliers_id',$request->suppliers_id)->where('barangs_id', $request->barangs_id)->count();
                if($cek_exist == 0) {
                    Supplier_barang::where('id',$cek->id)->restore();
                    
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
        } else {
            $setelah_simpan = [
                'alert'                     => 'error',
                'text'                      => 'Data sudah ada',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        }
    }

    public function edit(Request $request, $id) {
        $cek = Supplier_barang::find($id);
        if (!empty($cek)) {
            $hasil_kata                 = session('hasil_kata');
            $data['hasil_kata']         = $hasil_kata;
            $data['barangs']            = Barang::selectRaw('barangs.id as id_barangs,
                                                            barangs.nama as nama_barangs,
                                                            barangs.harga_jual,
                                                            barangs.stok,
                                                            kategoris.nama as nama_kategoris,
                                                            merks.nama as nama_merks,
                                                            tipes.nama as nama_tipes')
                                                    ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                    ->join('tipes','tipes.id','barangs.tipes_id')
                                                    ->join('merks','merks.id','tipes.merks_id')
                                                    ->orderBy('barangs.nama')
                                                    ->get();
            $data['suppliers']          = Supplier::orderBy('nama')->get();
            $data['supplier_barangs']   = Supplier_barang::selectRaw('supplier_barangs.id as id_supplier_barangs,
                                                                suppliers.id as id_suppliers,
                                                                suppliers.nama as nama_suppliers,
                                                                suppliers.telepon as telepon_suppliers,
                                                                suppliers.alamat as alamat_suppliers,
                                                                supplier_barangs.harga_beli as harga_beli,
                                                                kategoris.nama as nama_kategoris,
                                                                merks.nama as nama_merks,
                                                                tipes.nama as nama_tipes,
                                                                barangs.id as id_barangs,
                                                                barangs.nama as nama_barangs,
                                                                barangs.harga_jual,
                                                                barangs.stok')
                                                        ->join('suppliers','suppliers.id','supplier_barangs.suppliers_id')
                                                        ->join('barangs','barangs.id','supplier_barangs.barangs_id')
                                                        ->join('kategoris','kategoris.id','barangs.kategoris_id')
                                                        ->join('tipes','tipes.id','barangs.tipes_id')
                                                        ->join('merks','merks.id','tipes.merks_id')
                                                        ->where('suppliers.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('suppliers.telepon', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('suppliers.alamat', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('kategoris.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('merks.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orWhere('barangs.nama', 'LIKE', '%'.$hasil_kata.'%')
                                                        ->orderBy('suppliers.nama')
                                                        ->paginate(10);
            $data['edit_supplier_barangs']     = Supplier_barang::find($id);
            return view('supplier_barang.lihat', $data);
        } else {
            return redirect('supplier_barang');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = Supplier_barang::find($id);
        if (!empty($cek)) {
            $aturan = [
                'suppliers_id'              => 'required',
                'barangs_id'                => 'required',
                'harga_beli'                => 'required',
            ];
            $this->validate($request, $aturan);
            
            $cek = Supplier_barang::onlyTrashed()->where('suppliers_id',$request->suppliers_id)->where('barangs_id', $request->barangs_id)->first();
            if (empty($cek)) {
                $cek_data = Supplier_barang::where('suppliers_id',$request->suppliers_id)->where('barangs_id',$request->barangs_id)->count();
                if ($cek_data == 0) {
                    $data = [
                        'suppliers_id'          => $request->suppliers_id,
                        'barangs_id'            => $request->barangs_id,
                        'harga_beli'            => General::ubahHargaKeDB($request->harga_beli),
                    ];
                    
                    Supplier_barang::find($id)->update($data);
                
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
                    $setelah_simpan = [
                        'alert'                     => 'error',
                        'text'                      => 'Data sudah ada',
                    ];
                    return redirect()->back()->with('setelah_simpan', $setelah_simpan);
                }
            } else {
                Supplier_barang::find($id)->delete();

                $data = [
                    'suppliers_id'          => $request->suppliers_id,
                    'barangs_id'            => $request->barangs_id,
                    'harga_beli'            => General::ubahHargaKeDB($request->harga_beli),
                ];
                Supplier_barang::insert($data);
                
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
            return redirect('supplier_barang');
        }
    }

    public function hapus($id) {
        $cek = Supplier_barang::find($id);
        if (!empty($cek)) {
            Supplier_barang::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('supplier_barang');
        }
    }
}