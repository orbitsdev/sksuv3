<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function deleteImageOss($path)
    {
      if($path)
      {
        $storage = Storage::disk('oss');
        if($storage->has($path) )
        {
          try {
            $storage->delete($path);
          }catch(Exception $e) {
            \Log::info(["Failed to delete file path = ", $path]);
          }
        }
      }
    }
}
