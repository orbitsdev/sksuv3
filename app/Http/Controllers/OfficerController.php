<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Campus;
use App\Models\CampusAdviser;
use App\Models\Officer;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as supportrequest;

class OfficerController extends Controller
{




    public function index()
    {

        return Inertia::render('sboadviser/officerindex', [
            'campuses' => Campus::query()
                ->when(supportrequest::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })->whereHas('campus_advisers.user', function ($query) {
                    $query->where('id', Auth::user()->id);
                })
                ->latest()->with('campus_adviser.officers.user')
                ->paginate(10)
                ->withQueryString(),
            'filters' => supportrequest::only('search'),
        ]);
    }

    public function manageindex($campus_id)
    {


        return Inertia::render(
            'sboadviser/manageofficerindex',
            [
                'campus' => Campus::find($campus_id),
                'officers' => Officer::when(supportrequest::input('search'), function ($query, $search, $campus_id) {
                    $query->where('id', $campus_id)->whereHas('user', function ($query, $search) {
                        $query->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%");
                    });
                })->latest()->with(['user','campus_adviser.user', 'campus_adviser.campus'])
                    ->paginate(10),
                'filters' => supportrequest::only('search'),
            ]

        );
    }


    
    public function create(Request $request){
         
        $validated = $request->validate([
            'position' => ['required']
        ]);
        $campus_adviser = CampusAdviser::where('user_id', Auth::user()->id)->where('campus_id', $request->input('campus_id'))->first();

        
        $existing = Officer::where('user_id', $request->input('user_id'))->first();

        if($existing){

            $is_officer_sameschool =  $existing->campus_adviser()->campus()->where('id', $request->input('campus_id'))->first();
            dd($is_officer_sameschool);
            return redirect()->back()->with('message', 'User already exist');
        }else{


            $newrecord = Officer::create([
                'campus_adviser_id'=>$campus_adviser->id , 
                'user_id'=> $request->input('user_id'), 
                'position'=> $request->input('position')
               ]);
       
               
               
               $user = User::where('id', $request->input('user_id'))->first();
               $role = Role::where('name', 'sbo-student')->first();
               $user->roles()->sync($role->id);
               return redirect()->back()->with('message', 'Created');

        }
        


    }




    public function update(Request $request){
       
        $validated = $request->validate([
            'position' => ['required']
        ]);
        $campus = Officer::where('id', $request->input('id'))->first();
        
        
        $campus->update([
            'position'=> $request->input('position')
        ]);
        
        return redirect()->back()->with('notification', 'Campus Updated'); 
    }


    public function deleteSelected(Request $request){
        
        $collection = Officer::whereIn('id', $request->input('ids'))->get();

        
            
        $role =   Role::where('name', 'guest')->first();

      

        foreach($collection as $data){
            
            if(count($data->user->officers) <= 1){
                $data->user->roles()->sync($role->id);
                
            }
            
        }
        
        
        Officer::whereIn('id', $request->input('ids'))->delete();
      
        return redirect()->back()->with('notification', 'Campus Delete'); 
    }

}
