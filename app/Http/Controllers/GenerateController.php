<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GenerateController extends Controller
{

        public function index(){
            return Inertia::render('osas/generatecertificateindex');
        }
    
}
