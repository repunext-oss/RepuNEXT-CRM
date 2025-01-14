<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {   
        $repn   =   Type::where('t_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('types.list',compact('repn'));              
    }
    public function create()
    {
        return view('types.add');   
    }
    public function store(Request $request){
        $request->validate([
            'type_name' => 'required',
        ]);
        $check_isexist  =   Type::where('type_name', $request->type_name)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'type name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.ttime')->with($notification); 
        } 
        $repn           =   new Type; 
        $repn->type_name  =   $request->type_name; 
       
        $repn->save();
        $notification   =   array(  'message' => 'Project Service Stored Successfully',
                                    'alert-type' => 'success');
           
        return redirect()->route('list.ttime')->with($notification);  
    }
    public function show($id)
    {
        $repn   = Type::find($id);
        return view('types.show',compact('repn'));
    }
    public function edit($id)
    
        {
            $repn   = Type::find($id);
        return view('types.edit',compact('repn'));   
    }
    
    public function update(Request $request)
    {
        $repn           =   Type::find($request->id);
        $repn->type_name  =   $request['type_name']; 
       
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'Project Service Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.ttime')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.ttime')->with($notification);
        }
    }
      
    
    public function destroy($id)
    {
        $repn                   =   Type::find($id);
        $repn->t_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.ttime')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   Type::find($request->id);  
        $repn->t_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.ttime')->with('success','state has been status successfully');
    }
}
