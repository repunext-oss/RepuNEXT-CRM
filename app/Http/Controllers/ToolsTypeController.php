<?php

namespace App\Http\Controllers;

use App\Models\ToolsType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsTypeController extends Controller
{
    public function index()
    {   
        $repn   =   ToolsType::where('tl_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('tools_type.list',compact('repn'));              
    }
    public function create()
    {
        return view('tools_type.add');   
    }
    public function store(Request $request){
        $request->validate([
            'tooltype_name' => 'required',
        ]);
        $check_isexist  =   ToolsType::where('tooltype_name', $request->tooltype_name)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'type name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.tooltime')->with($notification); 
        } 
        $repn           =   new ToolsType; 
        $repn->tooltype_name  =   $request->tooltype_name; 
        $repn->save();
        
        $notification   =   array(  'message' => 'toolstype name Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.tooltime')->with($notification);  
    }
    public function show($id)
    {
        $repn   = ToolsType::find($id);
        return view('tools_type.show',compact('repn'));
    }
    public function edit($id)
    
        {
            $repn   = ToolsType::find($id);
        return view('tools_type.edit',compact('repn'));   
    }
    
    public function update(Request $request)
    {
        $repn           =   ToolsType::find($request->id);
        $repn->tooltype_name  =   $request['tooltype_name']; 
       
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'tools type Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.tooltime')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.tooltime')->with($notification);
        }
    }
      
    
    public function destroy($id)
    {
        $repn                   =   ToolsType::find($id);
        $repn->tl_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.tooltime')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   ToolsType::find($request->id);  
        $repn->tl_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.tooltime')->with('success','state has been status successfully');
    }
}
