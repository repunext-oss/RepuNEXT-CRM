<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Callcenter;

class callcenterController extends Controller
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
        return redirect(route('website.main'))->with($notification);
    }

    public function edit(callcenter $d){
        return view('callcenter.edit',['d'=>$d]);
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
    
        return redirect(route('website.main'));
    }
    
    
}
