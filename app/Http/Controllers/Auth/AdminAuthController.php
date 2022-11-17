<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function loginPage()
    {
        if(session('login_error')){
            toast(Session::get('login_error'), "error");
        }
        if(session('admin_error')){
            toast(Session::get('admin_error'), "error");
        }
        if(session('logout')){
            toast(Session::get('logout'), "success");
        }
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/')
                        ->with('login_success','You have been login successfully! ');
        }

        return redirect()->back()->with('login_error','Oppes! You have entered invalid credentials');
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect('/auth/login')->with('logout', 'You have been logout successfully!');
    }
}
