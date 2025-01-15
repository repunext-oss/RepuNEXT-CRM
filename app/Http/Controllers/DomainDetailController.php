<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\HostDetail;
use App\Models\DomainDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DomainDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type= Type::all();
        $host = HostDetail::all();
        $repn   =  DomainDetail::where('domain_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('domain_detail.list',compact('repn','type','host'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type= Type::all();
        $host = HostDetail::all();
        return view('domain_detail.add',compact('type','host'));   
    }


    public function store(Request $request)
    {
        // dd($request);
        // exit();
        $request->validate([
            'domain_name' => 'required',
            'host_id' => 'required',
            'type_name' => 'required',
            'backend_user' => 'required',
            'backend_password' => 'required'

        ]);
        $check_isexist  =   DomainDetail::where('domain_name', $request->domain_name)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'domain name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.ddetail')->with($notification); 
        } 
         $repn   =   new DomainDetail;
         $repn->domain_name  =   $request->domain_name; 
         $repn->host_id  =   $request->host_id; 
         $repn->type  =   $request->type_name; 
         $repn->backend_user  =   $request->backend_user; 
         $repn->backend_password  =   $request->backend_password; 
       
        $repn->save();
        $notification   =   array(  'message' => 'Domain Details Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.ddetail')->with($notification); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DomainDetail  $domain_detail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type= Type::all();
        $host = HostDetail::all();
        $repn   = DomainDetail::find($id);
        return view('domain_detail.show',compact('repn','type','host'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain_detail  $domain_detail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type= Type::all();
        $host = HostDetail::all();
        $repn   = DomainDetail::find($id);
        return view('domain_detail.edit',compact('repn','type','host'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DomainDetail  $domain_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DomainDetail $domain_detail)
    {
        $repn = DomainDetail::find($request->id);

        $repn->domain_name = $request['domain_name']; 
        $repn->host_id = $request['host_id']; 
        $repn->type = $request['type']; 
        $repn->backend_user = $request['backend_user']; 
        $repn->backend_password = $request['backend_password']; 
        $repn->save();
        
        
        if($repn){
            $notification = array(  'message' => 'domain Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.ddetail')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.ddetail')->with($notification);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain_detail  $domain_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $repn                   =   DomainDetail::find($id);
        $repn->domain_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.ddetail')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   DomainDetail::find($request->id);  
        $repn->domain_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.ddetail')->with('success','state has been status successfully');
    }
   

   
}
