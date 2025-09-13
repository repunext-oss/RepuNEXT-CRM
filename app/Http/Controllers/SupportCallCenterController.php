<?php

namespace App\Http\Controllers;

use App\Models\SupportCallCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class SupportCallCenterController extends Controller
{
    public function index()
    {   
        $user = User::all(); 
        $repn   =   SupportCallCenter::where('s_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('support.list',compact('repn','user'));              
    }
    public function create()
    {
         $loginUserId = Auth::id();
         $user = User::all(); 
        return view('support.add',compact('user','loginUserId'));
    }
    public function store(Request $request){

        // dd($request->all());
        // if (Auth::check()) {
        //     session(['userid' => Auth::user()->id, 'username' => Auth::user()->username]);
        // }
       
        $request->validate([
            'Name' => 'required',
            'mobile' => 'required',
            // 'mobile2' => 'required',
            // 'Email' => 'required',
            'Enquiry_Date' => 'required', 
            // 'Company_Name' => 'required', 
            'Location' => 'required',
            // 'Area' => 'required',
            'Source' => 'required',
            'Service' => 'required',
            'Status' => 'required',
        ]);
       
        // $check_isexist  =   SupportCallCenter::where('Name', $request->Name)->first();  
        // if($check_isexist){
        //     $notification   =   array(  'message' => 'name already exists',
        //                                 'alert-type' => 'warning'  );
        //     return redirect()->route('list.support')->with($notification); 
        // } 

        $repn = new SupportCallCenter; 
        $repn->userid = $request->userid; 
        $repn->Name = $request->Name; 
        $repn->mobile = $request->mobile; 
        $repn->mobile2 = $request->mobile2; 
        $repn->Describe= $request->Describe;
        $repn->Enquiry_Date = $request->Enquiry_Date; 
        $repn->Email     = $request->Email; 
        $repn->Company_Name = $request->Company_Name;
        $repn->location = $request->Location;
        $repn->Area = $request->Area;
        $repn->Source = $request->Source;
        $repn->Service = implode(',', $request->Service);
        $repn->Status = $request->Status;
    
        $repn->save();
    
        $notification = [
            'message' => 'Call Center entry created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('list.support')->with($notification);
    }
    public function show($id)
    { 
        $repn   = SupportCallCenter::find($id);
        return view('support.show',compact('repn'));
    }
    public function edit($id)
    {
        $repn   = SupportCallCenter::find($id);
        return view('support.edit',compact('repn'));   
    }
    public function update(Request $request)
    {
        $repn   =   SupportCallCenter::find($request->id);
        $repn->Name = $request['Name'];
        $repn->mobile = $request['mobile']; 
        $repn->mobile2 = $request['mobile2']; 
        $repn->Enquiry_Date = $request['Enquiry_Date'];
        $repn->Email     = $request['Email'];
        $repn->Describe= $request['Describe'];
        $repn->Company_Name = $request['Company_Name'];
        $repn->location = $request['location'];
        $repn->Area = $request['Area'];
        $repn->Source = $request['Source'];
        $repn->Service = $request['Service'];
        $repn->Status = $request['Status'];
       
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'Project Service Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.support')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.support')->with($notification);
        }
    }    
    public function destroy($id)
    {
        $repn                   =   SupportCallCenter::find($id);
        $repn->s_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.support')->with('success','state has been deleted successfully');
    }
    // public function status(Request $request)
    // { 
    //     $repn               =   SupportCallCenter::find($request->id);  
    //     $repn->t_status    =   $request->statusval;
    //     $repn->save();     
    //     return redirect()->route('list.support')->with('success','state has been status successfully');
    // }
}