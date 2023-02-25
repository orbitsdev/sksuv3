<?php

namespace App\Models;

use App\Models\User;
use App\Models\Organization;
use App\Models\CampusAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationProcess extends Model
{
    use HasFactory;

    protected $guarded = [];


    public  function organization(){
        return $this->belongsTo(Organization::class);
    }

    public  function campus_adviser(){
        return $this->belongsTo(CampusAdviser::class);
    }

    
    public  function campus_director(){
        return $this->belongsTo(CampusDirector::class);
    }

    public  function osas(){
        return $this->belongsTo(User::class, 'osas_id');
    }
    public  function vpa(){
        return $this->belongsTo(User::class, 'vpa_id');
    }









}
