<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationProcess;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Inertia\Inertia;


use Illuminate\Support\Facades\Request as supportrequest;


class ApplyApplicationController extends Controller
{


    public function index(){


        return Inertia::render('student/applicationindex',[
            'organizations' => Organization::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()->
            with(['requirements.organization_requirements','organization_requirements.file', 'organization_process'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }


    public function create(Request $request){

        $validated = $request->validate([
            'name'=> ['required']
        ]);


        $new_record = Organization::create([
            'name'=> $request->input('name')
        ]);


        //get all requirments       
        
        $requirements = Requirement::pluck('id');
        

      

        if (count($requirements) > 0) {
            $new_record->requirements()->sync($requirements);
        }

        //create process
        

        $new_process = OrganizationProcess::create([
           'organization_id'=> $new_record->id ,
           
           'campus_adviser_id'=>  $request->input('campus_adviser_id'),
           'campus_adviser_approved_status'=> 'waiting for review',
           'campus_adviser_endorsed_status'=> 'false',
            
           'campus_director_id'=> null ,
           'campus_director_approved_status'=> 'waiting for review' ,
           'campus_director_endorsed_status'=>  'false',

           'osas_id'=> null ,
           'osas_approved_status'=> 'waiting for review',
           'osas_endorsed_status'=>  'false',
            
           'vpa_id'=> null ,
           'vpa_approved_status'=> 'waiting for review',
           'vpa_endorsed_status'=> 'false' ,
        ]);
        
        return redirect()->back()->with('notification', 'Created');
    }
    public function update(Request $request){
        $validated = $request->validate([
            'name' => ['required']
        ]);

        $campus = Organization::where('id', $request->input('id'))->first();
        
        
        $campus->update([
            'name'=> $request->input('name')
        ]);
        
        return redirect()->back()->with('notification', 'Campus Updated'); 
    }


    public function deleteSelected(Request $request){
        
        // $campus = Campus::wheeIn('id', $request->input('ids'))->get();
         Campus::whereIn('id', $request->input('ids'))->delete();
        
        return redirect()->back()->with('notification', 'Campus Delete'); 
    }
}
