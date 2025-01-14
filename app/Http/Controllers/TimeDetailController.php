<?php

namespace App\Http\Controllers;

use App\Models\TimeDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectDetail;

class TimeDetailController extends Controller
{
    public function index()
    {   
        $title= ProjectDetail::all();
        $repn   =   TimeDetail::where('task_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('time_details.list',compact('repn','title'));              
    }
    public function create()
    {
        $title= ProjectDetail::all();
        return view('time_details.add',compact('title'));   
    }
   
    public function store(Request $request)
    {
        
        $request->validate([
            'project_ref_id' => 'required',
            'task_name' => 'required',
            'task_date' => 'required',
            'task_assigned' => 'required',
            'task_start_time' => 'required',
            'task_end_time' => 'required',
            'task_description' => 'required',
            // 'task_status' => 'required'
        ]);
    
        $check_isexist = TimeDetail::where('task_name', $request->task_name)->first();
        
        if ($check_isexist) {
            $notification = array(
                'message' => 'Project Detail already exists',
                'alert-type' => 'warning'
            );
            return redirect()->route('list.ptime')->with($notification);
        }
    
        $repn = new TimeDetail;
        $repn->project_ref_id = $request->project_ref_id;
        $repn->task_name = $request->task_name;
        $repn->task_date = $request->task_date;
        $repn->task_assigned = $request->task_assigned;
        $repn->task_start_time = $request->task_start_time;
        $repn->task_end_time = $request->task_end_time;
        $repn->task_description = $request->task_description;
        // $repn->task_status = $request->task_status; 
    
        
        $repn->save();
    
        $notification = array(
            'message' => 'Project Detail Stored Successfully',
            'alert-type' => 'success'
        );
    
        // Redirect with notification
        return redirect()->route('list.ptime')->with($notification);
    }
    
    public function show($id)
    {
        $title= ProjectDetail::all();
        $repn   = TimeDetail::find($id);
        return view('time_details.show',compact('repn','title'));
    }
    public function edit($id)
    {
        $repn   = TimeDetail::find($id);
        $title= ProjectDetail::all();
        return view('time_details.edit',compact('repn','title'));   
    }
    public function update(Request $request)
    {
        $repn           =   TimeDetail::find($request->id);

        $repn->project_ref_id  =   $request['project_ref_id']; 
        $repn->task_name  =   $request['task_name']; 
        $repn->task_date  =   $request['task_date']; 
        $repn->task_assigned  =   $request['task_assigned']; 
        $repn->task_start_time  =   $request['task_start_time']; 
        $repn->task_end_time  =   $request['task_end_time']; 
        $repn->task_description =  $request['task_description'];
     
    
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'Project Service Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.ptime')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.ptime')->with($notification);
        }
    }
    public function destroy($id)
    {
        $repn                   =   TimeDetail::find($id);
        $repn->task_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.ptime')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   TimeDetail::find($request->id);  
        $repn->task_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.ptime')->with('success','state has been status successfully');
    }
}
