<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUser;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('register');
    }
    public function login()
    {
        return view('login', ['error' => null]);
    }
    public function addUser(RegisterUser $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);
        Event::dispatch(new Registered($user));
        return redirect()->route('verification.notice');
    }
    public function auth(Request $request)
    {

        $credentials = $request->only('email' , 'password');
        $remember = $request->has('remember');

        if(Auth::attempt($credentials , $remember)){

           $user = Auth::user();
           if(is_null($user->email_verified_at)){
            Auth::logout();
            return redirect()->back()->with('user' , 'your is email not varified');
           }
           session(['user_id' => $user->id]);
           return redirect()->route('welcome');

        }else{
            return redirect()->back()->with('user' , 'incorrect email/pass');
        }
        
        

        // $user = User::where('email', $request->email)->first();
        // if ($user && Hash::check($request->password, $user->password)) {

        //     session(['user_name' => $user->name, 'user_id' => $user->id]);

        //     if (isset($request->remember)) {
        //         $token = Str::random(10);
        //         $user->remember_token = $token;
        //         $user->save();
        //         Cookie::queue('remember_token', $token, 2);
        //     }

        //     return view('home');
        // }
    }

    public function logout(){
      session()->flush();   
      Auth::logout();
      return redirect('/');
    }

    public function verification(){
        session()->flash('user' , 'type user email');
        return view('verify');
    }

    public function resetpasswordform($token , $email){
        if(!empty($token)){
            session()->flash('user' , 'email verified now reset password');
            return view('reset' , compact('token' , 'email'));
        }else{
            return redirect()->route('login')->with('user' , 'token not found');
        }
    }

     public function resetpass(Request $request){

        $request->validate([
            'password' => [Password::min(8)->mixedCase()->numbers()]
        ]);

        $user = User::where('email' , $request->email)->first();
       if(!empty($request->token)){

         $reset = $request->reset_password;
        $confrim = $request->confirm_password;
        if($reset === $confrim){
            $user->password = Hash::make($confrim);
            $user->save();
            session()->flash('user' , 'password reset... now login again');
            return redirect()->route('login');
        }else{
            return redirect()->route('reset.page')->with('user' , 'password dont match');
        }

       }else{

        return redirect()->route('forgot')->with('user' , 'token is empty');

       }
}

}