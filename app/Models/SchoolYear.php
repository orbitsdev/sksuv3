<?php

namespace App\Models;


use App\Models\CampusAdviser;
use App\Models\CampusDirector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolYear extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function campus_advisers (){


        return $this->hasMany(CampusAdviser::class);

    } 
    public function campus_directors (){


        return $this->hasMany(CampusDirector::class);

    } 

    
}
