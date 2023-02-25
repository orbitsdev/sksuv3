<?php

namespace App\Models;

use App\Models\User;
use App\Models\Campus;
use App\Models\CampusAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Officer extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user(){
        return $this->belongsTo(User::class);
        
    }

    public function campus_adviser(){
        return $this->belongsTo(CampusAdviser::class); 
    }


}
