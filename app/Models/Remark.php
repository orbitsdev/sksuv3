<?php

namespace App\Models;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Remark extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function user_sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function user_reciever(){
        return $this->belongsTo(User::class, 'reciever_id');
    }
}
