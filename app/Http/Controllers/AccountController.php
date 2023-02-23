<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as supportrequest;

class AccountController extends Controller
{


    public function index(){

        return Inertia::render('osas/accounts');

    }

    public function userPasswordIndex(){


        return Inertia::render('osas/accountpasswordindex', [
            'users'=> User::query()->
            when(supportrequest::input('search'), function($query, $search){
                $query->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            })->paginate(10)->withQueryString(),
            'filters'=> supportrequest::only(['search'])
        ]);

    }

    public function userCampusAdviserIndex(){


        return Inertia::render('osas/campusadviserindex');
    
    }


    public function userPasswordUpdate(Request $request){   
  
     $validated = $request->validate([
        'password' => ['required', 'min:8'],
    ]);


    $user = User::where('id', $request->input('id'))->update([
        'password'=> Hash::make($request->input('password'))
    ]);

    return redirect()->back();

}
}
