<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CampusAdviserOrganizationController extends Controller
{


    public function index(){
        return Inertia::render('sboadviser/organizationindex');
    }
}
