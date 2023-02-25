<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleChangerController extends Controller
{
    

    static function changeRoleTo($user_id, $newrole){

        $user = User::where('id', $user_id)->first();
        $role = Role::where('name', $newrole)->first();
        
        $user->roles()->sync($role->id);
        
       
    }

    static function sboCurrentSchool (){

        if(Auth::user()->hasRole('sbo-adviser')){
            
            $campus = Campus::whereHas('campus_adviser.user', function($query){
                $query->where('id', Auth::user()->id);
            })->latest()->first();

          if($campus){

              return $campus->name;
          }else{
            return null;
          }
            // $campus  = Campus::whereHas('campus_adviser.user', function($query){
            //         $query->where('id', Auth::user('id'));
            // })->latest()->first();

            // dd($campus);
            // return $campus->name;
        }else{
            return null;
        }

    }
    
}
