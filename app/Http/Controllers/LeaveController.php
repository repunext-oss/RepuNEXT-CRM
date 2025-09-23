<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApprovedMail;
use App\Mail\LeaveRejectedMail;
use App\Mail\LeaveAppliedMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index()
        {
            if (Auth::check()) {
                session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
            }

            $user = User::all();
            $repn = Leave::where('l_isdeleted', 0)
                        ->orderBy('id', 'DESC')
                        ->get();

            // Fetch total leave taken per user, grouped by year and month, with the user's name
                $leaveSummary = DB::table('leave_management')
                    ->join('users', 'leave_management.user_ref_id', '=', 'users.id')  // Corrected join with user_ref_id
                    ->selectRaw('
                        users.name as user_name,  /* Changed from username to name (to fetch full name) */
                        YEAR(leave_management.date) as year,
                        MONTH(leave_management.date) as month,
                        SUM(leave_management.taken_leave) as total_leave
                    ')
                    ->where('leave_management.l_isdeleted', 0)
                    ->whereNotIn('leave_management.taken_leave', [0.25, 2])  // Exclude short leaves
                    ->groupBy('users.name', DB::raw('YEAR(leave_management.date)'), DB::raw('MONTH(leave_management.date)'))
                    ->orderBy('year', 'ASC')
                    ->orderBy('month', 'DESC')
                    ->get();


            // dd( $leaveSummary);
            // exit();


            return view('leave.list', compact('repn', 'user', 'leaveSummary'));
        }
    
        public function create()
        {
            if (Auth::check()) {
                session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
            }
    
            $user = User::all(); 
            return view('leave.add', compact('user'));  
        }
    
       public function store(Request $request)
{
    if (Auth::check()) {
        session([
            'name' => Auth::user()->id,
            'username' => Auth::user()->username
        ]);
    }

    // Save leave to database
    $repn = new Leave;
    $repn->leave_type  = $request->leave_type;
    $repn->startdate   = $request->startdate;
    $repn->enddate     = $request->enddate;
    $repn->reason      = $request->reason;
    $repn->totaldays   = $request->totaldays;
    $repn->name        = session('name');
    $repn->save();

    // ✅ FIX: Get the logged-in user
    $user = Auth::user();

    // Send email to support team
    Mail::send(new LeaveAppliedMail([
        'subject'     => 'New Leave Request Submitted',
        'username'    => $user->name,
        'user_email'  => $user->email,
        'leave_type'  => $request->leave_type,
        'start_date'  => $request->startdate,
        'end_date'    => $request->enddate,
        'total_days'  => $request->totaldays,
        'reason'      => $request->reason,
                'id'      => $request->id,

    ]));

    // Flash success notification
    $notification = [
        'message' => 'Leave Detail Stored and Email Sent Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('list.leave')->with($notification);
}


// Removed HOUR_PER_DAY constant - now using 1 day = 1 day

public function approveLeave(Request $request)
{
    DB::beginTransaction();
    try {
        $leave = Leave::find($request->leave_id);
        if (!$leave) {
            return response()->json(['message' => 'Leave request not found'], 404);
        }

        // Your schema: "name" holds user_id
        $userId     = (int) $leave->name;
        $takenDays = (float) $leave->totaldays; // Now in days

        // Get current running balance (latest row)
        $latest = LeaveManagement::where('user_ref_id', $userId)
            ->orderByDesc('id')
            ->lockForUpdate()
            ->first();

        // Default values for leave balances (CL=0, SL=1 day, Credit=0)
        $credit = $latest?->credit_leave ?? 0.0;
        $cl     = $latest?->casual_leave  ?? 0.0;
        $sl     = $latest?->sick_leave    ?? 1.0; // 1 day default
        $perm   = $latest?->permission    ?? 0.0;

        // Check if this is permission or 15 min late (should not detect anything)
        $isPermissionOrLate = ($leave->leave_type === 'Permission 1st Half' || $leave->leave_type === 'Permission 2nd Half' || $leave->leave_type === 'Late Entry/Exit 15 mins (1st Half)' || $leave->leave_type === 'Late Entry/Exit 15 mins (2nd Half)');
        
        // For permission and 15 min late, approve without any balance checking or deduction
        if ($isPermissionOrLate) {
            // Approve without any balance checking or deduction
            $leave->l_status = 1;
            $leave->save();
            
            return response()->json([
                'message' => 'Permission/Late approved without any balance checking.',
            ]);
        }

        // ---- Deduct in priority: Credit -> CL -> SL (for regular leaves) ----
        $remaining = $takenDays;

        // **Step 1: Deduct from current month Credit Leave (if available)**
        $useCredit  = min($remaining, $credit);
        $credit    -= $useCredit;
        $remaining -= $useCredit;

        // **Step 2: If Credit is exhausted, deduct from Casual Leave (CL)**
        $useCL = 0.0;
        if ($remaining > 0) {
            $useCL   = min($remaining, $cl);
            $cl     -= $useCL;
            $remaining -= $useCL;
        }

        // **Step 3: If Casual Leave (CL) is exhausted, deduct from Sick Leave (SL)**
        $useSL = 0.0;
        if ($remaining > 0) {
            $useSL   = min($remaining, $sl);
            $sl     -= $useSL;
            $remaining -= $useSL;
        }

        // **Step 4: Leftover is Loss of Pay (LOP)**
        $lopDays = max(0.0, $remaining);

        // Approve original leave
        $leave->l_status = 1;
        $leave->save();

        // Insert new running-balance row (REMAINING balances after deduction)
        LeaveManagement::create([
            'user_ref_id'  => $userId,
            'date'         => Carbon::now()->format('Y-m-d'),
            'taken_leave'  => $takenDays,
            'credit_leave' => $credit,  // remaining
            'casual_leave' => $cl,      // remaining
            'sick_leave'   => $sl,      // remaining
            'permission'   => $perm,
            'l_status'     => $lopDays, // LOP days
            'l_isdeleted'  => 0,
        ]);

        // Update the most recent row (last record) with the **correct CL and SL balances**
        LeaveManagement::where('user_ref_id', $userId)
            ->orderByDesc('id')
            ->limit(1)
            ->update([
                'casual_leave' => $cl,
                'sick_leave'   => $sl,
            ]);

        DB::commit();

        // Optional: return a quick summary
        return response()->json([
            'message' => $lopDays > 0 ? 'Leave approved (with LOP).' : 'Leave approved.',
            'used_days' => ['credit' => $useCredit, 'cl' => $useCL, 'sl' => $useSL, 'total' => $takenDays],
            'balances_days' => ['credit' => $credit, 'cl' => $cl, 'sl' => $sl, 'lop' => $lopDays],
        ]);

    } catch (\Throwable $e) {
        DB::rollBack();
        \Log::error('Leave Approval Error: '.$e->getMessage());
        return response()->json(['message' => 'Internal server error'], 500);
    }
}

    public function reject(Request $request)
{
    $request->validate([
        'leave_id' => 'required|exists:leaves,id',
        'user_id'  => 'required|exists:users,id',
        'reason'   => 'required|string'
    ]);

    // Update leave status
    $leave = Leave::findOrFail($request->leave_id);
    $leave->l_status = 2;             
    $leave->status   = 'rejected';    
    $leave->reasons  = $request->reason; 
    $leave->save();

    // Get user
    $user = User::find($request->user_id);

    if ($user && $user->email) {
        $details = [
            'subject'  => 'Leave Rejected',
            'username' => $user->name ?? 'User',   // ✅ Add this key
            'reason'   => $request->reason,
        ];

        // Send email
        Mail::to($user->email)->send(new LeaveRejectedMail($details));
    }

    return response()->json(['message' => 'Leave rejected and email sent successfully.']);
}

    public function show($id)
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }
        $user = User::all(); 
        $repn = Leave::findOrFail($id); 
        return view('leave.show', compact('user', 'repn')); 
    }

    public function edit($id)
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }

        $user = User::all(); 
        $repn = Leave::findOrFail($id); 
        return view('leave.edit', compact('user', 'repn'));
    }
    public function update(Request $request) 
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }
    
        $repn = Leave::find($request->id);
     
        if (!$repn) {
            return redirect()->route('list.leave')->with('error', 'Leave record not found.');
        }
     
        $repn->leave_type = $request['leave_type']; 
        $repn->startdate = $request['startdate']; 
        $repn->enddate = $request['enddate']; 
        $repn->reason = $request['reason']; 
        $repn->totaldays = $request['totaldays'];
        $repn->l_status = $request['l_status']; 
        $repn->save(); 
        return redirect()->route('list.leave')->with([
            'message' => 'Leave Details Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    
    public function updateLeaveStatus(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'leave_id' => 'required|exists:leaves,id',    // Ensure the leave ID exists
            'action' => 'required|in:reject,approve',      // Ensure action is either reject or approve
            'reason' => 'nullable|string'                  // Reason is optional, but must be a string if provided
        ]);

        // Fetch the leave along with the user details
        $leave = Leave::with('user')->findOrFail($request->leave_id);

        // Handle leave rejection
        if ($request->action === 'reject') {
            $leave->status = 2;  // Set the leave status to rejected (2)
            $leave->rejection_reason = $request->reason;  // Save rejection reason
            $leave->save();

            if ($leave->user && $leave->user->email) {
                Mail::to($user->email)->send(new LeaveRejectedMail($leave, $request->reason));
            }

            return response()->json(['message' => 'Leave rejected and email sent.']);
        }
        return response()->json(['message' => 'Invalid action.'], 400);
    }
        
        public function sendResponseEmail(Request $request)
        {
            $id = $request->id;
            $action = $request->action;

            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found!'], 404);
            }
    
            $subject = $action === "approve" ? "Your Request has been Approved" : "Your Request has been Rejected";
            $message = $action === "approve" ? "Your leave request has been approved." : "Sorry, your leave request has been rejected.";

       Mail::to($user->email)->send(new LeaveApprovedMail([
        'subject'  => $subject,
        'message'  => $message,
        'username' => $user->name  // ✅ This line added
    ]));

            return response()->json(['message' => "Email sent successfully!"]);
        }


        public function destroy($id)
        {  
            $repn  =   ProjectDetail::find($id);
            $repn->project_isdeleted     =   "1";
            $repn->save();     
            return redirect()->route('list.leave')->with('success','state has been deleted successfully');
        }
        
        public function status(Request $request)
        { 
            $repn   =   ProjectDetail::find($request->id);  
            $repn->	project_status    =   $request->	project_status;
            $repn->save();     
            return redirect()->route('list.leave')->with('success','state has been status successfully');
        }


