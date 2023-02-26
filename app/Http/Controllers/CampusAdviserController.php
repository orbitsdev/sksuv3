<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\CampusAdviser;
use Illuminate\Support\Facades\Request as supportrequest;

class CampusAdviserController extends Controller
{
    

    public function index(){

        return Inertia::render('osas/campusadviserindex', [
            'campus_advisers' => CampusAdviser::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->whereHas('user', function($query ,$search){
                    $query->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->with(['user' , 'school_year', 'campus'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }


    
    public function create(Request $request){
        

        $existing = CampusAdviser::where('user_id', $request->input('user_id'))->where('campus_id', $request->input('campus_id'))->where('school_year_id', $request->input('school_year_id'))->first();

        if($existing){
            return redirect()->back()->with('message', 'User already exist');
            
        }else{
            $campus = CampusAdviser::create([
                'school_year_id'=> $request->input('school_year_id'), 
                'campus_id'=> $request->input('campus_id'), 
                'user_id'=> $request->input('user_id'), 
       
               ]);
       
               
               
               $user = User::where('id', $request->input('user_id'))->first();
               $role = Role::where('name', 'sbo-adviser')->first();
               $user->roles()->sync($role->id);
               
               
               return redirect()->back()->with('message', 'Created');
       
               
            }   

    }


    public function deleteSelected(Request $request){
        
        $collection = CampusAdviser::whereIn('id', $request->input('ids'))->get();

        
            
        $role =   Role::where('name', 'guest')->first();

      

        foreach($collection as $data){
            
            if(count($data->user->campus_advisers) <= 1){
                $data->user->roles()->sync($role->id);
                
            }
            
        }
        
        
        CampusAdviser::whereIn('id', $request->input('ids'))->delete();
        
        
        return redirect()->back()->with('notification', 'Campus Delete'); 
    }

}
