<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //load page with $id
    public function getLogin()
    {
        if(session('user'))
        {
            return redirect()->back();
        }
        else{
            return view("pages.login");
        }
    }

    public function postLogin(Request $req)
    {
        // validate
        // $req->validate([
        //     'u_user'   => 'required',
        //     'u_pw'    => 'required',
        // ], [
        //     'u_user.required'  => '入力してください!',
        //     'u_pw.required'   => '入力してください!',
        // ]);

        // check user and pass
        $user = User::where('u_user',$req->u_user)
                    ->where('u_pw', $req->u_pw)->first();
    
        if (isset($user)) {
            session()->regenerate();
            session(['user' => $user]);

            return redirect('staff');
        }
        else {
            return redirect('login');
        }
    }

    public function logout()
    {
        Session::forget('user');
        if(session('user'))
        {
            return redirect()->back();
        }
        else{
            return Redirect('login');
        }
    }

}
