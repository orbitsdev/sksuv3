<?php

namespace App\Models;

use App\Models\Campus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function campus(){
        return $this->belongsTo(Campus::class);
    }
}
