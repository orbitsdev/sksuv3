<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationRequirement extends Model
{
    use HasFactory;

    protected $guarded = [];
    


    public function file()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }


    
}
