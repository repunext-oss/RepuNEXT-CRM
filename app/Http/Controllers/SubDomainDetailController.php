<?php

namespace App\Http\Controllers;
use App\Models\Type;
use App\Models\HostDetail;
use App\Models\SubDomainDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubDomainDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type= Type::all();
        $host = HostDetail::all();
        $repn   =  SubDomainDetail::where('domain_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('sub_domain_detail.list',compact('repn','type','host'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type= Type::all();
        $host = HostDetail::all();
        return view('sub_domain_detail.add',compact('type','host'));  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subdomain_name' => 'required',
            'host_id' => 'required',
            'type_name' => 'required',
            'backend_user' => 'required',
            'backend_password' => 'required'

        ]);
        $check_isexist  =   SubDomainDetail::where('subdomain_name', $request->domain_name)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'domain name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.sddetail')->with($notification); 
        } 
         $repn   =   new SubDomainDetail;
         $repn->subdomain_name  =   $request->subdomain_name; 
         $repn->host_id  =   $request->host_id; 
         $repn->type  =   $request->type_name; 
         $repn->backend_user  =   $request->backend_user; 
         $repn->backend_password  =   $request->backend_password; 
       
        $repn->save();
        $notification   =   array(  'message' => 'Domain Details Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.sddetail')->with($notification); 
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $type= Type::all();
        $host = HostDetail::all();
        $repn   = SubDomainDetail::find($id);
        return view('sub_domain_detail.show',compact('repn','type','host'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type= Type::all();
        $host = HostDetail::all();
        $repn   = SubDomainDetail::find($id);
        return view('sub_domain_detail.edit',compact('repn','type','host'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $repn = SubDomainDetail::find($request->id);

        $repn->subdomain_name = $request['subdomain_name']; 
        $repn->host_id = $request['host_id']; 
        $repn->type = $request['type']; 
        $repn->backend_user = $request['backend_user']; 
        $repn->backend_password = $request['backend_password']; 
        $repn->save(); 
        if($repn){
            $notification = array(  'message' => 'domain Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.sddetail')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.sddetail')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $repn                   =   SubDomainDetail::find($id);
        $repn->domain_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.sddetail')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   SubDomainDetail::find($request->id);  
        $repn->domain_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.sddetail')->with('success','state has been status successfully');
    } 
}
