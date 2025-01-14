<?php

namespace App\Http\Controllers;

use App\Models\tools_type;
use App\Models\tools_credentials;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsCredentialsController extends Controller
{
   
    public function index()
    {
      
        $tooltype = tools_type::all();
        $repn   =  tools_credentials::where('tc_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('toolsCredential.list',compact('repn','tooltype'));
    }

    public function create()
    {
        $tooltype = tools_type::all();
        return view('toolsCredential.add',compact('tooltype'));    
    }

            public function store(Request $request)
            {
                $request->validate([
                    'tool_name' => 'required',
                    'tooltype_id' => 'required',
                    'link' => 'required',
                

                ]);
                $check_isexist  =   tools_credentials::where('tool_name', $request->tool_name)->first();  
                if($check_isexist){
                    $notification   =   array(  'message' => 'tool name already exists',
                                                'alert-type' => 'warning'  );
                    return redirect()->route('list.toolcred')->with($notification); 
                }
                $repn   =   new tools_credentials;

                $repn->tool_name  =   $request->tool_name; 
                $repn->tooltype_id  =   $request->tooltype_id; 
                $repn->link  =   $request->link; 
                $repn->user  =   $request->user; 
                $repn->password  =   $request->password; 
                
                $repn->save();
                $notification   =   array(  'message' => 'Tool Credentials Stored Successfully',
                                            'alert-type' => 'success'  );
                
                return redirect()->route('list.toolcred')->with($notification);
            }

    public function show($id)
    {
        $tooltype = tools_type::all();
        $repn   = tools_credentials::find($id);
        return view('toolsCredential.show',compact('repn','tooltype'));
    }

    public function edit($id)
    {
        $tooltype = tools_type::all();
        $repn   = tools_credentials::find($id);
        return view('toolsCredential.edit',compact('repn','tooltype')); 
    }

    public function update(Request $request)
    {
        $repn = tools_credentials::find($request->id);

        $repn->tool_name = $request['tool_name']; 
        $repn->tooltype_id = $request['tooltype_id']; 
        $repn->link = $request['link']; 
        $repn->user = $request['user']; 
        $repn->password = $request['password']; 
        $repn->save();
        
        
        if($repn){
            $notification = array(  'message' => 'Tools Credentials Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.toolcred')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.toolcred')->with($notification);
        }
    }
    public function destroy($id)
    {
        $repn                   =   tools_credentials::find($id);
        $repn->tc_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.toolcred')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   tools_credentials::find($request->id);  
        $repn->tc_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.toolcred')->with('success','state has been status successfully');
    }

}