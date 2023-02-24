<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Inertia\Inertia;
use App\Models\Officer;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as supportrequest;

class OfficerController extends Controller
{
    

 
    
    public function index(){

        return Inertia::render('sboadviser/officerindex', [
            'campuses' => Campus::query()
            ->when(supportrequest::input('search'), function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })->whereHas('campus_advisers.user', function($query) {
                $query->where('id', Auth::user()->id);
            })
            ->latest()->with('campus_advisers')
            ->paginate(10)
            ->withQueryString(),
            'filters'=> supportrequest::only('search'),
        ]);
    }

}
