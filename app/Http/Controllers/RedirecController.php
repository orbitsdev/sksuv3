<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirecController extends Controller
{
    static function redirecUserBaseOnRole(){
        if (Auth::user()->hasRole('osas')) {
            return redirect()->route('schoolyear.index');
        }
        if (Auth::user()->hasRole('sbo-adviser')) {
            return redirect()->route('officers.index');
        }
        if (Auth::user()->hasRole('sbo-student')) {
            return redirect()->route('application.index');
        }

        return Inertia::render('dashboard');
    }
}
