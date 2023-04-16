<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Models\CampusDirector;
use Illuminate\Support\Facades\Request as supportrequest;


class CampusDirectorController extends Controller
{



    public function index(){

        return Inertia::render('osas/campusdirectorindex', [
            'campus_directors' => CampusDirector::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->whereHas('user', function($query ,$search){

          $query->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%");

                });
            })
            ->latest()
            ->with(['user','school_year','campus'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }


    
    public function create(Request $request){

      
        

        $newrecord = CampusDirector::create([ 
         'school_year_id'=> $request->input('school_year_id'), 
         'user_id'=> $request->input('user_id'), 
         'campus_id'=> $request->input('campus_id'), 

        ]);


        $user = User::where('id', $request->input('user_id'))->first();
        $role = Role::where('name', 'campus-director')->first();

        $user->roles()->sync($role->id);
        
        return redirect()->back()->with('notification', 'Created');
    }


    public function deleteSelected(Request $request){

      
        
        $collection = CampusDirector::whereIn('id', $request->input('ids'))->get();

        
            
        $role =   Role::where('name', 'guest')->first();

      

        foreach($collection as $data){
            $data->user->roles()->sync($role->id);
          
            
        }
        
        
        CampusDirector::whereIn('id', $request->input('ids'))->delete();
        
        
        return redirect()->back()->with('notification', 'Campus Delete'); 
    }

}
