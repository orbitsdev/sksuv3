<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;


class SchoolYearController extends Controller
{
    
    public function index(Request $request){


         
        return Inertia::render('osas/schoolyear', [
            'years'=> SchoolYear::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('from', 'like', "%{$search}%")->orWhere('to', 'like', "%{$search}%");
                })->latest()->withCount('campus_advisers')
                ->paginate(10)
                ->withQueryString(),
            'filters'=>supportrequest::only(['search'])
         ]);

    }


    public function create(Request $request){
        $school_year = SchoolYear::create([
            'from' => $request->input('fromYear'),
            'to' => $request->input('toYear'),
        ]);

        return redirect()->back()->with('toast', 'School Year Created');;

    }

    public function deleteSelected(Request $request){

      
     $collection  = SchoolYear::whereIn('id', $request->input('ids'))->get();

     foreach($collection as $data){
        $data->campus_advisers()->delete();
     }

     SchoolYear::whereIn('id', $request->input('ids'))->delete();

     return redirect()->back()->with('toast', 'School Year Created');

    }
}
