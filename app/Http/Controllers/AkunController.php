<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\General;
use Auth;

class AkunController extends Controller {

    public function index(Request $request) {
        session()->forget('halaman');
        return view('akun.lihat');
    }

    public function prosesedit(Request $request) {
        $id = Auth::user()->id;
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
    }

}