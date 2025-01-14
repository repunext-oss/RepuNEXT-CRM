<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProjectService;


class ProjectDetailController extends Controller
{
    public function index()
    {   
        $user= User::all();
        $serv = ProjectService::all();
         $repn   =   ProjectDetail::where('project_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('project_details.list',compact('repn','user','serv'));              
    }

    public function create()

    {
        $repn = user::all();
        $repu = ProjectService::all();
        return view('project_details.add',compact('repn','repu'));  
    }

    public function store(Request $request){
        $request->validate([
            'project_title' => 'required',
            'project_description' => 'required',
            'project_start_date' => 'required',
            'project_end_date' => 'required',
            'project_service_category' => 'required',
            'project_timeline' => 'required',
            'assigned_to_member' => 'required',
            'project_priority' => 'required'
          
        ]);
        $check_isexist  =   ProjectDetail::where('project_title', $request->project_title)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'Project Detail name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.pdetail')->with($notification); 
        } 
        $repn           =   new ProjectDetail; 
        $repn->project_title  =   $request->project_title; 
        $repn->project_description  =   $request->project_description; 
        $repn->project_start_date  =   $request->project_start_date; 
        $repn->project_end_date  =  $request->project_end_date; 
        $repn->project_service_category  =   implode(',',$request->project_service_category); 
        $repn->project_timeline  =   $request->project_timeline; 
        $repn->assigned_to_member = implode(',', $request->assigned_to_member);
        $repn->project_priority  =   $request->project_priority; 

            
               
        // dd($request->all());
        $repn->save();

            
        $notification   =   array(  'message' => 'Project Detail Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.pdetail')->with($notification);  
    }

    public function show($id)
    {
        $repn   = ProjectDetail::find($id);
        $rep = user::all();
        $serv = ProjectService::all();
        return view('project_details.show',compact('repn','rep','serv'));
    }


    public function edit($id)
    {
        $repn   = ProjectDetail::find($id);
        $rep = user::all();
        $serv = ProjectService::all();
        return view('project_details.edit',compact('repn','rep','serv'));   
    }

    public function update(Request $request)
    {
        $repn           =   ProjectDetail::find($request->id);
        $repn->project_title  =   $request['project_title']; 
        $repn->project_description  =   $request['project_description']; 
        $repn->project_start_date  =   $request['project_start_date']; 
        $repn->project_end_date  =   $request['project_end_date']; 
        $repn->project_service_category  =  implode(',', $request->project_service_category); 
        $repn->project_timeline  =   $request['project_timeline']; 
        $repn->assigned_to_member = implode(',', $request->assigned_to_member);
        $repn->project_priority  =   $request['project_priority']; 
     
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'Project Details Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.pdetail')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.pdetail')->with($notification);
        }
    }

    public function destroy($id)
    {
        $repn                   =   ProjectDetail::find($id);
        $repn->project_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.pdetail')->with('success','state has been deleted successfully');
    }
    
    public function status(Request $request)
    { 
        $repn               =   ProjectDetail::find($request->id);  
        $repn->	project_status    =   $request->	project_status;
        $repn->save();     
        return redirect()->route('list.pdetail')->with('success','state has been status successfully');
    }
}