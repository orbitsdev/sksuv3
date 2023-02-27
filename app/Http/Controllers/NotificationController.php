<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    

    public function index(){
       

        
        return response()->json([
            'data' =>  Notification::where('reciever_id', Auth::user()->id)->latest()->take(5)->with('user_sender')->get(),
        ]);


    }


}
