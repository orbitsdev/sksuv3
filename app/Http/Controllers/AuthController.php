<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    

    public function create(Request $request){
         

        // dd($request->all());
     $default = 'defaultprofile.jpg';


     $validated = $request->validate([
        'first_name' => ['required'],
        'last_name' => ['required'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:8'],
    ]);

    $user = User::create([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    if($guest= Role::where('name', 'guest')->pluck('id')->first()){
       $user->roles()->sync($guest);
    }

    if (Auth::attempt(['email' => $user->email, 'password' => $validated['password']])) {
        $request->session()->regenerate();

        if (Auth::user()->hasRole('super-admin')) {
            return redirect()->route('superadmin.index');
        }

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

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');

        
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            
            if (Auth::user()->hasRole('super-admin')) {
                return redirect()->route('superadmin.index');
            }

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
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(){

        Auth::logout();

        return redirect()->route('login');
    }
}
