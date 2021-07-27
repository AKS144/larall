<?php

namespace App\Http\Controllers\Auth;

use App\SocialAccount;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //added below
    
    public function authenticated($user)
    {
       if(!$user->verified){
            //auth()->logout();
            Auth::logout();
            return back()
            ->with('warning','You need to confirm your
                    account. We have sent you an activation
                    code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }

    //facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    //facebook
    public function handleFacebookCallback()
    {
        $provider = Socialite::driver('facebook')->user();
        $account = SocialAccount::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            $user = $account->user;
        }else{
            $akun = new SocialAccount([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);
            $orang = User::where('email',$provider->getEmail())->first();
            if(!$orang){
                $orang = User::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'password' => '',
                    'verified' => '1'
                ]);
            }
            $akun->user()->associate($orang);
            $akun->save();
            $user = $orang;
        }
        //auth()->login($user);
        Auth::login($user);
        return redirect()->to('/home');
    }

    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->stateless()->redirect();
    }

    //facebook
    public function handleTwitterCallback()
    {
        $provider = Socialite::driver('twitter')->user();
        $account = SocialAccount::where('provider','twitter')->where('provider_user_id',$provider->getId())->first();
        if($account){
            $user = $account->user;
        }else{
            $akun = new SocialAccount([
                'provider_user_id' => $provider->getId(),
                'provider' => 'twitter'
            ]);
            $orang = User::where('email',$provider->getEmail())->first();
            if(!$orang){
                $orang = User::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'password' => '',
                    'verified' => '1'
                ]);
            }
            $akun->user()->associate($orang);
            $akun->save();
            $user = $orang;
        }
        //auth()->login($user);
        Auth::login($user);
        return redirect()->to('/home');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    //facebook
    public function handleGoogleCallback()
    {
        $provider = Socialite::driver('google')->user();
        $account = SocialAccount::where('provider','google')->where('provider_user_id',$provider->getId())->first();
        if($account){
            $user = $account->user;
        }else{
            $akun = new SocialAccount([
                'provider_user_id' => $provider->getId(),
                'provider' => 'google'
            ]);
            $orang = User::where('email',$provider->getEmail())->first();
            if(!$orang){
                $orang = User::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'password' => '',
                    'verified' => '1'
                ]);
            }
            $akun->user()->associate($orang);
            $akun->save();
            $user = $orang;
        }
        //auth()->login($user);
        Auth::login($user);
        return redirect()->to('/home');
    }

}
