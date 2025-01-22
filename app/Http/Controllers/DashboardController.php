<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\Session;
use App\Models\User;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Penawaran;

class DashboardController extends Controller {
    
    public function index()
    {
        $data['total_barang']   = Barang::count();
        $data['barangs']        = Barang::orderBy('created_at','desc')->limit(5)->get();
        $data['total_supplier'] = Supplier::count();
        $data['suppliers']      = Supplier::orderBy('created_at','desc')->limit(5)->get();
        $data['total_penawaran']= Penawaran::count();
        $data['penawarans']     = Penawaran::orderBy('created_at','desc')->limit(5)->get();
        $data['total_admin']    = User::count();
        $data['admins']         = User::orderBy('created_at','desc')->limit(5)->get();
        return view('dashboard/lihat',$data);
    }

    public function logout(Request $request)
    {
        $check_session = Session::where('user_id',Auth::user()->id)->count();
        if($check_session != 0)
            Session::where('user_id',Auth::user()->id)->delete();

        $users_data = [
            'remember_token' => ''
        ];
        User::where('id',Auth::user()->id)
                ->update($users_data);

        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }

}

?>