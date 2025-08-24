<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword as MailResetPassword;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Str;


class EmailsController extends Controller
{
    //
    public function WelcomeMail()
    {
        Mail::to('allhamduallahdotcom@gmail.com')->send(new WelcomeMail);
        return 'email send sucessfully';
    }

    public function resetpasswordlink(Request $request){

        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email' , $request->email)->first();
        if($user){

            $token = Str::random(64);
            if(empty($user->remember_token_password)){
                $user->remember_token_password = $token;
                $user->save();
            }else{
                $user->remember_token_password= null;
                $user->remember_token_password = $token;
                $user->save();
            }

            Mail::to($request->email)->send(new MailResetPassword($token , $user));
            session()->flash('user' , 'mail have been sent ... check your mail');
            return view('verify');

        }else{
             session()->flash('user' , 'user not found');
            return view('verify');
        }

    }

    public function sendmail(){
    return view('Emails.verify');
    }

    public function verifymail(EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('login')->with('user' , 'user registered now login');
     }  
     
     public function resendemail(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
     }
}
