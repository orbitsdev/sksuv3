<?php

namespace App\Models;

use App\Models\SchoolYear;
use App\Models\Organization;
use App\Models\CampusAdviser;
use App\Models\CampusDirector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;

    protected $guarded = [];

    

    public function campus_advisers(){
        return $this->hasMany(CampusAdviser::class);
    }

    public function campus_adviser(){
        return $this->hasOne(CampusAdviser::class);
    }

    public function campus_director(){
        return $this->hasOne(CampusDirector::class);
    }



   
}
