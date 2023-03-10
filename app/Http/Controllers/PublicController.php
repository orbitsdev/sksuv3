<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campus;
use App\Models\SchoolYear;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\CampusAdviser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Request as supportrequest;

class PublicController extends Controller
{



    

  public function uploadTemplateTemporary(Request $request){


    if ($request->has('file')) {

        $file = $request->file('file');
        // dd($request->file);

        $directory = strtotime(now());    
        $filename = $file->getClientOriginalName();    
        // dd($filename);
        $full_path = 'template/' . $directory.'/'.$filename;
        $extension = $file->getClientOriginalExtension();
      
        Storage::disk('public')->put($full_path, file_get_contents($file));

        return redirect()->back();

      // $file_data =     $this->uploadFileOss('requrements/', $request->file);
      
      // $organzation_requiremnets =  OrganizationRequirement::find($request->model_id);
      
      
      //  $organzation_requiremnets->file()->create($file_data);
 
     

      }

  }

    public function generateCertificate(Request $request)
    {


        // return response()->json([$request->all()]);
        // $img = Image::make(public_path("assets/images/certificates/template2.png"));
        // $font_family =  public_path("assets/fonts/helvetica/Helvetica-Bold.ttf");
    
        // $filename = "accreditation-certificate";
        // $path = 'assets/images/certificates/';
    
        // $img->save(public_path($path . $filename . '.png'));
    
        // $file = public_path($path . $filename . '.png');
        // if (file_exists($file)) {
        //     $headers = [
        //         'Content-Type' => 'image/png',
        //     ];
        //     return response()->download($file, $filename, $headers);
        // }
        // dd($request->all());
        // $validated = $request->validate([
        //     'usg_adviser' => 'required',
        //     'director_affair' => 'required',
        //     'held_location' => 'required',
            
        // ]);

        
        // return response()->json([$organization->name]);
        $organization = Organization::find($request->id);



        $img = Image::make(public_path("assets/images/certificates/template2.png"));
        $font_family =  public_path("assets/fonts/helvetica/Helvetica-Bold.ttf");

        $orgnaization_name =  strtoupper($organization->name);
        $held_location =$request->held_location  ;
        // $orgnaization_name = 'ROBOTICS TECHXPLORERS (RTEX)';
        $usg_adviser =strtoupper( $request->usg_adviser);
        // $usg_adviser = 'Maria Clara Juan Delacruz, MIT';
        $director_student_affaire_service = strtoupper($request->director_affair) ;
        $date_year =         Carbon::parse($request->month_year)->format('F, Y');

        $school_year = $organization->campus_adviser->school_year->from . ' - ' . $organization->campus_adviser->school_year->to;

        $paragraph = explode(' ',  $orgnaization_name);

        $line1 = null;
        $line2 = null;
        $line3 = null;

        // break seminar title into 3 lines
        if (count($paragraph) > 0) {
            foreach ($paragraph as $key => $word) {
                if ($key > 5) {
                    $line3 .= $paragraph[$key] . ' ';
                } else if ($key > 2) {
                    $line2 .= $paragraph[$key] . ' ';
                } else {
                    $line1 .= $paragraph[$key] . ' ';
                }
            }
        }

        $line1 = $line1 ? trim($line1) : null;
        $line2 = $line2 ? trim($line2) : null;
        $line3 = $line3 ? trim($line3) : null;

        $line_1_position_y = 276;
        $line_2_position_y = 276;
        $line_3_position_y = 298;

        // seminar name
        if ($line3) {

            $line_1_position_y = 252;
            $line_2_position_y = 276;
            $line_3_position_y = 298;
            $img->text($line3, 284, $line_3_position_y, function ($font) use ($font_family) {
                $font->file($font_family);
                $font->size(22);
                $font->color('#144967');
                $font->align('center');
                $font->valign('top');
            });
        }

        if ($line2) {
            if (!$line3) {


                $line_1_position_y = 252;
                $line_2_position_y = 276;
            }
            $img->text($line2, 284, $line_2_position_y, function ($font) use ($font_family) {
                $font->file($font_family);
                $font->size(22);
                $font->color('#144967');
                $font->align('center');
                $font->valign('top');
            });
        }



        $img->text($line1, 286, $line_1_position_y, function ($font) use ($font_family) {
            $font->file($font_family);
            $font->size(22);
            $font->color('#144967');
            $font->align('center');
            $font->valign('top');
        });


        //usg adviser
        $img->text($usg_adviser, 185, 500, function ($font) use ($font_family) {
            $font->file($font_family);
            $font->size(14);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // diretor afai
        $img->text($director_student_affaire_service, 495, 500, function ($font) use ($font_family) {
            $font->file($font_family);
            $font->size(14);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // school_year        
        $img->text($date_year, 575, 376, function ($font) use ($font_family) {
            $font->file($font_family);
            $font->size(14);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });
        $img->text($school_year, 90, 465, function ($font) use ($font_family) {
            $font->file($font_family);
            $font->size(14);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });
        $img->text($held_location, 80, 396, function ($font) use ($font_family) {
            $font->file($font_family);
            $font->size(14);
            $font->color('#000000');
            $font->align('left');
            $font->valign('top');
        });




        $filename = "accreditation-certificate";
        $path = 'assets/images/certificates/';



        
        // Storage::disk('public')->put($path . $filename . '.png', $img->stream());

        // $url = route('osas.generatecerticate.certificate.generatefile', ['path' => $filename]);

        $img->save(public_path($path . $filename . '.png'));

        $file = public_path($path . $filename . '.png');


        if (file_exists($file)) {
            $headers = [
                'Content-Type' => 'image/png',
            ];
            return response()->download($file, $filename, $headers);
        }

        if (file_exists($file)) {
                $headers = [
                    'Content-Type' => 'image/png',
                ];
                return response()->download($file, $filename, $headers);
            }



        // if (file_exists($file)) {

        //     return response()->download($file);
        // }
    }


    public function getSchoolYear()
    {

        return response()->json(['data' => SchoolYear::latest()->get()]);
    }
    public function getCampus()
    {

        return response()->json(['data' => Campus::latest()->get()]);
    }


    public function getGuestUsers()
    {


        return response()->json([
            'data' => User::latest()->whereHas('roles', function ($query) {
                    $query->where('name', 'guest');
                })->get(),
            'filters' => supportrequest::only(['search'])

        ]);
    }

    public function getCampusAdviser(){
        

        return response()->json([
            'data' => CampusAdviser::latest()->with('user','school_year')->get(),
        ]);
    }

}
