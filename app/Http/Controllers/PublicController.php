<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicController extends Controller
{


        public function getSchoolYear(){

            return response()->json(['data'=> SchoolYear::all()]);
        }
}
