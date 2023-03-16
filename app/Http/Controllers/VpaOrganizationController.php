<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;

class VpaOrganizationController extends Controller
{


    
    public function index(){

        return Inertia::render('vpa/organizationindex',[
            'organizations' => Organization::query()
            ->when(supportrequest::input('search'), function($query, $search){
             
                $query->where(function($query) use ($search){
                    $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('campus_adviser.school_year', function($query) use ($search) {
                        $query->where('from', 'like', "%{$search}%")
                              ->orWhere('to', 'like', "%{$search}%");
                    });
                });
            })->whereHas('organization_process', function($query){

                $query->where('campus_adviser_approved_status', 'approved')->where('campus_director_approved_status', 'approved')->where('osas_approved_status', 'approved');

            })->latest()->
            with(['campus_adviser.user', 'campus_adviser.campus', 'campus_adviser.school_year', 'requirements.organization_requirements','organization_requirements' => function($org) {
                $org->with(['requirement', 'file']);
            },'organization_process'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }
}
