<?php

namespace App\Http\Controllers;

use App\Models\Vpa;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;

class VpaController extends Controller

{

    
    public function index(){

        return Inertia::render('osas/vpaindex', [
            'vpas' => Vpa::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->whereHas('user', function($query ,$search){
                    $query->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%");

                });
            })
            ->latest()
            ->with(['user','school_year'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }


    
    public function create(Request $request){

       
        $newrecord = Vpa::create([ 
         'user_id'=> $request->input('user_id'), 
         'school_year_id'=> $request->input('school_year_id'), 

        ]);

        $user = User::where('id', $request->input('user_id'))->first();
        $role = Role::where('name', 'vpaa')->first();
        $user->roles()->sync($role->id);
        
        return redirect()->back()->with('notification', 'Created');
    }


    public function deleteSelected(Request $request){

       
        
        $collection = Vpa::whereIn('id', $request->input('ids'))->get();

        
            
        $role =   Role::where('name', 'guest')->first();

      

        foreach($collection as $data){
            $data->user->roles()->sync($role->id);
          
            
        }
        
        
        Vpa::whereIn('id', $request->input('ids'))->delete();
        
        
        return redirect()->back()->with('notification', 'Campus Delete'); 
    }

}
