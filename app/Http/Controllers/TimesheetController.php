<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index()
    {   
        $repn   =   Timesheet::where('tc_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('timesheetCategory.list',compact('repn'));              
    }
    public function create()
    {
        return view('timesheetCategory.add');  
    }
   
    public function store(Request $request)
    {
       
        $request->validate([
           
            'tc_name' => 'required',
            'tc_designation_category' =>'required',
        ]);
    
        $check_isexist = Timesheet::where('tc_name', $request->tc_name)->first();
        
        if ($check_isexist) {
            $notification = array(
                'message' => 'Project Detail already exists',
                'alert-type' => 'warning'
            );
            return redirect()->route('list.timecat')->with($notification);
        }
    
        $repn = new Timesheet;
        $repn->tc_name = $request->tc_name;
        $repn->	tc_designation_category  = $request->tc_designation_category;
      
        $repn->save();
    
        $notification = array(
            'message' => 'Timesheet Category Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('list.timecat')->with($notification);
    }
    
    public function show($id)
    {
        $repn   = Timesheet::find($id);
        return view('timesheetCategory.show',compact('repn'));
    }
    public function edit($id)
    {
        $repn   = Timesheet::find($id);
        return view('timesheetCategory.edit',compact('repn'));   
    }
    public function update(Request $request)
    {
        // dd($request->all());
        // exit();
        $repn   =   Timesheet::findOrFail($request->id);
        $repn->tc_name = $request->tc_name;
        $repn->	tc_designation_category  = $request->tc_designation_category;
        
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'timesheet Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.timecat')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.timecat')->with($notification);
        }
    }
    public function destroy($id)
    {
        $repn                   =   Timesheet::find($id);
        $repn->tc_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.timecat')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   Timesheet::find($request->id);  
        $repn->tc_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.timecat')->with('success','state has been status successfully');
    }
}
