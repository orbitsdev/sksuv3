<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\File;
use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use App\Http\Resources\UploadResource;
use App\Models\Organization;
use App\Models\OrganizationRequirement;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{



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

    public function uploadFileOss($path,  $file){

    
        $storage = Storage::disk("oss");

        $filename = strtotime(now()) . '.'. $file->getClientOriginalExtension();        
        $full_path = $path . $filename;
        $extension = $file->getClientOriginalExtension();
        // dd($extension);
        try{
       
        $storage->put($full_path, file_get_contents($file));
        return [
            'owned_by'=>$path,
            'folder'=>$path ,
            'file_name'=> $file->getClientOriginalName(),
            'file_type'=>$file->getClientOriginalExtension(),
            'url'=>$full_path,

        ];

        }catch(Exception $e){
                dd($e);
        }
       


    }



    public function uploadToTemporaryStorage(Request $request)
    
    {
        
          // dd($request->all());
        

        
        if ($request->has('file')) {

         

        $file_data =     $this->uploadFileOss('requrements/', $request->file);
        
        $organzation_requiremnets =  OrganizationRequirement::find($request->model_id);
        
        
         $organzation_requiremnets->file()->create($file_data);
   
       

        }


    }


    public function deleteFromLocalStorage(Request $request)
    {

        $file =  TemporaryStorage::where('folder', $request->input('folder'))->first();
 
        if (Storage::disk('public_uploads')->deleteDirectory('tmp/' . $file->folder)) {
            TemporaryStorage::where('folder', $file->folder)->delete();
            return new FilePondResource(['folder' => $file->folder, 'file_name' => $file->file_name, 'file_type'=> $file->file_type]);
         } else {
            return response()->json(['failed']);
         }
    }
}
