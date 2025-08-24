<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RememberMe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check() && Auth::viaRemember()){
            Auth::logout();
            return redirect()->back()->with('user' , 'please relogin for security risks!');
        }
        // $token = $request->cookie('remember_token');
        // $session = Session::get('user_id');
        // if(!$session && !$token){
        //    return redirect('login');
        // }
        
        return $next($request);
    }
}
