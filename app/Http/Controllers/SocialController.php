<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    //social login for facebook
    public function facebook_redirect(){
        return Socialite::driver('facebook')->redirect();
    }
    public function login_with_facebook(){
        $user = Socialite::driver('facebook')->stateless()->user();

        $get_user = User::Where('facebook_id', $user->id)->first();
        if($get_user){
            Auth::login($get_user);

            return redirect('/login');
        }else{
            $new_user = new User();

            $new_user->name = $user->name;
            $new_user->email = $user->email;
            $new_user->facebook_id = $user->id;
//            dd($user->password);
            $new_user->password = bcrypt('1234');

            $new_user->save();

            Auth::login($new_user);

            return redirect('/login');
        }
    }

    //social login for google
    public function google_redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function login_with_google(){
        $user = Socialite::driver('google')->stateless()->user();

        $get_user = User::Where('google_id', $user->id)->first();
        if($get_user){
            Auth::login($get_user);

            return redirect('/login');
        }else{
            $new_user = new User();

            $new_user->name = $user->name;
            $new_user->email = $user->email;
            $new_user->google_id = $user->id;
//            dd($user->password);
            $new_user->password = bcrypt('1234');

            $new_user->save();

            Auth::login($new_user);

            return redirect('/login');
        }
    }

    //social login for gitHub
    public function github_redirect(){
        return Socialite::driver('github')->redirect();
    }
    public function login_with_github(){
        $user = Socialite::driver('github')->stateless()->user();

        $get_user = User::Where('github_id', $user->id)->first();
        if($get_user){
            Auth::login($get_user);

            return redirect('/login');
        }else{
            $new_user = new User();

            $new_user->name = $user->name;
            $new_user->email = $user->email;
            $new_user->github_id = $user->id;
//            dd($user->password);
            $new_user->password = bcrypt('1234');

            $new_user->save();

            Auth::login($new_user);

            return redirect('/login');
        }
    }
}
