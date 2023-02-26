<?php

namespace App\Http\Controllers;

use App\Models\File;
use Inertia\Inertia;
use App\Models\Requirement;
use App\Models\Organization;
use Illuminate\Http\Request;


use App\Models\OrganizationProcess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as supportrequest;


class ApplyApplicationController extends Controller


{

    public function __construct( )
    {
            $fcontroller = app('App\Http\Controllers\FileController');
    }

    public function deleteFile(Request $request){

        if($request->file_id)
        {
            $file = File::find($request->file_id);

            if($file)
            {
              $status = $this->deleteImageOss($file->url);
            }
            $file->delete();
            // $this->deleteFile();
         
        }
        return redirect()->route('application.index');
    }

    public function index(){


        return Inertia::render('student/applicationindex',[
            'organizations' => Organization::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })->whereHas('user', function($query){
                $query->where('id', Auth::user('id')->id);
            })
            ->latest()->
            with(['campus_adviser.user', 'campus_adviser.school_year', 'requirements.organization_requirements','organization_requirements' => function($org) {
                $org->with(['requirement', 'file']);
            },'organization_process'])
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
            'campus_adviser_id'=> $request->campus_adviser_id,
            'user_id'=> Auth::user()->id,
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
        
        // dd($request->all());
        // $campus = Campus::wheeIn('id', $request->input('ids'))->get();
       $collection =   Organization::whereIn('id', $request->input('ids'))
                        ->with(['organization_requirements' => function($org) {
                            $org->with(['file']);
                        }])
                            ->get();


         foreach($collection as  $data){
          
             

             if($data->organization_requirements)
             {
                $data->organization_requirements->each( function($org) {
                    if($org->file)
                    {
                        $org->file->each(function($file) {
                            if($file)
                            {
                                $this->deleteImageOss($file->url);

                                $file->delete();
                            }
                        });
                    }

                    $org->delete();
                });
             }
              
             if($data->requirements)
             {
                 //  $data->requirements()->detach();
             }

         }

         OrganizationProcess::whereIn('id', $request->input('ids'))->delete();
        Organization::whereIn('id', $request->input('ids'))->delete();
        
        return redirect()->back()->with('notification', 'Campus Delete'); 
    }
}
