<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends =['file_url'];


    

    public function getFileUrlAttribute(){
        if($this->url != '' || $this->url != null) {
          $oss = config('filesystems.disks.oss');
          $protocol = request()->secure() ? 'https://' : 'http://';
          return  $protocol.$oss['bucket'].'.'. $oss['endpoint'].'/'.$this->url;
        }
    }


    public function fileable()
    {
        return $this->morphTo();
    }
    

}
