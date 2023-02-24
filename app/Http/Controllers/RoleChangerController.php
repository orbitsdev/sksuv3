<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleChangerController extends Controller
{
    

    static function changeRoleTo($user_id, $newrole){

        $user = User::where('id', $user_id)->first();
        $role = Role::where('name', $newrole)->first();
        
        $user->roles()->sync($role->id);
        

       
       
    }
    
}
