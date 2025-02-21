<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
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
            session()->put('actor', 'admin');
            return redirect()->route('admin.index');
        }  else if (Auth::guard('store_houses')->attempt($check)) {
            session()->put('actor', 'store_houses');
            return redirect()->route('admin.index');
        } else if (Auth::guard('employees')->attempt($check)) {
            session()->put('actor', 'employees');
            return redirect()->route('admin.index');
        }
        else if (Auth::guard('pharmacy')->attempt($check)) {
            session()->put('actor', 'pharmacy');
            return redirect()->route('homePage');
        } 
        else {
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
