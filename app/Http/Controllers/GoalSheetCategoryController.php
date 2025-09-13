<?php

namespace App\Http\Controllers;

use App\Models\GoalSheetCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalSheetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repn   =  GoalSheetCategory::where('gc_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('goalsheet_category.list',compact('repn'));
    }
   
    public function create()
    {
        
        return view('goalsheet_category.add');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gc_name' => 'required',
        ]);
        $check_isexist  =   GoalSheetCategory::where('gc_name', $request->gc_name)->first();  
        if($check_isexist){
            $notification   =   array(  'message' => 'Project Service name already exists',
                                        'alert-type' => 'warning'  );
            return redirect()->route('list.gscategory')->with($notification); 
        } 
        $repn           =   new GoalSheetCategory; 
        $repn->gc_name  =   $request->gc_name; 
        $repn->save();
        $notification   =   array(  'message' => 'Project Service Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.gscategory')->with($notification);      }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $repn   = GoalSheetCategory::find($id);
        return view('goalsheet_category.show',compact('repn'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $repn   = GoalSheetCategory::find($id);
        return view('goalsheet_category.edit',compact('repn'));   
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $repn           =   GoalSheetCategory::find($request->id);
        $repn->gc_name  =   $request['gc_name']; 
     
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'Project Details Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.gscategory')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.gscategory')->with($notification);
        }    
    }
    public function destroy($id)
    {
        $repn                   =   GoalSheetCategory::find($id);
        $repn->gc_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.gscategory')->with('success','state has been deleted successfully');  
    }
    public function status(Request $request)

    { 
        $repn               =   GoalSheetCategory::find($request->id);  
        $repn->	gc_status    =   $request->	gc_status;
        $repn->save();      
        return redirect()->route('list.gscategory')->with('success','state has been status successfully');
    }
}
