<?php

namespace App\Http\Middleware\Admin\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if((!FacadesAuth::guard('admin')->check()) && (!FacadesAuth::guard('store_houses')->check()) && (!FacadesAuth::guard('employees')->check()) && (!FacadesAuth::guard('pharmacy')->check()))
        {
            return redirect()->route('admin.login')->with('error_message' , 'You Are Not Login , Please Login First');
        }
        return $next($request);
    }
}
