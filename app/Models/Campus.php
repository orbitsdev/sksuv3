<?php

namespace App\Models;

use App\Models\SchoolYear;
use App\Models\Organization;
use App\Models\CampusAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;

    protected $guarded = [];

    

    public function campus_advisers(){
        return $this->hasMany(CampusAdviser::class);
    }



   
}
