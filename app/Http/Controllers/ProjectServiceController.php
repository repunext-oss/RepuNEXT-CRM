<?php

namespace App\Http\Controllers;

use App\Models\ProjectService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectServiceController extends Controller
{
    public function index()
    {   
        $repn   =   ProjectService::where('ps_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('project_service.list',compact('repn'));              
    }
    public function create()
    {
        return view('project_service.add');   
    }
    public function store(Request $request){

        $request->validate([
            'ps_name' => 'required',
        ]);
        $check_isexist  =   ProjectService::where('ps_name', $request->ps_name)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'Project Service name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.pservice')->with($notification); 
        } 
        $repn           =   new ProjectService; 
        $repn->ps_name  =   $request->ps_name; 
        $repn->ps_price  =   $request->ps_price; 
        $repn->save();
        $notification   =   array(  'message' => 'Project Service Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.pservice')->with($notification);  
    }
    public function show($id)
    {
        $repn   = ProjectService::find($id);
        return view('project_service.show',compact('repn'));
    }
    public function edit($id)
    
        {
            $repn   = ProjectService::find($id);
        return view('project_service.edit',compact('repn'));   
    }
    
    public function update(Request $request)
    {
        $repn           =   ProjectService::find($request->id);
        $repn->ps_name  =   $request['ps_name']; 
        $repn->ps_price  =   $request['ps_price']; 
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'Project Service Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.pservice')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.pservice')->with($notification);
        }
    }
      
    
    public function destroy($id)
    {
        $repn                   =   ProjectService::find($id);
        $repn->ps_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.pservice')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   ProjectService::find($request->id);  
        $repn->ps_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.pservice')->with('success','state has been status successfully');
    }
}
