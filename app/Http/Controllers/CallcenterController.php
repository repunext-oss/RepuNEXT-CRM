<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use  App\Models\Callcenter;

class CallCenterController extends Controller
{
    public function index(Request $request){
        $callcenter=Callcenter::all();
        $Status = $request->input('Status');

        $query = Callcenter::query();

        if ($Status && $Status !== 'all') {
            $query->where('Status', $Status);
        }

        $callcenter = $query->get();
        return view('callcenter.callcenter',['callcenter'=>$callcenter]);
    }

    public function add(){
        return view('callcenter.add');
    }

    public function store(Request $request){
        $data=$request->validate([
            'Name'=>'required',
            'Mobile'=>'required|numeric',
            'Enquiry_Date'=>'required',
            'Email'=>'nullable',
            'Company_Name'=>'required',
            'FollowUp'=>'required',
            'followupdate'=>'nullable',
            'Source'=>'required',
            'Service'=>'required',
            'Status'=>'required',
        ]);

        $new=Callcenter::create($data);
        $notification = array(
            'message' => 'Call Center is created Successfully',
            'alert-type' => 'success'
            );
        return redirect(route('callcenter.callcenter'))->with($notification);
    }
    public function show($id)
    {   
        $d = CallCenter::find($id);
        return view('callcenter.show',compact('d'));
    }

    public function edit($id){
        $d = CallCenter::find($id);
        return view('callcenter.edit',compact('d'));
    }
   
    public function update(Request $request, callcenter $d) {
        $data = $request->validate([
            'Name' => 'required',
            'Mobile' => 'required|numeric',
            'Enquiry_Date' => 'required',
            'Email' => 'nullable',
            'Company_Name' => 'required',
            'FollowUp' => 'required',
            'followupdate'=>'nullable',
            'Source' => 'required',
            'Service' => 'required',
            'Status' => 'required',
        ]);
    
        $d->update($data);
    
        return redirect(route('callcenter.callcenter'));
    }
    public function destroy($id)
    {
        $repn                   =   Callcenter::find($id);
        $repn->c_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('callcenter.callcenter')->with('success','state has been deleted successfully');
    }

}
