<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campus;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request as supportrequest;

class PublicController extends Controller
{


    public function getSchoolYear()
    {

        return response()->json(['data' => SchoolYear::all()]);
    }
    public function getCampus()
    {

        return response()->json(['data' => Campus::all()]);
    }
    public function getGuestUsers()
    {


        return response()->json([
            'data' => User::whereHas('roles', function ($query) {
                    $query->where('name', 'guest');
                })->get(),
            'filters' => supportrequest::only(['search'])

        ]);
    }
}
