<?php

namespace App\Models;

use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampusAdiviser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function school_year(){
        return $this->belongsTo(SchoolYear::class);
    }
}