public function getLeaveBalance(Request $request)
{
    // 1. Check if user is authenticated
    if (!Auth::check()) {
        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }

    // 2. Validate input dates
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    // 3. Assign date range defaults
    $startDate = $request->start_date ?? '2025-01-01';
    $endDate = $request->end_date ?? date('Y-m-d');

    // 4. Query leave balance only for authenticated user
    $leaveBalance = DB::table('leave_management')
        ->join('users', 'leave_management.user_ref_id', '=', 'users.id')
        ->selectRaw("
            users.id as user_id,
            users.username as user_name,
            SUM(leave_management.credit_leave) AS total_credit_leave,
            SUM(leave_management.taken_leave) AS total_taken_leave,
            ROUND(SUM(leave_management.credit_leave), 1) AS credit_days,
            ROUND(SUM(leave_management.taken_leave), 1) AS taken_days,
            ROUND((SUM(leave_management.credit_leave) - SUM(leave_management.taken_leave)), 1) AS balance_days
        ")
        ->where('leave_management.l_isdeleted', 0)
        ->where('users.id', Auth::id()) // 🔒 Authenticated user only
        ->whereBetween('leave_management.date', [$startDate, $endDate])
        ->groupBy('users.id', 'users.username')
        ->get();

    // 5. Return data as JSON
    return response()->json([
        'status' => 'success',
        'data' => $leaveBalance
    ]);
}

   
public function lmcreate()
{
    // Store session user data when creating a leave entry
    if (Auth::check()) {
        session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
    }

        $user = User::all(); 
        return view('Leave_Management.add', compact('user'));  
    }

    public function lmstore(Request $request)
    {
        if (Auth::check()) {
            session([
                'user_id' => Auth::user()->id,
                'username' => Auth::user()->username
            ]);
        }

        // Validate the request
        $request->validate([
            'user_ids' => 'required|string',
            'leave_type' => 'required|in:credit,casual,sick',
            'leave_days' => 'required|integer|min:1|max:30',
            'credit_date' => 'required|date'
        ]);

        $leaveType = $request->leave_type;
        $leaveDays = (int) $request->leave_days;
        $creditDate = $request->credit_date;
        
        // Parse comma-separated user IDs
        $userIds = array_filter(explode(',', $request->user_ids));
        
        // Validate that all user IDs exist
        $existingUserIds = User::whereIn('id', $userIds)->pluck('id')->toArray();
        if (count($userIds) !== count($existingUserIds)) {
            \Log::error('User validation failed:', [
                'requested_ids' => $userIds,
                'existing_ids' => $existingUserIds
            ]);
            $notification = [
                'message' => 'One or more selected users do not exist.',
                'alert-type' => 'error'
            ];
            return redirect()->route('add.leaveManagement')->with($notification);
        }

        DB::beginTransaction();
        try {
            foreach ($userIds as $userId) {
                // Get the latest leave balance for this user
                $latestBalance = LeaveManagement::where('user_ref_id', $userId)
                    ->orderByDesc('id')
                    ->first();

                // Initialize default values
                $creditLeave = $latestBalance ? $latestBalance->credit_leave : 0;
                $casualLeave = $latestBalance ? $latestBalance->casual_leave : 0;
                $sickLeave = $latestBalance ? $latestBalance->sick_leave : 1; // Default 1 day SL
                $permission = $latestBalance ? $latestBalance->permission : 0;

                // Add the credited leave based on type
                switch ($leaveType) {
                    case 'credit':
                        $creditLeave += $leaveDays;
                        break;
                    case 'casual':
                        $casualLeave += $leaveDays;
                        break;
                    case 'sick':
                        $sickLeave += $leaveDays;
                        break;
                }

                // Create new leave management record
                LeaveManagement::create([
                    'user_ref_id' => $userId,
                    'date' => $creditDate,
                    'taken_leave' => 0,
                    'credit_leave' => $creditLeave,
                    'casual_leave' => $casualLeave,
                    'sick_leave' => $sickLeave,
                    'permission' => $permission,
                    'l_status' => 0,
                    'l_isdeleted' => 0,
                ]);
            }

            DB::commit();

            $leaveTypeName = ucfirst($leaveType) . ($leaveType === 'casual' ? ' Leave (CL)' : ($leaveType === 'sick' ? ' Leave (SL)' : ' Leave'));
            $notification = [
                'message' => "Successfully credited {$leaveDays} day(s) of {$leaveTypeName} to " . count($userIds) . " user(s)",
                'alert-type' => 'success'
            ];

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Credit Leave Error: ' . $e->getMessage());
            
            $notification = [
                'message' => 'Error occurred while crediting leave. Please try again.',
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('add.leaveManagement')->with($notification);
    }
   public function fetchLeaveBalance(Request $request)
    {
        // Latest balance per user (current snapshot)
        $latestPerUser = DB::table('leave_management as lm1')
            ->selectRaw('MAX(lm1.id) as max_id')
            ->where('lm1.l_isdeleted', 0)
            ->groupBy('lm1.user_ref_id');

        $rows = DB::table('leave_management as lm')
            ->joinSub($latestPerUser, 't', function ($join) {
                $join->on('lm.id', '=', 't.max_id');
            })
            ->join('users', 'users.id', '=', 'lm.user_ref_id')
            ->selectRaw('
                users.id   as user_id,
                COALESCE(users.name, users.username, users.email) as user_name,
                COALESCE(lm.credit_leave,0) as credit_days,
                COALESCE(lm.casual_leave,0) as casual_days,
                COALESCE(lm.sick_leave,0)   as sick_days
            ')
            ->orderBy('users.name')
            ->get();

        $data = $rows->map(function ($r) {
            $creditDays = round($r->credit_hours, 2); // Already in days
            $casualDays = round($r->casual_hours, 2); // Already in days
            $sickDays   = round($r->sick_hours, 2);   // Already in days
            $totalDays  = round($r->credit_hours + $r->casual_hours + $r->sick_hours, 2);

            return [
                'user_id'      => $r->user_id,
                'user_name'    => $r->user_name,
                'credit_days'  => $creditDays,
                'casual_days'  => $casualDays,
                'sick_days'    => $sickDays,
                'total_days'   => $totalDays,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }
public function showLeaveBalance(Request $request)
{
    // 1. Fetch all users for dropdown
    $users = DB::table('users')
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

    $year = (int)($request->input('year') ?: now()->year);

    // -------------------------
    // BALANCE LEAVE (Latest CL/SL only)
    // -------------------------
    $latestPerUser = DB::table('leave_management as lm1')
        ->selectRaw('MAX(lm1.id) as max_id')
        ->where('lm1.l_isdeleted', 0)
        ->groupBy('lm1.user_ref_id');

    $balanceLeaves = DB::table('leave_management as lm')
        ->joinSub($latestPerUser, 't', function ($join) {
            $join->on('lm.id', '=', 't.max_id');
        })
        ->join('users', 'users.id', '=', 'lm.user_ref_id')
        ->selectRaw('
            users.id as user_id,
            users.name as user_name,
            YEAR(lm.date) as year,
            MONTH(lm.date) as month,
            lm.casual_leave,
            lm.sick_leave,
            (lm.casual_leave + lm.sick_leave) as balance_leave
        ')
        ->when($request->filled('user_id'), function ($q) use ($request) {
            $q->where('users.id', $request->user_id);
        })
        ->whereYear('lm.date', $year)
        ->get();

    // -------------------------
    // TAKEN LEAVE (month-wise summary)
    // -------------------------
    $takenLeaves = DB::table('leave_management as lm')
        ->join('users', 'users.id', '=', 'lm.user_ref_id')
        ->selectRaw('
            users.id as user_id,
            users.name as user_name,
            YEAR(lm.date) as year,
            MONTH(lm.date) as month,
            SUM(lm.taken_leave)/8 as taken_leave,
            SUM(lm.l_status)/8 as lop
        ')
        ->where('lm.l_isdeleted', 0)
        ->groupBy('users.id', 'users.name', DB::raw('YEAR(lm.date)'), DB::raw('MONTH(lm.date)'))
        ->when($request->filled('user_id'), function ($q) use ($request) {
            $q->where('users.id', $request->user_id);
        })
        ->whereYear('lm.date', $year)
        ->orderBy('users.name')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    // Pass to view
    return view('leave.leave_balance', compact('users', 'balanceLeaves', 'takenLeaves', 'year'));
}


}
