<?php

namespace App\Http\Controllers;

use App\Models\Followup;
use App\Models\SupportCallCenter;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    public function index()
    {   
        $support= SupportCallCenter::all();
        $repn   =   Followup::where('f_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('followup.list',compact('repn','support'));              
    }
    public function create()
    {
        $support= SupportCallCenter::all();
        return view('followup.add',compact('support'));   
    }
    public function store(Request $request){
        $request->validate([
            'Enquiry_ref_id' => 'required',
            'date' => 'required',
            'description' => 'required',
            'Status' => 'required',
        ]);

        // $check_isexist  =   Followup::where('Enquiry_ref_id', $request->Enquiry_ref_id)->first();  
        // if($check_isexist){
        //     $notification   =   array(  'message' => 'followup already exists',
        //                                 'alert-type' => 'warning'  );
        //     return redirect()->route('list.followup')->with($notification); 
        // } 
        $repn           =   new Followup; 
        $repn->Enquiry_ref_id  =   $request->Enquiry_ref_id; 
        $repn->date            =   $request->date; 
        $repn->description     =   $request->description; 
        $repn->Status          =   $request->Status; 

        $repn->save();

        $notification   =   array(  'message' => 'Project Service Stored Successfully',
                                    'alert-type' => 'success');
           
        return redirect()->route('list.followup')->with($notification);  
    }
    public function show($id)
    {
        $repn   = Followup::find($id);
        $support= SupportCallCenter::all();
        return view('followup.show',compact('repn','support'));
    }
    public function edit($id)
    {
            $repn   = Followup::find($id);
            $support= SupportCallCenter::all();
            return view('followup.edit',compact('repn','support')); 
    }
    
    public function update(Request $request)
    {
        $repn                 =   Followup::find($request->id);
        $repn->Enquiry_ref_id = $request['Enquiry_ref_id'];
        $repn->date           = $request['date']; 
        $repn->description    = $request['description']; 
        $repn->Status         = $request['Status'];

        $repn->save();   

        if($repn){
            $notification = array(  'message' => 'Followup Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.followup')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.followup')->with($notification);
        }
    }
      
    
    public function destroy($id)
    {
        $repn                   =   Followup::find($id);
        $repn->f_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.followup')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   Followup::find($request->id);  
        $repn->t_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.followup')->with('success','state has been status successfully');
    }
}
