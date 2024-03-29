<?php

namespace App\Models;

use App\Models\User;
use App\Models\Campus;
use App\Models\SchoolYear;
use App\Models\OrganizationProcess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampusDirector extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization_processes()
    {
        return $this->belongsTo(OrganizationProcess::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function latest_campus_director()
    {
        return $this->campus->latest_campus_director();
    }
}
