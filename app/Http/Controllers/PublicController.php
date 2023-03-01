<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campus;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\CampusAdviser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request as supportrequest;

class PublicController extends Controller
{


    public function getSchoolYear()
    {

        return response()->json(['data' => SchoolYear::latest()->get()]);
    }
    public function getCampus()
    {

        return response()->json(['data' => Campus::latest()->get()]);
    }


    public function getGuestUsers()
    {


        return response()->json([
            'data' => User::latest()->whereHas('roles', function ($query) {
                    $query->where('name', 'guest');
                })->get(),
            'filters' => supportrequest::only(['search'])

        ]);
    }

    public function getCampusAdviser(){
        

        return response()->json([
            'data' => CampusAdviser::latest()->with('user','school_year')->get(),
        ]);
    }

}
