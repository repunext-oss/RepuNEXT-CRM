<?php

namespace App\Http\Controllers;

use App\Models\HostDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostDetailsController extends Controller
{
    public function index()
    {   
        $repn   =  HostDetail::where('h_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('host_details.list',compact('repn'));              
    }

    public function create()
    {
        return view('host_details.add');   
    }

    public function store(Request $request){
        $request->validate([
            'host_name' => 'required',
        ]);
        $check_isexist  =   HostDetail::where('host_name', $request->host_name)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'host name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.hdetail')->with($notification); 
        } 
 
         $repn           =   new HostDetail;
         $repn->host_name  =   $request->host_name; 
         $repn->host_username  =   $request->host_username; 
         $repn->host_password  =   $request->host_password; 
       
        $repn->save();
        $notification   =   array(  'message' => 'Project Service Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.hdetail')->with($notification);  
    }

    public function show($id)
    {
        $repn   = HostDetail::find($id);
        return view('host_details.show',compact('repn'));
    }

    public function edit($id)
    {
        $repn   = HostDetail::find($id);
        return view('host_details.edit',compact('repn'));   
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $repn = HostDetail::find($request->id);
    
        $repn->host_name = $request->host_name;
        $repn->host_username = $request->host_username;
        $repn->host_password = $request->host_password;
        $repn->save();
        if($repn){
            $notification = array(  'message' => 'HostDetails Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.hdetail')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.hdetail')->with($notification);
        }
    }
    
    
      
    public function destroy($id)
    {
        $repn                   =   HostDetail::find($id);
        $repn->h_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.hdetail')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   HostDetail::find($request->id);  
        $repn->h_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.hdetail')->with('success','state has been status successfully');
    }
   
 
}