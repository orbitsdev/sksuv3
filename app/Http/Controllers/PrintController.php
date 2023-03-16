<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Campus;


use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as supportrequest;

class PrintController extends Controller
{


    public function lisoforganizationpercampus(){


        // $org = Organization::groupBy('id')->get();E
        // $org  = Campus::whereHas('campus_advisers.school_year')->with(['campus_advisers.organizations', 'campus_advisers.school_year'])->get();

        // dd($org);

        return Inertia::render('osas/printorganizationpercampus',[

            'campus' =>Campus::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            // ->when(supportrequest::input('school_year'), function($query , $school_year){
            //     $query->whereHas('campus_advisers.school_year', function($query) use($school_year){
            //         $query->where('id', $school_year);
            //     });
            // })
            ->latest()->whereHas('campus_advisers.school_year')->with(['campus_advisers.organizations', 'campus_advisers.school_year'])->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
            'filter_by_school_year'=> supportrequest::only('school_year'),


        ]);
    }

    public function listofsubmitteddocuments(){
        return Inertia::render('osas/printsubmiiteddocuments',[


            'campus' =>Campus::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            // ->
            // when(supportrequest::input('school_year'), function($query , $school_year){
            //     $query->whereHas('campus_advisers.school_year', function($query) use($school_year){
            //         $query->where('id', $school_year);
            //     });
            // })
            ->latest()->whereHas('campus_advisers.school_year')->with(['campus_advisers.organizations', 'campus_advisers.organizations.organization_requirements.file', 'campus_advisers.school_year'])->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
            'filter_by_school_year'=> supportrequest::only('school_year'),

        ]);
    }

    
}
