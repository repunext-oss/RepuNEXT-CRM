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

    public function add() {
        return view('callcenter.add');
    }
    
    public function store(Request $request) {
   
        $data = $request->validate([
            'Name' => 'required',
            'Mobile' => 'required|numeric',
            'location' => 'required',
        ]);
    
        $check_isexist = Callcenter::where('Name', $request->Name)->first();  
        if ($check_isexist) {
            $notification = array(
                'message' => 'Project Service name already exists',
                'alert-type' => 'warning'
            );
            return redirect()->route('callcenter.callcenter')->with($notification); 
        }

        $data = new Callcenter; 
        $data->Name = $request->Name; 
        $data->Mobile = $request->Mobile; 
        $data->mobile2 = $request->mobile2; 
        $data->Enquiry_Date = $request->Enquiry_Date; 
        $data->followup1 = $request->followup1; 
        $data->followup2 = $request->followup2; 
        $data->followup3 = $request->followup3; 
        $data->Company_Name = $request->Company_Name;
        $data->location = $request->location;
        $data->area = $request->area;
        $data->Source = $request->Source;
        $data->Service = $request->Service;
    
        $data->save();
    
        $notification = array(
            'message' => 'Call Center entry created successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('callcenter.callcenter')->with($notification);
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
                'location' => 'required',
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
