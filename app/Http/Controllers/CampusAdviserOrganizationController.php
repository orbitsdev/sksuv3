<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Remark;
use App\Models\Notification;
use App\Models\Organization;
use Illuminate\Http\Request;

use App\Models\OrganizationProcess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as supportrequest;

class CampusAdviserOrganizationController extends Controller
{


    public function index(){

        return Inertia::render('sboadviser/organizationindex',[
            'organizations' => Organization::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })->whereHas('campus_adviser.user', function($query){
                $query->where('id', Auth::user()->id);
            })->whereHas('organization_process',function($query){
                $query->where('campus_adviser_endorsed_status', 'false');
            })->latest()->
            with(['campus_adviser.user', 'campus_adviser.campus', 'campus_adviser.school_year', 'requirements.organization_requirements','organization_requirements' => function($org) {
                $org->with(['requirement', 'file']);
            },'organization_process'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }

    public function endorsedindex(){

        return Inertia::render('sboadviser/endorsedindex',[
            'organizations' => Organization::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })->whereHas('campus_adviser.user', function($query){
                $query->where('id', Auth::user()->id);
            })->whereHas('organization_process',function($query){
                $query->where('campus_adviser_endorsed_status', 'true')->where('campus_adviser_approved_status', 'approved');
            })->latest()->
            with(['campus_adviser.user', 'campus_adviser.campus', 'campus_adviser.school_year', 'requirements.organization_requirements','organization_requirements' => function($org) {
                $org->with(['requirement', 'file']);
            },'organization_process'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }


    public function approve(Request $request){  




        $organization_process = OrganizationProcess::where('organization_id', $request->id)->update([
            'campus_adviser_id'=> Auth::user()->id, 
            'campus_adviser_approved_status'=> 'approved', 
            'campus_adviser_endorsed_status'=> 'true', 
        ]);

        // $notfication = Notification::create([
        //     'title'=> 'Approved', 
        //     'body'=> $request->comment, 
        //     'sender_id'=> $organization->campus_adviser()->user()->id, 
        //     'reciver_id'=> Auth::user()->id, 
        // ]);
        
        
    return redirect()->back();        

    }

    public function deny(Request $request){



        $organization = Organization::where('id', $request->id)->first();

        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();
        
        $organization_process->update([
            'campus_adviser_id'=> Auth::user()->id, 
            'campus_adviser_approved_status'=> 'denied', 
            'campus_adviser_endorsed_status'=> 'false', 
        ]);

    
        
        
        
        

        $create_remark = Remark::create([
            'organization_id'=> $organization->id,        
            'sender_id'=> Auth::user()->id, 
            'reciever_id'=> $organization->user_id, 
            'body'=> $request->comment, 
        ]);

        $newnotfi = Notification::create([
            'sender_id'=> Auth::user()->id, 
            'reciever_id'=> $organization->user_id, 
            'body'=> $request->comment, 
        ]);



        
        
        
    return redirect()->back();        

    }
}
