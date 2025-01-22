<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Helpers\General;

class SupplierController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['suppliers']              = Supplier::orderBy('nama')
                                                ->paginate(10);
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('supplier.lihat',$data);
    }

    public function cari(Request $request) {
        $hasil_kata                     = $request->cari_kata;
        $data['hasil_kata']             = $hasil_kata;
        $url_sekarang                   = $request->fullUrl();
        $data['suppliers']              = Supplier::Supplier::Where('nama', 'LIKE', '%'.$hasil_kata.'%')
                                                    ->orderBy('nama')
                                                    ->paginate(10);
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('supplier.lihat', $data);
    }

    public function prosestambah(Request $request) {
        $aturan = [
            'nama'             => 'required|unique:suppliers,nama,NULL,id,deleted_at,NULL',
        ];
        $this->validate($request, $aturan);

        $cek = Supplier::onlyTrashed()->where('nama',$request->nama)->first();
        if (empty($cek)) {
            $data = [
                'nama'              => $request->nama,
                'telepon'           => $request->telepon,
                'alamat'            => $request->alamat,
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            Supplier::insert($data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->nama.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = Supplier::where('nama',$request->nama)->count();
            if($cek_exist == 0) {
                Supplier::where('id',$cek->id)->restore();
                
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
        $cek = Supplier::find($id);
        if (!empty($cek)) {
            $hasil_kata             = session('hasil_kata');
            $data['hasil_kata']     = $hasil_kata;
            $data['suppliers']          = Supplier::Where('nama', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('nama')
                                                ->paginate(10);
            $data['edit_suppliers']     = Supplier::find($id);
            return view('supplier.lihat', $data);
        } else {
            return redirect('supplier');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = Supplier::find($id);
        if (!empty($cek)) {
            $aturan = [
                'nama'             => 'required|unique:suppliers,nama,'.$id.',id',
            ];
            $this->validate($request, $aturan);
            
            $cek = Supplier::onlyTrashed()->where('nama',$request->nama)->first();
            if (empty($cek)) {

                $data = [
                    'nama'              => $request->nama,
                    'telepon'           => $request->telepon,
                    'alamat'            => $request->alamat,
                ];
                
                Supplier::find($id)->update($data);
                
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
                Supplier::find($id)->delete();

                $data = [
                    'nama'              => $request->nama,
                    'telepon'           => $request->telepon,
                    'alamat'            => $request->alamat,
                ];
                Supplier::insert($data);
    
                $setelah_simpan = [
                    'alert'                     => 'sukses',
                    'text'                      => 'Data '.$request->nama.' berhasil diperbarui',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            }

        } else {
            return redirect('supplier');
        }
    }

    public function hapus($id) {
        $cek = Supplier::find($id);
        if (!empty($cek)) {
            Supplier::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('supplier');
        }
    }
}