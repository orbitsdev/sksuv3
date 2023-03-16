<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Certificate;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApplicationStatusNotification;


class CertificateController extends Controller
{


    public function updateOsasDistribution(Request $request){
            
            $certificate = Certificate::where('organization_id', $request->id)->first();
            $organization  =Organization::find($request->id);
            $campus_adviser = $organization->campus_adviser->user;
            $current_user = Auth::user();

      

            if($certificate->distributed_by_osas){
                $certificate->distributed_by_osas = 0;

            }else{
                $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'', 'Osas issued certifcate for ' .strtoupper($organization->name).' Organization'));
                $certificate->distributed_by_osas = 1;
            }


            

            $certificate->save();
    
            return redirect()->back()->with('success', 'Certificate has been updated!');
    
    }
    public function updateAdviserDistribution(Request $request){
            
            $certificate = Certificate::where('organization_id', $request->id)->first();
            $organization  =Organization::find($request->id);
            $student = $organization->user;
            $current_user = Auth::user();
            
          

            if($certificate->distributed_by_adviser){
                $certificate->distributed_by_adviser = 0;

            }else{
                $certificate->distributed_by_adviser = 1;
                $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'', ' Adviser forwarded the certficate for ' .strtoupper($organization->name).' Organization'));

            }

            $certificate->save();
    
            return redirect()->back()->with('success', 'Certificate has been updated!');
    
    }

        public function create(Request $request){



            
            $organization = Organization::find($request->id);

            $held_location =$request->held_location  ;
            $usg_adviser =strtoupper( $request->usg_adviser);
            $director_student_affaire_service = strtoupper($request->director_affair) ;
            $date_year =         Carbon::parse($request->month_year)->format('F, Y');
            $school_year = $organization->campus_adviser->school_year->from . ' - ' . $organization->campus_adviser->school_year->to;

         


            if($organization->certificate != null){

                $certficate_data  = [
                  
                    'organization_name'=> $organization->name,
                    'held_location'=> $held_location,
                    'usg_adviser'=>$usg_adviser,
                    'director_student_affaire_service'=> $director_student_affaire_service,
                    'date_year'=>$date_year,
                    'school_year'=>$school_year,
                    ];
                $organization->certificate->update($certficate_data);
            }else{

                $certficate_data  = [
                    'organization_id'=> $organization->id,
                    'organization_name'=> $organization->name,
                    'held_location'=> $held_location,
                    'usg_adviser'=>$usg_adviser,
                    'director_student_affaire_service'=> $director_student_affaire_service,
                    'date_year'=>$date_year,
                    'school_year'=>$school_year,
                    'distributed_by_osas' => false,
                    'distributed_by_adviser' => false,
                    ];
        
                $new_certificate = Certificate::create($certficate_data);
            }


          

          



           

            return redirect()->back()->with('success', 'Certificate has been generated!');


            

    

        }


}
