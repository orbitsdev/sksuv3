<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Organization;
use Illuminate\Http\Request;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request as supportrequest;



class GenerateController extends Controller
{


    public function index()
    {


        return Inertia::render('osas/certificateindex', [
            'organizations' => Organization::query()
                ->when(supportrequest::input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })->whereHas('organization_process', function ($query) {
                    $query->where('campus_adviser_approved_status', 'approved')
                        ->where('campus_adviser_endorsed_status', 'true')
                        ->where('campus_director_approved_status', 'approved')
                        ->where('osas_approved_status', 'approved')
                        ->where('osas_endorsed_status', 'true')
                        ->where('vpa_approved_status', 'approved');
                })->latest()->with(['remarks' => function ($query) {
                    $query->where('sender_id', Auth::user()->id);
                }, 'campus_adviser.user', 'campus_adviser.campus', 'campus_adviser.school_year', 'requirements.organization_requirements', 'organization_requirements' => function ($org) {
                    $org->with(['requirement', 'file']);
                }, 'organization_process'])
                ->paginate(10)
                ->withQueryString(),
            'filters' => supportrequest::only('search'),
        ]);
    }



    public function generateCertificate(Request $request)
    {


                $organization = Organization::find($request->id);



                $orgnaization_name = 'PHILIPPINES SOCIETY OFINFORMATION TEHNOLOGY STUDENTS (PSITS)';
                $usg_adviser = 'FLORLYNE MAE C. RENEGIO , MIT';
                $director_student_affaire_service = 'HASSANAL P. ABUSAMA, MIT';
                $date_year = Carbon::now()->format('F d, Y');
        
                $data = [$orgnaization_name, $usg_adviser, $director_student_affaire_service, $date_year];
        
              $paragraph =   explode(' ', $orgnaization_name);
                // dd($paragraph);



        $img = Image::make(public_path("assets/images/certificates/template.jpg"));

       

        $fontFamily =  public_path("assets/fonts/helvetica/Helvetica-Bold.ttf");
        
        $fullname = 'Nairah';
        
        $img->text($orgnaization_name, 520.99, 378, function ($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(18);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        $img->text($usg_adviser, 718.99, 571, function ($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(12);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });
        
        // $img->text($director_student_affaire_service, 0, 181, function ($font) use ($fontFamily) {
        //     $font->file($fontFamily);
        //     $font->size(18);
        //     $font->color('#000000');
        //     $font->align('center');
        //     $font->valign('top');
        // });
        // $img->text($date_year, 0, 81, function ($font) use ($fontFamily) {
        //     $font->file($fontFamily);
        //     $font->size(18);
        //     $font->color('#000000');
        //     $font->align('center');
        //     $font->valign('top');
        // });
        

        // return $img->response('jpg');
        $filename = $orgnaization_name."accreditation-certificate";
        $path = 'assets/images/certificates/';
        
        // if(!file_exists(public_path($path))) {
        //     mkdir(public_path($path), 0755, true);
        // }
        
        $img->save(public_path($path . $filename . '.jpg'));
        
        $file = public_path($path . $filename . '.jpg');
        if (file_exists($file)) {

            return response()->download($file);
        }

    }


    public function generateImageCertificateOfCompletion($user, $schedule, $exam, $footer = null)
    {
        // template image 
        $img = Image::make(public_path("images/certificates/template.jpg"));

        // specific font 
        $fontFamily =  public_path("assets/fonts/helvetica/Helvetica-Bold.ttf");

        
        
        $orgnaization_name = 'PHILIPPINES SOCIETY INFROMATION TECHNOLOGY STUDENTS (PSIT)';
        $usg_adviser = 'FLORLYNE MAE C. RENEGIO , MIT';
        $director_student_affaire_service = 'HASSANAL P. ABUSAMA, MIT';
        $date_year = Carbon::now()->format('F d, Y');


        $paragraph = explode('', $orgnaization_name);

        dd($paragraph);
        $data = [$orgnaization_name, $usg_adviser, $director_student_affaire_service, $date_year];

        dd($data);
        // $school_year = Carbon::now()->format('F d, Y');
    

        // ->text($string , (x-axis), (y-axis) )
        $img->text($orgnaization_name, 515, 381, function ($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(18);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // new filename 
        $filename = "certificate-of-completion.png";
        $path = 'certificates/completion/';

        try {
            $image = $img->encode('png', 90)->__toString();
            $filepath = $this->storeCertificateToOss($image, $path . $filename);
        } catch (Exception $e) {
            \Log::info(['Certificate of attendance failed to store in oss filename:', $filename]);
        }
        return $path . $filename;
    }

    public function storeCertificateToOss($certificate, $path)
    {
        if ($certificate) {

            $new_image = Image::make($certificate);
            $formatted_image = $new_image->encode('png', 90)->__toString();
            try {
                $this->uploadImage($path, $formatted_image);
                return $path;
            } catch (Exception $e) {
                \Log::info(["Failed to save in oss ", $e]);
                return false;
            }
        }
    }

    private function uploadImage($path, $image)
    {
        $storage = Storage::disk('oss');
        $storage->put($path, $image);
        return $path;
    }


    public function updateGeneratedImage()
    {
        // $img = Image::make( public_path("images/certificates/certificate-attendance.jpg") );

        $img = Image::make(public_path("images/certificates/template.jpg"));
        // if ($data['certificate'] == "completion") {
        //     $img = Image::make( public_path("images/certificates/certificate-completion.jpg") );
        // }
        // if($data['certificate'] == 'attendance')
        // {
        // }
        $fontFamily =  public_path("assets/fonts/helvetica/Helvetica-Bold.ttf") ;
        // Client full name

        // client name
        $fullname =  ' Anna Maires';
        $img->text($fullname, 515, 381, function($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(18);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        //client date
        $date = 'ScheDule';
        $img->text($date, 532, 427, function($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(14);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        $img->text('added test', 186, 272, function($font) use ($fontFamily) {
          $font->file($fontFamily);
          $font->size(18);
          $font->color('#000000');
          $font->align('center');
          $font->valign('top');
      });


        $paragraph = explode(' ', 'Seminar Name' );
        $line1 = null;
        $line2 = null;
        $line3 = null;

        // break seminar title into 3 lines
        if(count($paragraph) > 0)
        {
            foreach($paragraph as $key => $word)
            {
                if($key > 16)
                {
                    $line3 .= $paragraph[$key]. ' ';
                }else if($key > 8)
                {
                    $line2 .= $paragraph[$key] .' ';
                }else{
                    $line1 .= $paragraph[$key]. ' ';
                }
            }
        }

        $line1= $line1 ? trim($line1) : null;
        $line2= $line2 ? trim($line2) : null;
        $line3= $line3 ? trim($line3) : null;

        $line_1_position_y = 483;
        $line_2_position_y = 496;
        $speaker_position_y = 537;

         // seminar name
         if($line3)
         {
            $line_1_position_y  = 457;
            $line_2_position_y = 483;
            $img->text($line3, 514, 509, function($font) use ($fontFamily) {
                 $font->file($fontFamily);
                 $font->size(22);
                 $font->color('#000000');
                 $font->align('center');
                 $font->valign('top');
             });
         }

        if($line2)
        {
            if(!$line3)
            {
                $line_1_position_y = 470;
            }
            $img->text($line2, 514, $line_2_position_y, function($font) use ($fontFamily) {
                $font->file($fontFamily);
                $font->size(22);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });
        }



         $img->text($line1, 514, $line_1_position_y, function($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(22);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });


        // speakers
        $img->text($data['facilitator'] , 513, $speaker_position_y , function($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(16);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // student score
        $footer_text = $data['score'];
        $img->text($footer_text, 722, 574, function($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(15);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        // duration
        $duration = "Duration: Duatinds here";
        $img->text($duration, 721, 643, function($font) use ($fontFamily) {
            $font->file($fontFamily);
            $font->size(12);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        });

        if(!file_exists( public_path("images/certificates/update") ) )
        {
            $path = public_path("images/certificates/update");
            mkdir( $path, 0755);
        }


        $img->save( public_path("images/certificates/update/".$data['fileName'].".png") );
        $file = public_path("images/certificates/update/".$data['fileName'].".png");
        if (file_exists($file)) {
            return response()->download($file);
        }
    }
}
