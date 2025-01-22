<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\General;

class AdminController extends Controller {

    public function index(Request $request) {
        $data['hasil_kata']             = '';
        $url_sekarang                   = $request->fullUrl();
        $data['admins']                 = User::orderBy('name')->paginate(10);
        session()->forget('hasil_kata');
        session()->forget('halaman');
        session(['halaman'              => $url_sekarang]);
        return view('admin.lihat',$data);
    }

    public function cari(Request $request) {
        $hasil_kata                     = $request->cari_kata;
        $data['hasil_kata']             = $hasil_kata;
        $url_sekarang                   = $request->fullUrl();
        $data['admins']                 = User::Where('name', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('name')
                                                ->paginate(10);
        session(['hasil_kata'		    => $hasil_kata]);
        session(['halaman'              => $url_sekarang]);
        return view('admin.lihat', $data);
    }

    public function prosestambah(Request $request) {
        $aturan = [
            'username'          => 'required|unique:users',
            'email'             => 'required|unique:users',
            'name'              => 'required',
            'password'          => 'required|string|min:6|confirmed',
        ];
        $this->validate($request, $aturan);

        $cek = User::onlyTrashed()->where('name',$request->name)->first();
        if (empty($cek)) {
            $data = [
                'name'              => $request->name,
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => bcrypt($request->password),
                'created_at'        => date('Y-m-d H:i:s'),
            ];
            User::insert($data);

            $setelah_simpan = [
                'alert'                     => 'sukses',
                'text'                      => 'Data '.$request->name.' berhasil ditambahkan',
            ];
            return redirect()->back()->with('setelah_simpan', $setelah_simpan);
        } else {
            $cek_exist = User::where('name',$request->name)->count();
            if($cek_exist == 0) {
                User::where('id',$cek->id)->restore();
                
                $setelah_simpan = [
                    'alert'                     => 'sukses',
                    'text'                      => 'Data '.$request->name.' berhasil ditambahkan',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            } else {
                $setelah_simpan = [
                    'alert'                     => 'error',
                    'text'                      => 'Data '.$request->name.' sudah ada',
                ];
                return redirect()->back()->with('setelah_simpan', $setelah_simpan);
            }
        }
    }

    public function edit(Request $request, $id) {
        $cek = User::find($id);
        if (!empty($cek)) {
            $hasil_kata             = session('hasil_kata');
            $data['hasil_kata']     = $hasil_kata;
            $data['admins']      = User::Where('name', 'LIKE', '%'.$hasil_kata.'%')
                                                ->orderBy('name')
                                                ->paginate(10);
            $data['edit_admins'] = User::find($id);
            return view('admin.lihat', $data);
        } else {
            return redirect('admin');
        }
    }

    public function prosesedit(Request $request, $id) {
        $cek = User::find($id);
        if (!empty($cek)) {
            if (!empty($request->password)) {
                $aturan = [
                    'username'          => 'required|unique:users,username,'.$id.',id',
                    'email'             => 'required|unique:users,email,'.$id.',id',
                    'name'              => 'required',
                    'password'          => 'required|string|min:6|confirmed',
                ];
                $this->validate($request, $aturan);

                $cek = User::onlyTrashed()->where('name',$request->name)->first();
                if (empty($cek)) {
                    $data = [
                        'name'              => $request->name,
                        'username'          => $request->username,
                        'email'             => $request->email,
                        'password'          => bcrypt($request->password),
                    ];
                    
                    User::find($id)->update($data);
                    
                    $setelah_simpan = [
                        'alert'                     => 'sukses',
                        'text'                      => 'Data '.$request->name.' berhasil diperbarui',
                    ];
    
                    if(request()->session()->get('halaman') != '') {
                        $url = request()->session()->get('halaman');
                        return redirect($url)->with('setelah_simpan', $setelah_simpan);
                    }
                    else
                        return redirect()->back()->with('setelah_simpan', $setelah_simpan);
                } else {
                    User::find($id)->delete();
    
                    $data = [
                        'name'              => $request->name,
                        'username'          => $request->username,
                        'email'             => $request->email,
                        'password'          => bcrypt($request->password),
                    ];
                    User::insert($data);
        
                    $setelah_simpan = [
                        'alert'                     => 'sukses',
                        'text'                      => 'Data '.$request->name.' berhasil diperbarui',
                    ];
                    return redirect()->back()->with('setelah_simpan', $setelah_simpan);
                }
            } else {
                $aturan = [
                    'username'          => 'required|unique:users,username,'.$id.',id',
                    'email'             => 'required|unique:users,email,'.$id.',id',
                    'name'              => 'required',
                ];
                $this->validate($request, $aturan);

                $cek = User::onlyTrashed()->where('name',$request->name)->first();
                if (empty($cek)) {
                    $data = [
                        'name'              => $request->name,
                        'username'          => $request->username,
                        'email'             => $request->email,
                    ];
                    User::find($id)->update($data);
                    
                    $setelah_simpan = [
                        'alert'                     => 'sukses',
                        'text'                      => 'Data '.$request->name.' berhasil diperbarui',
                    ];
    
                    if(request()->session()->get('halaman') != '') {
                        $url = request()->session()->get('halaman');
                        return redirect($url)->with('setelah_simpan', $setelah_simpan);
                    }
                    else
                        return redirect()->back()->with('setelah_simpan', $setelah_simpan);
                } else {
                    User::find($id)->delete();
    
                    $data = [
                        'name'              => $request->name,
                        'username'          => $request->username,
                        'email'             => $request->email,
                    ];
                    User::insert($data);
        
                    $setelah_simpan = [
                        'alert'                     => 'sukses',
                        'text'                      => 'Data '.$request->name.' berhasil diperbarui',
                    ];
                    return redirect()->back()->with('setelah_simpan', $setelah_simpan);
                }
            }
        } else {
            return redirect('admin');
        }
    }

    public function hapus($id) {
        $cek = User::find($id);
        if (!empty($cek)) {
            User::find($id)->delete();
            return response()->json(['sukses' => '"sukses'], 200);
        } else {
            return redirect('admin');
        }
    }
}