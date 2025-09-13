<?php

namespace App\Http\Controllers;

use App\Models\TaskTime;
use App\Models\GoalTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskTimeController extends Controller
{
    public function index()
    {   
        $serv   = GoalTask::all();
        $repn   =   TaskTime::where('time_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('time.list',compact('repn','serv'));              
    }
    public function create()
    {
        $repu   =   GoalTask::all();
        return view('time.add',compact('repu')); 
    }
   
    public function store(Request $request)
    {
        
        $request->validate([
           
            'goalid_ref' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
        ]);
       
        $repn = new TaskTime;
        $repn->goalid_ref = implode(',', $request->goalid_ref);
        $repn->starttime= $request->starttime;
        $repn->endtime= $request->endtime;
      
        $repn->save();
    
        $notification = array(
            'message' => 'TaskTime Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('list.time')->with($notification);
    }
    
    public function show($id)
    {
        $serv   =   GoalTask::all();
        $repn   = TaskTime::find($id);
        return view('time.show',compact('serv','repn'));
    }
    public function edit($id)
    {
        $serv   =   GoalTask::all();
        $repn   = TaskTime::find($id);
        return view('time.edit',compact('serv','repn'));   
    }
    public function update(Request $request)
    {
        $repn           =   TaskTime::find($request->id);
        $repn->goalid_ref = implode(',', $request->goalid_ref);
        $repn->starttime= $request['starttime'];
        $repn->endtime= $request['endtime'];
      
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'time Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.time')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.time')->with($notification);
        }
    }
    public function destroy($id)
    {
        $repn                   =   TaskTime::find($id);
        $repn->time_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.time')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   TaskTime::find($request->id);  
        $repn->time_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.time')->with('success','state has been status successfully');
    }
}

