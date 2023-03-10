<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Requirement;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Request as supportrequest;


class RequirementController extends Controller
{


    public function index(){

        return Inertia::render('osas/requirementsindex', [
            'requirements' => Requirement::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()->with(['files'])
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => ['required']
        ]);

        $campus = Requirement::create([
          
            'name'=> $request->input('name'),
        ]);

        return redirect()->back()->with('success', ' Created');
    }
    public function update(Request $request){
        $validated = $request->validate([
            'name' => ['required']
        ]);

        $campus = Requirement::where('id', $request->input('id'))->first();
        
        
        $campus->update([
            'name'=> $request->input('name')
        ]);
        
        return redirect()->back()->with('success', ' Updated'); 
    }


    public function deleteSelected(Request $request){
        
        // $campus = Campus::wheeIn('id', $request->input('ids'))->get();
         Requirement::whereIn('id', $request->input('ids'))->delete();
        
        return redirect()->back()->with('success', ' Delete'); 
    }
}
