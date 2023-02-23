<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;

class CampusController extends Controller
{
    

    public function index(){

        return Inertia::render('osas/campusindex', [
            'campuses' => Campus::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
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

        $campus = Campus::create([
          
            'name'=> $request->input('name'),
        ]);

        return redirect()->back()->with('notification', 'Campus Created');
    }
    public function update(Request $request){
        $validated = $request->validate([
            'name' => ['required']
        ]);

        $campus = Campus::where('id', $request->input('id'))->first();
        
        
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
