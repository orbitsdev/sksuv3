<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user_sender(){
        return $this->belongsTo(User::class, 'sernder_id');
    }
    public function user_reciever(){
        return $this->belongsTo(User::class, 'reciever_id');
    }
}
