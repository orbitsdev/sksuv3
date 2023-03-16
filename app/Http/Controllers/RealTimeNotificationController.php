<?php

namespace App\Http\Controllers;

use App\Events\RealTimeNotification;
use Illuminate\Http\Request;

class RealTimeNotificationController extends Controller
{


    public function testNotification(){
        event(new RealTimeNotification('Hello World'));
    }
}
