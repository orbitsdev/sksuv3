<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\File;
use Inertia\Inertia;
use App\Models\Requirement;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use App\Http\Resources\UploadResource;
use App\Models\OrganizationRequirement;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Request as supportrequest;

class FileController extends Controller
{


  public function index(){

    return Inertia::render('student/templateindex',[
   
      'requirements' => Requirement::query()
      ->when(supportrequest::input('search'), function($query, $search){
          $query->where('name', 'like', "%{$search}%");
      })
      ->latest()->with(['files'])
      ->paginate(10)
      ->withQueryString(),
      'filters'=> supportrequest::only('search'),
    ]);
  }

  public function deleteTemplate(Request $request){

    if($request->file_id)
    {
        $file = File::find($request->file_id);

        if($file)
        {
          $status = $this->deleteImageOss($file->url);
        }
        $file->delete();
        // $this->deleteFile();
     
    }
    return redirect()->back();
}


  public function uploadTemplate(Request $request){


 
    
    if ($request->has('file')) {

          // dd($request->model_id);   

        $requirement = Requirement::find($request->model_id);
        
        $file_data =     $this->uploadFileOss('template/', $request->file);
        $requirement->files()->create($file_data);
        


      
     
      
      
      // $organzation_requiremnets =  OrganizationRequirement::find($request->model_id);
      
      
      //  $organzation_requiremnets->file()->create($file_data);
 
     

      }

  }

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
