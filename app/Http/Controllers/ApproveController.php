<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Notification;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\OrganizationProcess;
use Illuminate\Support\Facades\Auth;

class ApproveController extends Controller
{
    

    public function endorse(Request $request){  
        


        $organization = Organization::where('id', $request->id)->first();
        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();


        if($request->approver_type == 'campus_adviser'){

            $organization_process->update([
                'campus_adviser_id'=> Auth::user()->id, 
                // 'campus_adviser_approved_status'=> 'approved', 
                'campus_adviser_endorsed_status'=> 'true', 
            ]);


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

            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->campus_adviser->user->id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
        }
          

       
        
        
    return redirect()->back();        

    }
    public function approve(Request $request){  



        $organization = Organization::where('id', $request->id)->first();
        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();


        if($request->approver_type == 'campus_adviser'){

            $organization_process->update([
                'campus_adviser_id'=> Auth::user()->id, 
                'campus_adviser_approved_status'=> 'approved', 
                // 'campus_adviser_endorsed_status'=> 'true', 
            ]);


            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
            
        }

        if($request->approver_type == 'campus_director'){



            $organization_process->update([
                'campus_director_id'=> Auth::user()->id, 
                'campus_director_approved_status'=> 'approved', 
                'campus_director_endorsed_status'=> 'true', 
            ]);

            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->campus_adviser->user->id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
        }
        if($request->approver_type == 'osas'){



            $organization_process->update([
                'osas_id'=> Auth::user()->id, 
                'osas_approved_status'=> 'approved', 
                // 'osas_endorsed_status'=> 'true', 
            ]);

            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->campus_adviser->user->id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
        }
        if($request->approver_type == 'vpa'){



            $organization_process->update([
                'vpa_id'=> Auth::user()->id, 
                'vpa_approved_status'=> 'approved', 
                'vpa_endorsed_status'=> 'true', 
            ]);

            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->campus_adviser->user->id, 
                'approved_status'=> 'approved', 
                'status'=> 'unread', 
                'body'=> 'Application has been approved', 
            ]);
           
            
        }
          

       
        
        
    return redirect()->back();        

    }



    


    public function deny(Request $request){


        

        
        $organization = Organization::where('id', $request->id)->first();
        $organization_process  = $organization->organization_process()->where('organization_id', $request->id)->first();
        
        
        
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
    
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user_id, 
                'approved_status'=> 'denied', 
                'status'=> 'unread', 
                'body'=> $request->comment, 
            ]);

            
    
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
    
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->campus_adviser->user->id, 
                'approved_status'=> 'denied', 
                'status'=> 'unread', 
                'body'=> $request->comment, 
            ]);
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user->id, 
                'approved_status'=> 'denied', 
                'status'=> 'unread', 
                'body'=> $request->comment, 
            ]);
    

    
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
    
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->campus_adviser->user->id, 
                'approved_status'=> 'denied', 
                'status'=> 'unread', 
                'body'=> $request->comment, 
            ]);

            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user->id, 
                'approved_status'=> 'denied', 
                'status'=> 'unread', 
                'body'=> $request->comment, 
            ]);
    
    
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
    
            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->campus_adviser->user->id, 
                'approved_status'=> 'denied', 
                'status'=> 'unread', 
                'body'=> $request->comment, 
            ]);

            $newnotfi = Notification::create([
                'sender_id'=> Auth::user()->id, 
                'reciever_id'=> $organization->user->id, 
                'approved_status'=> 'denied', 
                'status'=> 'unread', 
                'body'=> $request->comment, 
            ]);
    
    
        }
       
        
      
       



        
        
        
    return redirect()->back();        

    }


    public function comment(Request $request){



        $organization = Organization::where('id', $request->id)->first();
        
        $create_remark = Remark::create([
            'organization_id'=> $organization->id,        
            'sender_id'=> Auth::user()->id, 
            'reciever_id'=> $organization->user_id, 
            'body'=> $request->comment, 
        ]);

        return redirect()->back();


    }

    public function deletecomment(Request $request){
        Remark::where('organization_id', $request->id)->where('id', $request->remark_id)->delete();
        return redirect()->back();

    }
}
