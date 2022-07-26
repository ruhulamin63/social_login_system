<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function facebook_redirect(){
        return Socialite::driver('facebook')->redirect();
    }

    public function login_with_facebook(){
        $user = Socialite::driver('facebook')->stateless()->user();

        $get_user = User::Where('facebook_id', $user->id)->first();
        if($get_user){
            Auth::login($get_user);

            return redirect('/home');
        }else{
            $new_user = new User();

            $new_user->name = $user->name;
            $new_user->email = $user->email;
            $new_user->facebook_id = $user->id;
            $new_user->password = bcrypt($user->password);

            $new_user->save();

            Auth::login($new_user);

            return redirect('/home');
        }
    }
}
