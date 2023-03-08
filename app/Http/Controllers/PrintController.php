<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PrintController extends Controller
{
    

    public function lisoforganizationpercampus(){
        return Inertia::render('osas/printorganizationpercampus');
    }

    public function listofsubmitteddocuments(){
        return Inertia::render('osas/printsubmiiteddocuments');
    }

    
}
