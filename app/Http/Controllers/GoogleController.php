<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Request as supportrequest;

class GoogleController extends Controller
{


    public function redirectToProvider($provider)
    {


        //  Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        // return Socialite::driver($provider)->stateless()->redirect();
        return Socialite::driver($provider)->redirect();
         
    }


    public function handleProviderCallback($provider)
    {       


        

        // $user = Socialite::driver($provider)->stateless()->user();
        $user = Socialite::driver($provider)->user();
        




        $user_account = User::where('email', $user->email)->first();
    
        if (!$user_account) {
            $user_account = User::create([
                'first_name' => $user->user["given_name"],
                'last_name' => $user->user["family_name"],
                'email' => $user->email,
                'password' => Hash::make($provider . $user->email . $user->name),
            ]);
    
            SocialAccount::create([
                'user_id' => $user_account->id,
                'provider_user_id' => $user->id,
                'provider' => $provider
            ]);
    
            if ($guest = Role::where('name', 'guest')->pluck('id')->first()) {
                $user_account->roles()->sync($guest);
            }
        } else {
            if (count($user_account->social_accounts) === 0) {
                $account = SocialAccount::create([
                    'user_id' => $user_account->id,
                    'provider_user_id' => $user->id,
                    'provider' => $provider
                ]);
            }
        }
    
        Auth::login($user_account);


        if(Auth::user()->hasRole('osas')){
            return redirect()->route('schoolyear.index');
        }

        
        if(Auth::user()->hasRole('sbo-adviser')){

            
            return redirect()->route('campusadviser.organization.index');

        }
        if(Auth::user()->hasRole('campus-director')){

            
            return redirect()->route('director.organization.index');

        }
        if(Auth::user()->hasRole('vpaa')){

            
            return redirect()->route('vpa.organization.index');

        }


        if(Auth::user()->hasRoleOF(['guest','sbo-student'])){
                    

            return redirect()->route('application.index');
        }
        return redirect()->route('application.index');

    }
}
