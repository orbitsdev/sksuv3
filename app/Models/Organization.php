<?php

namespace App\Models;

use App\Models\Campus;
use App\Models\Requirement;
use App\Models\OrganizationProcess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];




    
    public function requirements(){
        return $this->belongsToMany(Requirement::class, 'organization_requirements', 'organization_id', 'requirement_id');
    }

    public function organization_process(){
        return $this->hasOne(OrganizationProcess::class);
    }

    
}
