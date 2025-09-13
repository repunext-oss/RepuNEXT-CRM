<?php

namespace App\Http\Controllers;

use App\Models\GoalTask;
use App\Models\TaskTime;
use App\Models\TimeTracking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GoalSheetCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();


class GoalTaskController extends Controller
{
    public function index()
    {   
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }
        
        $user = User::all();
        $gc = GoalSheetCategory::all();
        $timer = TaskTime::all();
        $timeTracking = TimeTracking::all();
        $authUserId = Auth::id(); 
        
        $rolerawdata = session('userRoles', []);
        if (!is_array($rolerawdata)) {
            $rolerawdata = [];
        }
    
        if (in_array("kt_roles_select_all", $rolerawdata, true) || in_array("goalsheet_all", $rolerawdata, true)) {
            $repn = GoalTask::where('g_isdeleted', 0)
                ->orderBy('id', 'DESC')
                ->paginate(500);  
        } else {
            $repn = GoalTask::where('g_isdeleted', 0)
                ->whereRaw("FIND_IN_SET(?, g_assigned)", [$authUserId])
                ->orderBy('id', 'DESC')
                ->paginate(500); 
        }
    
        return view('goal_task.list', compact('repn', 'user', 'gc', 'timer', 'timeTracking'));
    }
      
    public function create()
    {   
        $loginUserId = Auth::id();
        $repn = user::all();
        $gc= GoalSheetCategory::all();
        return view('goal_task.add', compact('repn','gc','loginUserId'));   
    }
    public function store(Request $request)
    { 
      
        $request->validate([
            'g_taskname' => 'required',
            'g_category' => 'required',
            'g_deadline' => 'required',
            'g_priority' => 'required',
            'timer'      => 'required',
            'g_assigned' => 'required', 
            'g_status' => 'required',
        ]); 
    
            $repn = new GoalTask(); 
            $repn->g_taskname = $request->g_taskname;
            $repn->g_category = implode(',', $request->g_category);
            $repn->g_description = $request->g_description;
            $repn->g_deadline = $request->g_deadline;
            $repn->g_priority = $request->g_priority;
            $repn->timer      = $request->timer;
            $repn->g_assigned = implode(',', $request->g_assigned);
            $repn->g_assignedby = $request->g_assignedby;
            $repn->g_status = $request->g_status; 
            $repn->save(); 
            $notification   =   array(  'message' => 'Goal Task Stored Successfully',
            'alert-type' => 'success'  );

            return redirect()->route('list.gtask')->with($notification);      
    }  
    public function show($id)
    {   
        $repn   = GoalTask::find($id);
        $rep = User::all();
        $gscc= GoalSheetCategory::all();
        return view('goal_task.show',compact('repn','rep', 'gscc'));
    }

    public function edit(Request $request, $id)
    {
        $repn = GoalTask::find($id);
        $rep = User::all();
        $gscc = GoalSheetCategory::all();
        $timeTracking = TimeTracking::where('goalid_ref', $id)->first();
        
        // Create TimeTracking record if it doesn't exist
        if (!$timeTracking) {
            $timeTracking = TimeTracking::create([
                'goalid_ref' => $id,
                'start_time' => null,
                'pause_time' => null,
                'running_time' => 0,
                'status' => 'stopped'
            ]);
        }
    
        if (!$repn) {
            return redirect()->route('list.gtask')->with([
                'message' => 'Goal Task not found!',
                'alert-type' => 'warning',
            ]);
        }
    
        return view('goal_task.edit', compact('repn', 'rep', 'gscc', 'timeTracking'));
    }
    
    public function update(Request $request)
    { 
        $request->validate([
            'g_taskname' => 'required',
            'g_category' => 'required',
            'g_priority' => 'required',
            'g_assigned' => 'required', 
            'g_status' => 'required',
            'running_time' => 'nullable',
        ]);  

        $repn = GoalTask::findOrFail($request->id);

        if ($repn->g_status === 'Completed') {
            return redirect()->route('list.gtask')->with([
                'message' => 'This task has already been marked as completed and cannot be updated.',
                'alert-type' => 'warning',
            ]);
        } 

        $repn->g_taskname = $request->g_taskname;
        $repn->g_category = implode(',', $request->g_category);
        $repn->g_status = $request->g_status;
      
        $repn->g_priority = $request->g_priority;
       
        $repn->g_assigned = implode(',', $request->g_assigned);

        if ($request->has('running_time')) {
            if (is_numeric($request->running_time)) { 
                $repn->running_time = gmdate("H:i:s", (int)$request->running_time);
            } else {
                $repn->running_time = $request->running_time;
            }
        }

        if ($request->g_status === 'completed' && $repn->g_realenddate === null) {
            $repn->g_realenddate = now()->format('Y-m-d H:i:s');
        } else {
            $repn->g_realenddate = null;
        }

        $repn->save();

        return redirect()->route('list.gtask')->with([
            'message' => 'Goal Task Updated Successfully',
            'alert-type' => 'success',
        ]);
    }


    public function destroy($id)
    {
        $repn                   =   GoalTask::find($id);
        $repn->g_isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.gtask')->with('success','state has been deleted successfully');
    }

    public function status(Request $request)
    { 
        $repn               =   ProjectDetail::find($request->id);  
        $repn->	g_status    =   $request->	g_status;
        $repn->save();      
        return redirect()->route('list.gtask')->with('success','state has been status successfully');
    }
  
    public function start(Request $request)
    {
        $timeTracking = TimeTracking::where('goalid_ref', $request->goalId)->first();
        
        if (!$timeTracking) {
            // Create new time tracking record
            $timeTracking = TimeTracking::create([
                'goalid_ref' => $request->goalId, 
                'start_time' => now(),
                'running_time' => 0,
                'pause_time' => null,
                'status' => 'running'
            ]);
        } 
        else {
            // Update existing record - start or resume
            $timeTracking->update([
                'start_time' => now(),
                'pause_time' => null,
                'status' => 'running'
            ]);
        }
        
        return response()->json([
            'running_time' => $timeTracking->running_time,
            'action' => 'started',
            'message' => 'Task started successfully'
        ]); 
    }
    
    public function pause(Request $request, $id)
    {
        // Debug: Log the request
        \Log::info('Pause request received', [
            'id' => $id,
            'user_id' => auth()->id(),
            'running_time' => $request->input('running_time'),
            'request_data' => $request->all()
        ]);
        
        $timeTracking = TimeTracking::where('goalid_ref', $id)->first();
            
        if (!$timeTracking) {
            return response()->json(['error' => 'Record not found'], 404);
        }
        
        // Use the running_time from the request (calculated on frontend)
        $runningTime = $request->input('running_time', 0);
        
        // Check if we're pausing or resuming
        if ($timeTracking->pause_time !== null) {
            // Already paused - this is a resume request, clear pause_time
            $timeTracking->update([
                'pause_time' => null,
                'start_time' => now(), // Reset start time for new session
                'running_time' => $runningTime,
                'status' => 'running'
            ]);
            return response()->json(['running_time' => $runningTime, 'action' => 'resumed']);
        }
        
        if (!$timeTracking->start_time) {
            return response()->json(['error' => 'Start time not set'], 400);
        }
    
        // This is a pause request
        $timeTracking->update([
            'pause_time' => now(),
            'running_time' => $runningTime,
            'status' => 'paused'
        ]);
    
        return response()->json(['running_time' => $runningTime, 'action' => 'paused']);     
    }
    
    public function stop(Request $request, $id)
    {
        $timeTracking = TimeTracking::where('goalid_ref', $id)->first();

        if (!$timeTracking) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        // Use the running_time from the request (calculated on frontend)
        $runningTime = $request->input('running_time', 0);

        // Finalize the task - store final running time and clear active state
        $timeTracking->update([
            'running_time' => $runningTime,
            'pause_time' => null,  // Clear pause time
            'status' => 'stopped'  // Mark as stopped
            // Note: start_time is preserved for future reference
        ]);
        
        return response()->json([
            'running_time' => $runningTime,
            'action' => 'stopped',
            'message' => 'Task stopped successfully'
        ]);
    }

    // public function filterTasks(Request $request)
    // {
    //     if (!$request->has('start_date') || !$request->has('end_date')) {
    //         return response()->json(['error' => 'Missing start_date or end_date'], 400);
    //     }
    
    //     $startDate = Carbon::parse($request->start_date)->startOfDay();
    //     $endDate = Carbon::parse($request->end_date)->endOfDay();
    
    //     $tasks = GoalTask::whereBetween('created_at', [$startDate, $endDate])->get();
    
    //     $notStarted = 0;
    //     $delayed = 0;
    //     $onTime = 0;
    
    //     foreach ($tasks as $task) {
    //         $timerSeconds = ($task->timer ?? 0) * 60;
    //         $timeTrack = TimeTracking::where('goalid_ref', $task->id)->first();
    //         $runningSeconds = $timeTrack->running_time ?? 0;
    
    //         if ($runningSeconds == 0) {
    //             $notStarted++;
    //         } elseif ($runningSeconds > $timerSeconds) {
    //             $delayed++;
    //         } else {
    //             $onTime++;
    //         }
    //     }
    
    //     return response()->json([
    //         'notStarted' => $notStarted,
    //         'delayed' => $delayed,
    //         'onTime' => $onTime,
    //         'tasks' => $tasks
    //     ]);
    // }
}
