<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{   
    public function getLogin(){
        return view('login');
    }

    public function postLogin(Request $request){
        $login = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = User::where('username',$request->username)->value('username');
        $password = User::where('username',$request->username)->value('password');

        if(Auth::guard('web')->attempt(['username' => $request->username, 'password'=> $request->password, 'status'=>'1']))
        {   
            $request->session()->regenerate();
            if(Auth::user()->isOwner == true){
                return redirect()->intended('dashboard-owner');
            }else{
                return redirect()->intended('dashboard-karyawan');
            }
        }elseif($request->username == $username && bcrypt($request->password) !== $password){
            return back()->with('message','Password yang Anda masukkan salah')->with('status','error');
        }elseif($request->username !== $username && bcrypt($request->password) == $password){
            return back()->with('message','Username yang Anda masukkan salah')->with('status','error');
        }elseif($request->username !== $username && bcrypt($request->password) !== $password){
            return back()->with('message','Username dan password yang Anda masukkan salah')->with('status','error');
        }
     }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->invalidate();
        $request->session()->flush();
        session()->regenerateToken();
        return redirect('/login');
    }
}
