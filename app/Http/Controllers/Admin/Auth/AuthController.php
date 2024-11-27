<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    //عرض صفحة تسجيل الدخول للادمن 

    public function login()
    {
        return view('Admin.Auth.login');
    }

    //التحقق من عملية تسجيل الدخول

    public function checkLogin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $check = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($check)) {
            return redirect()->route('admin.index');
        } else {
            return redirect()->route('admin.login')->with('login_error_message', 'Error login. Please enter a valid email and password.');
        }
    }
    

    //تسجيل الخروج

    public function logout()
    {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
       
    }
}