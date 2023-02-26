<?php

namespace App\Models;

use App\Models\User;
use App\Models\Campus;
use App\Models\Officer;
use App\Models\SchoolYear;
use App\Models\Organization;
use App\Models\OrganizationProcess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampusAdviser extends Model
{
    use HasFactory;


    protected $guarded = [];


    
    public function school_year(){
        return $this->belongsTo(SchoolYear::class);
    }


    public function campus(){
        return $this->belongsTo(Campus::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function officers(){
        return $this->hasMany(Officer::class);
    }


    public function organization_processes(){
        return $this->hasMany(OrganizationProcess::class);
    }

    public function  organizations(){
        return $this->hasMany(Organization::class);
    }

    






}
