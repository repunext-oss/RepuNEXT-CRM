<?php

namespace App\Http\Controllers;

use App\Models\Tasktimesheet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();


class TasktimesheetController extends Controller
{
    public function index(Request $request)
    {   
        try {
            if (Auth::check()) {
                Session::put([
                    'name' => Auth::id(), 
                    'username' => Auth::user()->username
                ]);
            }
    
            $currentDateTime = now()->format('Y-m-d'); 
            Tasktimesheet::whereNull('tt_date')->update(['tt_date' => $currentDateTime]);
            
            $user = User::all(); 
            $serv = Timesheet::all();
            $rolerawdata = session('userRoles', []);
            $authUserId = Auth::id();
            $repn = [];
    
            if($request->has(['startDate', 'endDate'])) {
                $startDate = Carbon::parse($request->startDate)->format('Y-m-d');
                $endDate = Carbon::parse($request->endDate)->format('Y-m-d');
    
                if (!$startDate || !$endDate) {
                    return response()->json(['error' => 'Invalid date range provided.'], 400);
                }
                
                $query = Tasktimesheet::whereBetween('tt_date', [$startDate, $endDate])
                    ->where('tc_isdeleted', 0)
                    ->orderBy('id', 'DESC');
    
                if (!in_array("kt_roles_select_all", $rolerawdata, TRUE) && !in_array("timesheet_all", $rolerawdata, TRUE)) {
                    $query->where('tc_name', $authUserId);
                }
    
                $repn = $query->get();
    
                return response()->json([
                    'repn' => $repn,
                    'serv' => $serv,
                    'user' => $user
                ]);
            }
    
            $query = Tasktimesheet::where('tc_isdeleted', 0)->orderBy('id', 'DESC');
    
            if (!in_array("kt_roles_select_all", $rolerawdata, TRUE) && !in_array("timesheet_all", $rolerawdata, TRUE)) {
                $query->where('tc_name', $authUserId);
            }
    
            $repn = $query->paginate(20);
    
            return view('task_timsheet.list', compact('serv', 'repn', 'user'));      
        } catch (\Exception $e) {
            Log::error("Error in fetching timesheets: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
    

    public function create()
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }

        $user = User::all(); 
        $repu = Timesheet::where('tc_isdeleted',0)->get();
        return view('task_timsheet.add',compact('repu','user'));  
    }
   
    public function store(Request $request)
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }
        $request->validate([
            'tt_cat' => 'required',
            'tt_name' => 'required',
            'tt_desc' => 'required',
            'tt_starttime' => 'required',
            'tt_endtime' => 'required',
        ]);
    
        $check_isexist = Tasktimesheet::where('tt_date', $request->tt_date)->first();
        
        if ($check_isexist) {
            $notification = array(
                'message' => 'Project Detail already exists',
                'alert-type' => 'warning'
            );
            return redirect()->route('list.ttimecat')->with($notification);
        }
    
        $repn = new Tasktimesheet;
        // $repn->tt_date = $request->tt_date;
        $repn->tt_cat  =   implode(',',$request->tt_cat);
        $repn->tt_name = $request->tt_name;
        $repn->tt_desc = $request->tt_desc;   
        $repn->tt_starttime = $request->tt_starttime;
        $repn->tt_endtime= $request->tt_endtime;
        $repn->tc_name = session('name');
        $repn->save();
    
        $notification = array(
            'message' => 'TaskTimesheet Category Stored Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('list.ttimecat')->with($notification);
    }
    
    public function show($id)
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }

        $user = User::all(); 
        $serv   = Timesheet::all();
        $repn   = Tasktimesheet::find($id);
        return view('task_timsheet.show',compact('serv','repn','user'));
    }
    public function edit($id)
    {
        $user = User::all(); 
        $serv   = Timesheet::where('tc_isdeleted',0)->get();
        $repn   = Tasktimesheet::find($id);
        return view('task_timsheet.edit',compact('repn','serv','user'));   
    }
    public function update(Request $request)
    {
 
        $repn           =   Tasktimesheet::find($request->id);
        // $repn->tt_date = $request['tt_date'];
        $repn->tt_cat  =  implode(',', $request->tt_cat); 
        $repn->tt_name = $request['tt_name'];
        $repn->tt_desc = $request['tt_desc'];
        $repn->tt_starttime = $request['tt_starttime'];
        $repn->tt_endtime= $request['tt_endtime'];
        
      
        $repn->save();     
        if($repn){
            $notification = array(  'message' => 'tasktimesheet Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.ttimecat')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.ttimecat')->with($notification);
        }
    }
    public function destroy($id)
    {
        $repn                   =   Tasktimesheet::find($id);
        $repn->tc_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.ttimecat')->with('success','state has been deleted successfully');
    }
    // public function status(Request $request)
    // { 
    //     $repn               =   Tasktimesheet::find($request->id);  
    //     $repn->tc_status    =   $request->statusval;
    //     $repn->save();     
    //     return redirect()->route('list.ttimecat')->with('success','state has been status successfully');
    // }

}
