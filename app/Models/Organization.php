<?php

namespace App\Models;

use App\Models\User;
use App\Models\Campus;
use App\Models\Remark;
use App\Models\Requirement;
use App\Models\CampusAdviser;
use App\Models\OrganizationProcess;
use App\Models\OrganizationRequirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];




    
    public function requirements(){
        return $this->belongsToMany(Requirement::class, 'organization_requirements', 'organization_id', 'requirement_id');
    }

    public function organization_requirements(){
        return $this->hasMany(OrganizationRequirement::class);
    }






    public function organization_process(){
        return $this->hasOne(OrganizationProcess::class);
    }

    public function campus_adviser(){
        return $this->belongsTo(CampusAdviser::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function remarks(){
        return $this->hasMany(Remark::class);
    }
}
