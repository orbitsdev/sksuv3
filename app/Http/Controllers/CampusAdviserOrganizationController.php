<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Remark;
use App\Models\Requirement;
use App\Models\Notification;
use App\Models\Organization;

use Illuminate\Http\Request;
use App\Models\OrganizationProcess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as supportrequest;

class CampusAdviserOrganizationController extends Controller
{


    public function createOrganization(Request $request)
    {





        $validated = $request->validate([
            'name' => ['required']
        ]);




        $new_record = Organization::create([
            'campus_adviser_id' => Auth::user()->campus_adviser->id,
            'user_id' => null,
            'name' => $request->input('name')
        ]);


        //get all requirments       

        $requirements = Requirement::pluck('id');




        if (count($requirements) > 0) {
            $new_record->requirements()->sync($requirements);
        }

        //create process


        $new_process = OrganizationProcess::create([
            'organization_id' => $new_record->id,

            'campus_adviser_id' =>  $request->input('campus_adviser_id'),
            'campus_adviser_approved_status' => 'waiting for review',
            'campus_adviser_endorsed_status' => 'false',

            'campus_director_id' => null,
            'campus_director_approved_status' => 'waiting for review',
            'campus_director_endorsed_status' =>  'false',

            'osas_id' => null,
            'osas_approved_status' => 'waiting for review',
            'osas_endorsed_status' =>  'false',

            'vpa_id' => null,
            'vpa_approved_status' => 'waiting for review',
            'vpa_endorsed_status' => 'false',
        ]);

        return redirect()->back()->with('notification', 'Created');
    }

    public function updateOrganization(Request $request)
    {

        $validated = $request->validate([
            'name' => ['required']
        ]);

        $campus = Organization::where('id', $request->input('id'))->first();


        $campus->update([
            'name' => $request->input('name')
        ]);

        return redirect()->back()->with('notification', 'Campus Updated');
    }


    public function functiondeleteSelectedOrganization(Request $request)
    {
        dd($request->all);


        $collection =   Organization::whereIn('id', $request->input('ids'))
            ->with(['organization_requirements' => function ($org) {
                $org->with(['file']);
            }])
            ->get();


        foreach ($collection as  $data) {



            if ($data->organization_requirements) {
                $data->organization_requirements->each(function ($org) {
                    if ($org->file) {
                        $org->file->each(function ($file) {
                            if ($file) {
                                $this->deleteImageOss($file->url);

                                $file->delete();
                            }
                        });
                    }

                    $org->delete();
                });
            }

            if ($data->requirements) {
                //  $data->requirements()->detach();
            }
        }

        OrganizationProcess::whereIn('id', $request->input('ids'))->delete();
        Organization::whereIn('id', $request->input('ids'))->delete();

        return redirect()->back()->with('notification', 'Campus Delete');
    }




    public function manageorganizationindex()
    {
        return Inertia::render('sboadviser/manageorganizationindex', [
            'organizations' => Organization::query()
                ->when(supportrequest::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })->where('campus_adviser_id', Auth::user()->campus_adviser->id)->latest()->paginate(10)
                ->withQueryString(),
            'filters' => supportrequest::only('search'),
        ]);
    }

    public function index()
    {

        return Inertia::render('sboadviser/organizationindex', [
            'organizations' => Organization::query()
                ->when(supportrequest::input('search'), function ($query, $search) {
                    
                     
                    $query->where(function($query) use ($search){
                        $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('campus_adviser.school_year', function($query) use ($search) {
                            $query->where('from', 'like', "%{$search}%")
                                  ->orWhere('to', 'like', "%{$search}%");
                        });
                        
                    })->whereHas('campus_adviser.user', function ($query) {
                        $query->where('id', Auth::user()->id);
                    });
                  
                })->whereHas('campus_adviser.user', function ($query) {
                    $query->where('id', Auth::user()->id);
                })->whereHas('organization_process', function ($query) {
                    $query->where('campus_adviser_endorsed_status', 'false');
                })->latest()->with(['campus_adviser.user', 'campus_adviser.campus', 'campus_adviser.school_year', 'requirements.organization_requirements', 'organization_requirements' => function ($org) {
                    $org->with(['requirement', 'file']);
                }, 'organization_process'])
                ->paginate(10)
                ->withQueryString(),
            'filters' => supportrequest::only('search'),
        ]);
    }

    public function endorsedindex()
    {

        return Inertia::render('sboadviser/endorsedindex', [
            'organizations' => Organization::query()
                ->when(supportrequest::input('search'), function ($query, $search) {
                    $query->where(function($query) use ($search){
                        $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('campus_adviser.school_year', function($query) use ($search) {
                            $query->where('from', 'like', "%{$search}%")
                                  ->orWhere('to', 'like', "%{$search}%");
                        });
                    })->whereHas('campus_adviser.user', function ($query) {
                        $query->where('id', Auth::user()->id);
                    });
                    
                })->whereHas('campus_adviser.user', function ($query) {
                    $query->where('id', Auth::user()->id);
                })->whereHas('organization_process', function ($query) {
                    $query->where('campus_adviser_endorsed_status', 'true')->where('campus_adviser_approved_status', 'approved');
                })->latest()->with(['certificate'=> function($query){
                    $query->where('distributed_by_osas', 1);
                },'campus_adviser.user', 'campus_adviser.campus', 'campus_adviser.school_year', 'requirements.organization_requirements', 'organization_requirements' => function ($org) {
                    $org->with(['requirement', 'file']);
                }, 'organization_process'])
                ->paginate(10)
                ->withQueryString(),
            'filters' => supportrequest::only('search'),
        ]);
    }


    public function approve(Request $request)
    {




        $organization_process = OrganizationProcess::where('organization_id', $request->id)->update([
            'campus_adviser_id' => Auth::user()->id,
            'campus_adviser_approved_status' => 'approved',
            'campus_adviser_endorsed_status' => 'true',
        ]);

        // $notfication = Notification::create([
        //     'title'=> 'Approved', 
        //     'body'=> $request->comment, 
        //     'sender_id'=> $organization->campus_adviser()->user()->id, 
        //     'reciver_id'=> Auth::user()->id, 
        // ]);


        return redirect()->back();
    }

    public function deny(Request $request)
    {



        $organization = Organization::where('id', $request->id)->first();

        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();

        $organization_process->update([
            'campus_adviser_id' => Auth::user()->id,
            'campus_adviser_approved_status' => 'denied',
            'campus_adviser_endorsed_status' => 'false',
        ]);







        $create_remark = Remark::create([
            'organization_id' => $organization->id,
            'sender_id' => Auth::user()->id,
            'reciever_id' => $organization->user_id,
            'body' => $request->comment,
        ]);

        $newnotfi = Notification::create([
            'sender_id' => Auth::user()->id,
            'reciever_id' => $organization->user_id,
            'body' => $request->comment,
        ]);






        return redirect()->back();
    }
}
