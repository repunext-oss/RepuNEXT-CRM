<?php

namespace App\Http\Controllers;

use App\Models\WebsiteCredential;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsitecredentialController extends Controller
{
    
    public function index(Request $request)
    {
        $websitecredential=WebsiteCredential::all();
        $Month=$request->input('Month');

        $query=WebsiteCredential::query();
        
        if ($Month && $Month !== 'all') {
            $query->where('Month', $Month);
        }

        $websitecredential = $query->get();
        return view('website.main',['websitecredential'=>$websitecredential]);
    }
        

    
    public function add()
    {
        return view('website.add');
    }

   
    public function store(Request $request){
        $data=$request->validate([
            'Website'=>'required',
            'URL'=>'required',
            'User_Name'=>'required',
            'Password'=>'required',
            'Completion_Date'=>'required',
            'Next_Renewal_Date'=>'required',
            'Client_Contact1'=>'required',
            'Client_Contact2'=>'nullable',
            'Month'=>'required',
            
        ]);

        $new=WebsiteCredential::create($data);
        $notification = array(
            'message' => 'Credential created Successfully',
            'alert-type' => 'success'
            );
        return redirect(route('website.main'))->with($notification);
    }

  
    public function edit(WebsiteCredential $d)
    {
        return view('website.edit',['d'=>$d]);
    }

 
   
    public function update(Request $request, WebsiteCredential $d) {
        $data = $request->validate([
            'Website'=>'required',
            'URL'=>'required',
            'User_Name'=>'required',
            'Password'=>'required',
            'Completion_Date'=>'required',
            'Next_Renewal_Date'=>'required',
            'Client_Contact1'=>'required',
            'Client_Contact2'=>'nullable',
            'Month'=>'required',
        ]);
    
        $d->update($data);

        $notification = array(
            'message' => 'Credential created Successfully',
            'alert-type' => 'success'
            );
    
        return redirect(route('website.main'));
    }

   
    public function view(WebsiteCredential $d)
    {
        return view('website.view',['d'=>$d]);
    }
}
