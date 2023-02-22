<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;

class AccountController extends Controller
{


    public function index(){

        return Inertia::render('osas/accounts');

    }
}
