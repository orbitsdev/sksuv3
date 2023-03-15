<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    

    public function index(){
        

        auth()->user()->unreadNotifications->markAsRead();

        
        return response()->json([
            'data' => auth()->user()->notifications()->latest()->take(5)->get(),
        ]);


    }


}
