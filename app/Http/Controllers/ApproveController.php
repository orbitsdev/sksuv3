<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Notification;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\OrganizationProcess;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApplicationStatusNotification;

class ApproveController extends Controller
{
    

    public function endorse(Request $request){  
        


        $organization = Organization::where('id', $request->id)->first();
        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();

        $student = $organization->user;
        $current_user = Auth::user();
        $campus_adviser = $organization->campus_adviser->user;
        


        if($request->approver_type == 'campus_adviser'){

            $organization_process->update([
                'campus_adviser_id'=> Auth::user()->id, 
                // 'campus_adviser_approved_status'=> 'approved', 
                'campus_adviser_endorsed_status'=> 'true', 
            ]);


            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name, '', strtoupper($organization->name) .' Application has been endorsed to campus director ' ));

            // $newnotfi = Notification::create([
            //     'sender_id'=> Auth::user()->id, 
            //     'reciever_id'=> $organization->user_id, 
            //     'approved_status'=> 'approved', 
            //     'status'=> 'unread', 
            //     'body'=> 'Application has been approved', 
            // ]);
            
        }

        if($request->approver_type == 'osas'){
            


            $organization_process->update([
                'osas_id'=> Auth::user()->id, 
                // 'osas_approved_status'=> 'approved', 
                'osas_endorsed_status'=> 'true', 
            ]);


            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'', strtoupper($organization->name) .' Application has been endorsed to VPA' ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'', strtoupper($organization->name) .' Application has been endorsed to VPA' ));
            
         
            
            // $newnotfi = Notification::create([
            //     'sender_id'=> Auth::user()->id, 
            //     'reciever_id'=> $organization->user_id, 
            //     'approved_status'=> 'approved', 
            //     'status'=> 'unread', 
            //     'body'=> 'Application has been approved', 
            // ]);
           
            
            // $newnotfi = Notification::create([
            //     'sender_id'=> Auth::user()->id, 
            //     'reciever_id'=> $organization->campus_adviser->user->id, 
            //     'approved_status'=> 'approved', 
            //     'status'=> 'unread', 
            //     'body'=> 'Application has been approved', 
            // ]);
           
            
        }
        if($request->approver_type == 'vpa'){



            $organization_process->update([
                'vpa_id'=> Auth::user()->id, 
                'vpa_approved_status'=> 'approved', 
                'vpa_endorsed_status'=> 'true', 
            ]);


          


            
            
            // $newnotfi = Notification::create([
            //     'sender_id'=> Auth::user()->id, 
            //     'reciever_id'=> $organization->user_id, 
            //     'approved_status'=> 'approved', 
            //     'status'=> 'unread', 
            //     'body'=> 'Application has been approved', 
            // ]);
           
            
            // $newnotfi = Notification::create([
            //     'sender_id'=> Auth::user()->id, 
            //     'reciever_id'=> $organization->campus_adviser->user->id, 
            //     'approved_status'=> 'approved', 
            //     'status'=> 'unread', 
            //     'body'=> 'Application has been approved', 
            // ]);
           
            
        }
          

       
        
        
    return redirect()->back();        

    }
    public function approve(Request $request){  



        $organization = Organization::where('id', $request->id)->first();
        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();
        
        $student = $organization->user;
        $current_user = Auth::user();
        $campus_adviser = $organization->campus_adviser->user;
        

        // dd($campus_adviser);

        if($request->approver_type == 'campus_adviser'){

            $organization_process->update([
                'campus_adviser_id'=> Auth::user()->id, 
                'campus_adviser_approved_status'=> 'approved', 
                // 'campus_adviser_endorsed_status'=> 'true', 
            ]);
            
            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' Application has been approved ' ));

            // $sender, $organization_name, $status, $body

          
            
        }

        if($request->approver_type == 'campus_director'){



            $organization_process->update([
                'campus_director_id'=> Auth::user()->id, 
                'campus_director_approved_status'=> 'approved', 
                'campus_director_endorsed_status'=> 'true', 
            ]);

            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' application that you endorsse to campus director has been approved ' ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' application. that endorsed by campus adviser to campus director has been approved ' ));
            
         
            
        }
        if($request->approver_type == 'osas'){



            $organization_process->update([
                'osas_id'=> Auth::user()->id, 
                'osas_approved_status'=> 'approved', 
                // 'osas_endorsed_status'=> 'true', 
            ]);

            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' application has been approved by osas ' ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' application  has been approved by osas ' ));

        
           
            
        }
        if($request->approver_type == 'vpa'){



            $organization_process->update([
                'vpa_id'=> Auth::user()->id, 
                'vpa_approved_status'=> 'approved', 
                'vpa_endorsed_status'=> 'true', 
            ]);


            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' Application has been approved  by VPA' ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' Application has been approved by VPA ' ));

            
           
           
            
        }
          

       
        
        
    return redirect()->back();        

    }



    


    public function deny(Request $request){


        

        
        $organization = Organization::where('id', $request->id)->first();
        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();

        $student = $organization->user;
        $current_user = Auth::user();
        $campus_adviser = $organization->campus_adviser->user;
        
        
        
        if($request->approver_type == 'campus_adviser'){
            
            $organization_process->update([
                'campus_adviser_id'=> Auth::user()->id, 
                'campus_adviser_approved_status'=> 'denied', 
                'campus_adviser_endorsed_status'=> 'false', 
            ]);


            $create_remark = Remark::create([
                'organization_id'=> $organization->id,        
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'body'=> $request->comment, 
            ]);
    
       

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'denied', strtoupper($organization->name) .' Application has been denied. '.$request->comment ));

            
    
        }

        if($request->approver_type == 'campus_director'){
            
            $organization_process->update([
                'campus_director_id'=> Auth::user()->id, 
                'campus_director_approved_status'=> 'denied', 
                'campus_director_endorsed_status'=> 'false', 
            ]);


            $create_remark = Remark::create([
                'organization_id'=> $organization->id,        
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'body'=> $request->comment, 
            ]);
    
           
            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'denied', strtoupper($organization->name) .' application that you endorse to campus director has been - '.$request->comment  ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'denied', strtoupper($organization->name) .' application. that endorsed by campus adviser to campus director has been - '.$request->comment  ));
    

    
        }
        if($request->approver_type == 'osas'){
            
            $organization_process->update([
                'osas_id'=> Auth::user()->id, 
                'osas_approved_status'=> 'denied', 
                'osas_endorsed_status'=> 'false', 
            ]);


            $create_remark = Remark::create([
                'organization_id'=> $organization->id,        
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'body'=> $request->comment, 
            ]);


            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'denied', strtoupper($organization->name) .' application has been denied by osas. '.$request->comment ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'denied', strtoupper($organization->name) .' application  has been denied by osas. '.$request->comment ));

        
    
    
    
        }
        if($request->approver_type == 'vpa'){
            
            $organization_process->update([
                'vpa_id'=> Auth::user()->id, 
                'vpa_approved_status'=> 'denied', 
                'vpa_endorsed_status'=> 'false', 
            ]);

            
            $create_remark = Remark::create([
                'organization_id'=> $organization->id,        
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'body'=> $request->comment, 
            ]);


            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' Application has been denied   by VPA '.$request->comment  ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'approved', strtoupper($organization->name) .' Application has been denied  by VPA '.$request->comment  ));

        
    
        }
       
        
      
       



        
        
        
    return redirect()->back();        

    }


    public function comment(Request $request){



        $organization = Organization::where('id', $request->id)->first();

        $student = $organization->user;
        $current_user = Auth::user();
        $campus_adviser = $organization->campus_adviser->user;
        
        $create_remark = Remark::create([
            'organization_id'=> $organization->id,        
            'sender_id'=> Auth::user()->id, 
            'reciever_id'=> $organization->user_id, 
            'body'=> $request->comment, 
        ]);

        if(Auth::user()->hasRole('osas')){
           
          

            
            $campus_adviser->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'', 'Osas commented to '. strtoupper($organization->name). ' '. $request->comment  ));

            $student->notify(new ApplicationStatusNotification($current_user->first_name .' '. $current_user->last_name, $organization->name,'',  $request->comment  ));

        
        }

        return redirect()->back();


    }

    public function deletecomment(Request $request){
        Remark::where('organization_id', $request->id)->where('id', $request->remark_id)->delete();
        return redirect()->back();

    }
}
