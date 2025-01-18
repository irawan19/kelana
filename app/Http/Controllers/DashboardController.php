<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\Session;
use App\Models\User;

class DashboardController extends Controller {
    
    public function index()
    {
        return view('dashboard/lihat');
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