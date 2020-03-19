<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\User;
use App\ModelUser;
use Carbon\Carbon;

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
        $req->validate([
            'u_user'   => 'required',
            'u_pw'    => 'required',
        ], [
            'u_user.required'  => '入力してください!',
            'u_pw.required'   => '入力してください!',
        ]);

        // check user and pass
        $user = User::where('u_user',$req->u_user)
                    ->where('u_pw', $req->u_pw)->first();
    
        if (isset($user)) {
            session()->regenerate();
            session(['user' => $user]);

            return redirect('staff');
        }
        else {
            return redirect()->back()->with('danger', 'Login unsuccessfully');
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


    public function getChangePassword()
    {
         return view("pages.changepassword");
    }

    public function changePassword(Request $req)
    {
        // validate
        $req->validate([
            'u_user'   => 'required',
            'u_pw'    => 'required',
        ], [
            'u_user.required'  => '入力してください!',
            'u_pw.required'   => '入力してください!',
        ]);

        $user = User::where('u_user',$req->u_user)
                    ->where('u_pw', $req->u_pw)->first();
    
        if (isset($user)) {
            if($req->pass_new != null && $req->pass_confirm != null)
            {
                if($req->pass_new == $req->pass_confirm){

                    $sql = User::where('u_id', $user->u_id)->first();
    
                    $sql->u_pw = $req->pass_confirm;
                    $sql->save();
                    return redirect('login');
                }
                else{
                    return redirect()->back()->with('danger', 'Change unsuccessfully...Please check password new - password confirm');
                }
            }
            else{
                return redirect()->back()->with('danger', 'Change unsuccessfully...Please input password new - password confirm');
            }
        }
        else {
            return redirect()->back()->with('danger', 'Change unsuccessfully...Please check username - password');
        }
    }

}
