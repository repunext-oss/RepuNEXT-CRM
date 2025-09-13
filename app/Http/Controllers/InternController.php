<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;

class InternController extends Controller
{
   
    public function index()
    {   
        $interns   =  Intern::where('i_isdeleted', 0)->orderBy('id','DESC')->get();
        return view('intern.list', compact('interns'));              
    }

    public function create()
    {
        return view('intern.add');
    }

    public function store(Request $request)
    {
        $intern          =   new Intern;
        $intern->Name    =   $request->Name; 
        $intern->Mobile  =   $request->Mobile; 
        $intern->Startdate    =   $request->Startdate; 
        $intern->Enddate    =   $request->Enddate; 
        $intern->Duration    =   $request->Duration; 
        $intern->Slot    =   $request->Slot; 
        $intern->Course  =   $request->Course; 
        $intern->Source  =   $request->Source; 
        // $intern->Letter  =   $request->Letter; 
        // $intern->Certificate    =   $request->Certificate; 
        // $intern->Documentation  =   $request->Documentation; 
        $intern->Collage  =   $request->Collage; 
        $intern->Department  =   $request->Department; 
        $intern->year  =   $request->year; 
        $intern->Area     =   $request->Area; 
        $intern->City     =   $request->City; 
        $intern->Type     =   $request->Type; 
        $intern->Amount   =   $request->Amount;
        $intern->amt      =   $request->amt; 
              
        $intern->save();
        $notification   =   array(  'message' => ' Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.intern')->with($notification);  
    }
    
    public function show($id)
    {
        $intern = Intern::findOrFail($id);
        return view('intern.show', compact('intern'));
    }

    public function edit($id)
    {
        $intern = Intern::findOrFail($id);
        return view('intern.edit', compact('intern'));
    }

    public function update(Request $request)
    {
         $intern = Intern::find($request->id);
         $intern->Name    =   $request->Name; 
         $intern->Mobile  =   $request->Mobile; 
         $intern->Startdate   =   $request->Startdate; 
         $intern->Enddate     =   $request->Enddate; 
         $intern->Duration    =   $request->Duration; 
         $intern->Slot    =   $request->Slot; 
         $intern->Course  =   $request->Course; 
         $intern->Source  =   $request->Source; 
         $intern->Letter  =   $request->Letter; 
         $intern->Certificate    =   $request->Certificate; 
         $intern->Documentation  =   $request->Documentation; 
         $intern->Collage  =   $request->Collage; 
         $intern->Department  =   $request->Department; 
         $intern->year  =   $request->year; 
         $intern->Area     =   $request->Area; 
         $intern->City     =   $request->City; 
         $intern->Type     =   $request->Type; 
         $intern->Amount   =   $request->Amount;
         $intern->amt      =   $request->amt; 
        
        $intern->save();
        $notification   =   array(  'message' => ' Stored Successfully',
                                    'alert-type' => 'success'  );
           
        return redirect()->route('list.intern')->with($notification);  
    }
    public function destroy($id)
    {
        $intern                   =   Intern::find($id);
        $intern->i_isdeleted     =   "1";
        $intern->save();     
        return redirect()->route('list.intern')->with('success','state has been deleted successfully');
    }
}
