<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;

class OrganizationController extends Controller
{



    public function index(){

        return Inertia::render('osas/organizationindex', [
            'organizations' => Organization::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })->with(['campus'])
            ->latest()
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }


    

    public function create(Request $request){
        $validated = $request->validate([
            'name' => ['required']
        ]);

         Organization::create([
            'campus_id'=>$request->input('campus_id'), 
            'name'=> $request->input('name'),
        ]);

        return redirect()->back()->with('notification', 'Campus Created');
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
         Organization::whereIn('id', $request->input('ids'))->delete();
        
        return redirect()->back()->with('notification', 'Campus Delete'); 
    }
}
