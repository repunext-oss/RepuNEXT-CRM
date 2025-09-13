<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $repn   =  SocialMedia::where('sm_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('social_media.list',compact('repn'));    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $smedia = SocialMedia::all();
        return view('social_media.add',compact('smedia'));        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sm_company' => 'required',
            'sm_name' => 'required',
            'sm_link' => 'required',
        

        ]);
        // $check_isexist  =   SocialMedia::where('sm_name', $request->sm_name)->first();  
        // if($check_isexist){
        //     $notification   =   array(  'message' => 'tool name already exists',
        //                                 'alert-type' => 'warning'  );
        //     return redirect()->route('list.smedia')->with($notification); 
        // }
        $repn   =   new SocialMedia;
        $repn->sm_company  =   $request->sm_company; 
        $repn->sm_name  =   $request->sm_name; 
        $repn->sm_link  =   $request->sm_link; 
        $repn->sm_user  =   $request->sm_user; 
        $repn->sm_password  =   $request->sm_password; 
        $repn->save();
        $notification   =   array(  'message' => 'Tool Credentials Stored Successfully',
                                    'alert-type' => 'success'  );
        
        return redirect()->route('list.smedia')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $repn   = SocialMedia::find($id);
        return view('social_media.show',compact('repn'));    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $repn   = SocialMedia::find($id);
        return view('social_media.edit',compact('repn')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $repn = SocialMedia::find($request->id);
        $repn->sm_company = $request['sm_company']; 
        $repn->sm_name = $request['sm_name']; 
        $repn->sm_link = $request['sm_link']; 
        $repn->sm_user = $request['sm_user']; 
        $repn->sm_password = $request['sm_password']; 
        $repn->save(); 
        if($repn){
            $notification = array(  'message' => 'Tools Credentials Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.smedia')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.smedia')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $repn                   =   SocialMedia::find($id);
        $repn->sm_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.smedia')->with('success','state has been deleted successfully');    
    }
    public function status(Request $request)
    { 
        $repn               =   SocialMedia::find($request->id);  
        $repn->sm_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.smedia')->with('success','state has been status successfully');
    }

}
