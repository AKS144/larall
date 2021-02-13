<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Verification;
use App\Mail\VerificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Auth\Request;
use App\Rules\Captcha;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';


    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'g-captcha-response' => new Captcha(),//added and reference for google recaptcha
                                                  //and username above rules->reCaptcha
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
//added start from here
        $verify = Verification::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);

        //Mail::to($user->email)->send(new VerificationMail($verify->token));
        Mail::to($user->email)->send(new VerificationMail($user));
        return $user;
    }

    public function verification($token)
    {
        $verify = Verification::where('token',$token)->first();
        if(isset($verify)){
            $user = $verify->user;
            if(!$user->verified){
                $verify->user->verified = '1';
                $verify->user->save();
                $status = "Your email is verified, you can now login right now";
            }else{
                $status = "Your email is already verified,you can login";
            }
        }else{
            return redirect('/login')->with('warning','Sorry your email cannot identified');
        }

        return redirect('/login')->with('success',$status);
    }

    protected function registered($user){
        $this->guard()->logout();
        return redirect('/login')->with('success','Sent you an activation code. Check your email and click on the link to verify.');
    }
}
