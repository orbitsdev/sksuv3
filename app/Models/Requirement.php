<?php

namespace App\Models;

use App\Models\File;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requirement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function organization_requirements(){
        return $this->belongsToMany(Organization::class, 'organization_requirements', 'requirement_id', 'organization_id');
    }


    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }



}
