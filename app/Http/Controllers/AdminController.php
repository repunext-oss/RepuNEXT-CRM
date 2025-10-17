<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Tasktimesheet;
use App\Models\Role;
use App\Models\GoalTask;
use App\Models\Timesheet;
use App\Models\LeaveManagement;
use App\Models\Leave;
use App\Models\SupportCallCenter;
use App\Models\Revenue;
use App\Models\Expense;
use App\Models\Booking;
use App\Models\Intern;
use App\Models\Availability;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function dashboard(Request $request)
    {
        $users = User::all();
        $goals = GoalTask::all();
        $support = SupportCallCenter::all();
        $filter = $request->get('filter', 'daily');
        $userId = $request->get('user_id') ?? null;
        $dateRange = $request->get('date_range') ?? null;
        $serv = Timesheet::all();
        $leaveSummary= Leave::all();
        
        // Financial Data
        $currentMonth = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        
        $monthlyRevenue = Revenue::whereBetween('created_at', [$currentMonth, $currentMonthEnd])
            ->sum('amount');
            
        $monthlyExpense = Expense::whereBetween('created_at', [$currentMonth, $currentMonthEnd])
            ->sum('amount');

        $monthlyIntern = Intern::where('i_isdeleted', '!=', 1)
            ->whereBetween('created_at', [$currentMonth, $currentMonthEnd])
            ->sum('Amount');
            
        $monthlyProfit = $monthlyRevenue - $monthlyExpense;
        $totalInternPaid=Intern::where('i_isdeleted', '!=', 1)->sum('amount');
        $totalRevenue = Revenue::sum('amount');
        $totalExpense = Expense::sum('amount');
        $totalProfit = $totalRevenue - $totalExpense;
        $Final = $totalRevenue + $totalInternPaid;
        $MonthlyFinal = $monthlyRevenue+ $monthlyIntern;

        // Studio Booking Data
        $todayBookings = Booking::whereDate('start', Carbon::today())->count();
        $thisWeekBookings = Booking::whereBetween('start', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $thisMonthBookings = Booking::whereBetween('start', [$currentMonth, $currentMonthEnd])->count();
        $totalBookings = Booking::count();
        
        // Person Availability Data
        $activeAvailabilities = Availability::where('is_active', true)->count();
        $todayAvailableUsers = Availability::where('is_active', true)
            ->where('is_available', true)
            ->where('day_of_week', Carbon::today()->format('l'))
            ->count();
        $thisWeekAvailableUsers = Availability::where('is_active', true)
            ->where('is_available', true)
            ->count();
    
        if($dateRange && str_contains($dateRange, ' to ')) {
            $dates = explode(' to ', $dateRange);
            $startDate = Carbon::parse($dates[0]);
            $endDate = isset($dates[1]) ? Carbon::parse($dates[1]) : $startDate;
        } elseif ($dateRange) {
            $startDate = Carbon::parse($dateRange);
            $endDate = $startDate;
        } else {
            switch ($filter) {
                case 'weekly':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    break;
                case 'monthly':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    break;
                default:
                    $startDate = Carbon::today();
                    $endDate = Carbon::today();
            }
        }
    
        $t = Tasktimesheet::whereDate('created_at', '>=', $startDate)
                          ->whereDate('created_at', '<=', $endDate);
    
        if ($userId) {
            $t->where('tc_name', $userId);
        }
    
        $time = $t->get();
    
        $categoryData = [];
        foreach ($time as $entry) {
            $start = Carbon::parse($entry->tt_starttime);
            $end = Carbon::parse($entry->tt_endtime);
            $diffInMinutes = $start->diffInMinutes($end);
    
            $catIds = explode(',', $entry->tt_cat);
            foreach ($serv as $s) {
                if (in_array($s->id, $catIds)) {
                    if (!isset($categoryData[$s->tc_name])) {
                        $categoryData[$s->tc_name] = 0;
                    }
                    $categoryData[$s->tc_name] += $diffInMinutes;
                }
            }
        }
    
        if ($request->ajax()) {
            try {
                $html = View::make('admin.dashboard_partial', compact(
                    'users', 'goals', 'time', 'filter', 'dateRange', 'userId', 'serv', 'categoryData'
                ))->render();
        
                return response()->json(['html' => $html]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
        }

        $leaveSummary = LeaveManagement::where('l_isdeleted', 0)
        ->whereNotIn('taken_leave', [0.25, 2]) 
        ->join('users', 'leave_management.user_ref_id', '=', 'users.id')
        ->selectRaw('users.username as user_name, YEAR(date) as year, MONTH(date) as month, SUM(taken_leave) as total_taken_leave')
        ->groupBy('users.username', 'year', 'month')
        ->orderBy('year', 'ASC')
        ->orderBy('month', 'DESC')
        ->get();
        
        return view('admin.index', compact(
            'users', 'goals', 'time', 'filter', 'dateRange', 'userId', 'serv', 'categoryData','leaveSummary','support',
            'monthlyRevenue', 'monthlyExpense', 'monthlyProfit','monthlyIntern', 'totalRevenue', 'totalExpense', 'Final','totalProfit',
            'todayBookings', 'thisWeekBookings', 'thisMonthBookings', 'totalBookings','MonthlyFinal',
            'activeAvailabilities', 'todayAvailableUsers', 'thisWeekAvailableUsers'
        ));
    }
    
    
    
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'User Logout Successf',  
        );
        return redirect('/login')->with($notification);
    } // End Function

    public function Profile(){
        $id=Auth::user()->id;
        $adminData=User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));
    } // End Function

    public function EditProfile(){  
        $id=Auth::user()->id;
        $editData=User::find($id);
        return view('admin.admin_profile_edit',compact('editData'));
    } // End Function

    public function StoreProfile(Request $request){
        $id=Auth::user()->id; 
        $data=User::find($id);
        $data->name =$request->name;
        $data->phone =$request->phone;
        $data->honorific =$request->honorific;
        if($request->file('profile_image')){
            $file = $request->file('profile_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin-images'),$filename);
            $data['profile_image']=$filename;
        }
        $data->save();
        $notification = array(
            'message' => 'Admin Profile updated Successfully',
            'alert-type' => 'info'
            );
        return redirect()->route('admin.profile')->with($notification);
    } // End Function

    public function rolelist(){
        // $roles  =   DB::table('roles')->get();
        $roles  =   Role::all();
        return view('admin.role_list',compact('roles'));
    }  // End Function

    public function Storerolelist(Request $request){
        $id=Auth::user()->id;
        // $input = $request->all();
        if (!empty($request->kt_roles_select_all)){
            $input=trim($request->kt_roles_select_all);
        }else{
            $kt_roles_select_all=trim($request->kt_roles_select_all);
            $role_name =trim($request->role_name);
            $user_management_all=trim($request->user_management_all);
            $user_management_read=trim($request->user_management_read);
            $user_management_write=trim($request->user_management_write);
            $user_management_create =trim($request->user_management_create);
            $user_management_delete  =trim($request->user_management_delete);

            $role_management_all=trim($request->role_management_all);
            $role_management_read=trim($request->role_management_read);
            $role_management_write=trim($request->role_management_write);
            $role_management_create=trim($request->role_management_create);
            $role_management_delete=trim($request->role_management_delete);

            $enquiry_All=trim($request->enquiry_All);
            $enquiry_read=trim($request->enquiry_read);
            $enquiry_write=trim($request->enquiry_write);
            $enquiry_create=trim($request->enquiry_create);
            $enquiry_delete=trim($request->enquiry_delete);

            $followup_All=trim($request->followup_All);
            $followup_read=trim($request->followup_read);
            $followup_write=trim($request->followup_write);
            $followup_create=trim($request->followup_create);
            $followup_delete=trim($request->followup_delete);

            $leave_All=trim($request->leave_All);
            $leave_read=trim($request->leave_read);
            $leave_write=trim($request->leave_write);
            $leave_create=trim($request->leave_create);
            $leave_delete=trim($request->leave_delete);

            $service_all=trim($request->service_all);
            $service_read=trim($request->service_read);
            $service_write=trim($request->service_write);
            $service_create=trim($request->service_create);
            $service_delete=trim($request->service_delete);

            $project_all=trim($request->project_all);
            $project_read=trim($request->project_read);
            $project_write=trim($request->project_write);
            $project_create=trim($request->project_create);
            $project_delete=trim($request->project_delete);

            $timesheet_all=trim($request->timesheet_all);
            $timesheet_read=trim($request->timesheet_read);
            $timesheet_write=trim($request->timesheet_write);
            $timesheet_create=trim($request->timesheet_create);
            $timesheet_delete=trim($request->timesheet_delete);

            $task_timesheet_all=trim($request->task_timesheet_all);
            $task_timesheet_read=trim($request->task_timesheet_read);
            $task_timesheet_write=trim($request->task_timesheet_write);
            $task_timesheet_create=trim($request->task_timesheet_create);
            $task_timesheet_delete=trim($request->task_timesheet_delete);

            $host_all=trim($request->host_all);
            $host_read=trim($request->host_read);
            $host_write=trim($request->host_write);
            $host_create=trim($request->host_create);
            $host_delete=trim($request->host_delete);

            $domain_all=trim($request->domain_all);
            $domain_read=trim($request->domain_read);
            $domain_write=trim($request->domain_write);
            $domain_create=trim($request->domain_create);
            $domain_delete=trim($request->domain_delete);

            $subdomain_all=trim($request->subdomain_all);
            $subdomain_read=trim($request->subdomain_read);
            $subdomain_write=trim($request->subdomain_write);
            $subdomain_create=trim($request->subdomain_create);
            $subdomain_delete=trim($request->subdomain_delete);

            $domain_type_all=trim($request->domain_type_all);
            $domain_type_read=trim($request->domain_type_read);
            $domain_type_write=trim($request->domain_type_write);
            $domain_type_create=trim($request->domain_type_create);
            $domain_type_delete=trim($request->domain_type_delete);
            
            $tool_all=trim($request->tool_all);
            $tool_read=trim($request->tool_read);
            $tool_write=trim($request->tool_write);
            $tool_create=trim($request->tool_create);
            $tool_delete=trim($request->tool_delete);

            $toolc_all=trim($request->toolc_all);
            $toolc_read=trim($request->toolc_read);
            $toolc_write=trim($request->toolc_write);
            $toolc_create=trim($request->toolc_create);
            $toolc_delete=trim($request->toolc_delete);

            $timesheet_category_all=trim($request->timesheet_category_all);
            $timesheet_category_read=trim($request->timesheet_category_read);
            $timesheet_category_write=trim($request->timesheet_category_write);
            $timesheet_category_create=trim($request->timesheet_category_create);
            $timesheet_category_delete=trim($request->timesheet_category_delete);

            $goalsheet_all=trim($request->goalsheet_all);
            $goalsheet_read=trim($request->goalsheet_read);
            $goalsheet_write=trim($request->goalsheet_write);
            $goalsheet_create=trim($request->goalsheet_create);
            $goalsheet_delete=trim($request->goalsheet_delete);

            $goalsheet_category_all=trim($request->goalsheet_category_all);
            $goalsheet_category_read=trim($request->goalsheet_category_read);
            $goalsheet_category_write=trim($request->goalsheet_category_write);
            $goalsheet_category_create=trim($request->goalsheet_category_create);
            $goalsheet_category_delete=trim($request->goalsheet_category_delete);

            $sm_all=trim($request->sm_all);
            $sm_read=trim($request->sm_read);
            $sm_write=trim($request->sm_write);
            $sm_create=trim($request->sm_create);
            $sm_delete=trim($request->sm_delete);

            $tool_domain_type_all=trim($request->tool_domain_type_all);
            $tool_domain_type_read=trim($request->tool_domain_type_read);
            $tool_domain_type_write=trim($request->tool_domain_type_write);
            $tool_domain_type_create=trim($request->tool_domain_type_create);
            $tool_domain_type_delete=trim($request->tool_domain_type_delete);

            $tvideo_all=trim($request->tvideo_all);
            $tvideo_read=trim($request->tvideo_read);
            $tvideo_write=trim($request->tvideo_write);
            $tvideo_create=trim($request->tvideo_create);
            $tvideo_delete=trim($request->tvideo_delete);

            $cvideo_all=trim($request->cvideo_all);
            $cvideo_read=trim($request->cvideo_read);
            $cvideo_write=trim($request->cvideo_write);
            $cvideo_create=trim($request->cvideo_create);
            $cvideo_delete=trim($request->cvideo_delete);

            $chat_all=trim($request->chat_all);
            $chat_read=trim($request->chat_read);
            $chat_write=trim($request->chat_write);
            $chat_create=trim($request->chat_create);
            $chat_delete=trim($request->chat_delete);

            $sale_all=trim($request->sale_all);
            $sale_read=trim($request->sale_read);
            $sale_write=trim($request->sale_write);
            $sale_create=trim($request->sale_create);
            $sale_delete=trim($request->sale_delete);
            
            $studio_booking_all=trim($request->studio_booking_all);
            $studio_booking_read=trim($request->studio_booking_read);
            $studio_booking_write=trim($request->studio_booking_write);
            $studio_booking_create=trim($request->studio_booking_create);
            $studio_booking_delete=trim($request->studio_booking_delete);

            $person_availability_all=trim($request->person_availability_all);
            $person_availability_read=trim($request->person_availability_read);
            $person_availability_write=trim($request->person_availability_write);
            $person_availability_create=trim($request->person_availability_create);
            $person_availability_delete=trim($request->person_availability_delete);

            $revenue_expense_all=trim($request->revenue_expense_all);
            $revenue_expense_read=trim($request->revenue_expense_read);
            $revenue_expense_write=trim($request->revenue_expense_write);
            $revenue_expense_create=trim($request->revenue_expense_create);
            $revenue_expense_delete=trim($request->revenue_expense_delete);

            $repunext_board_all=trim($request->repunext_board_all);
            $repunext_board_read=trim($request->repunext_board_read);
            $repunext_board_write=trim($request->repunext_board_write);
            $repunext_board_create=trim($request->repunext_board_create);
            $repunext_board_delete=trim($request->repunext_board_delete);

            $backlog_all=trim($request->backlog_all);
            $backlog_read=trim($request->backlog_read);
            $backlog_write=trim($request->backlog_write);
            $backlog_create=trim($request->backlog_create);
            $backlog_delete=trim($request->backlog_delete);

            $ai_all=trim($request->ai_all);
            $ai_read=trim($request->ai_read);
            $ai_write=trim($request->ai_write);
            $ai_create=trim($request->ai_create);
            $ai_delete=trim($request->ai_delete);

            $host_all=trim($request->host_all);
            $host_read=trim($request->host_read);
            $host_write=trim($request->host_write);
            $host_create=trim($request->host_create);
            $host_delete=trim($request->host_delete);


            $data = array(
                'user_management_all' => $user_management_all,
                'user_management_read' => $user_management_read,
                'user_management_write' => $user_management_write,  
                'user_management_create' => $user_management_create,
                'user_management_delete' => $user_management_delete,

                'role_management_all' => $role_management_all,
                'role_management_read' => $role_management_read,
                'role_management_write' => $role_management_write,
                'role_management_create' => $role_management_create,
                'role_management_delete' => $role_management_delete,

                'enquiry_All' => $enquiry_All,
                'enquiry_read' => $enquiry_read,
                'enquiry_write' => $enquiry_write,
                'enquiry_create' => $enquiry_create,
                'enquiry_delete' => $enquiry_delete,

                'followup_All' => $followup_All,
                'followup_read' => $followup_read,
                'followup_write' => $followup_write,
                'followup_create' => $followup_create,
                'followup_delete' => $followup_delete,

                'leave_All' => $leave_All,
                'leave_read' => $leave_read,
                'leave_write' => $leave_write,
                'leave_create' => $leave_create,
                'leave_delete' => $leave_delete,
                   
                'service_all' => $service_all,
                'service_read' => $service_read,
                'service_write' => $service_write,
                'service_create' => $service_create,
                'service_delete' => $service_delete,

                'project_all' => $project_all,
                'project_read' => $project_read,
                'project_write' => $project_write,
                'project_create' => $project_create,
                'project_delete' => $project_delete,

                
                'timesheet_all' => $timesheet_all,
                'timesheet_read' => $timesheet_read,
                'timesheet_write' => $timesheet_write,
                'timesheet_create' => $timesheet_create,
                'timesheet_delete' => $timesheet_delete,

                'task_timesheet_all' => $task_timesheet_all,
                'task_timesheet_read' => $task_timesheet_read,
                'task_timesheet_write' => $task_timesheet_write,
                'task_timesheet_create' => $task_timesheet_create,
                'task_timesheet_delete' => $task_timesheet_delete,

                'host_all' => $host_all,
                'host_read' => $host_read,
                'host_write' => $host_write,
                'host_create' => $host_create,
                'host_delete' => $host_delete,

                'domain_all' => $domain_all,
                'domain_read' => $domain_read,
                'domain_write' => $domain_write,
                'domain_create' => $domain_create,
                'domain_delete' => $domain_delete,

                'subdomain_all' => $subdomain_all,
                'subdomain_read' => $subdomain_read,
                'subdomain_write' => $subdomain_write,
                'subdomain_create' => $subdomain_create,
                'subdomain_delete' => $subdomain_delete,

                'domain_type_all' => $domain_type_all,
                'domain_type_read' => $domain_type_read,
                'domain_type_write' => $domain_type_write,
                'domain_type_create' => $domain_type_create,
                'domain_type_delete' => $domain_type_delete,

                'tool_all' => $tool_all,
                'tool_read' => $tool_read,
                'tool_write' => $tool_write,
                'tool_create' => $tool_create,
                'tool_delete' => $tool_delete,

                'toolc_all' => $toolc_all,
                'toolc_read' => $toolc_read,
                'toolc_write' => $toolc_write,
                'toolc_create' => $toolc_create,
                'toolc_delete' => $toolc_delete,

                'timesheet_category_all' => $timesheet_category_all,
                'timesheet_category_read' => $timesheet_category_read,
                'timesheet_category_write' => $timesheet_category_write,
                'timesheet_category_create' => $timesheet_category_create,
                'timesheet_category_delete' => $timesheet_category_delete,
 
                'goalsheet_all' => $goalsheet_all,
                'goalsheet_read' => $goalsheet_read,
                'goalsheet_write' => $goalsheet_write,
                'goalsheet_create' => $goalsheet_create,
                'goalsheet_delete' => $goalsheet_delete,
                
                'goalsheet_category_all' => $goalsheet_category_all,
                'goalsheet_category_read' => $goalsheet_category_read,
                'goalsheet_category_write' => $goalsheet_category_write,
                'goalsheet_category_create' => $goalsheet_category_create,
                'goalsheet_category_delete' => $goalsheet_category_delete,
                
                'sm_all' => $sm_all,
                'sm_read' => $sm_read,
                'sm_write' => $sm_write,
                'sm_create' => $sm_create,
                'sm_delete' => $sm_delete,
                
                'tool_domain_type_all' => $tool_domain_type_all,
                'tool_domain_type_read' => $tool_domain_type_read,
                'tool_domain_type_write' => $tool_domain_type_write,
                'tool_domain_type_create' => $tool_domain_type_create,
                'tool_domain_type_delete' => $tool_domain_type_delete,
                
                'tvideo_all' => $tvideo_all,
                'tvideo_read' => $tvideo_read,
                'tvideo_write' => $tvideo_write,
                'tvideo_create' => $tvideo_create,
                'tvideo_delete' => $tvideo_delete,
                
                'cvideo_all' => $cvideo_all,
                'cvideo_read' => $cvideo_read,
                'cvideo_write' => $cvideo_write,
                'cvideo_create' => $cvideo_create,
                'cvideo_delete' => $cvideo_delete,

                'chat_all' => $chat_all,
                'chat_read' => $chat_read,
                'chat_write' => $chat_write,
                'chat_create' => $chat_create,
                'chat_delete' => $chat_delete,
                
                'sale_all' => $sale_all,
                'sale_read' => $sale_read,
                'sale_write' => $sale_write,
                'sale_create' => $sale_create,
                'sale_delete' => $sale_delete,

                'studio_booking_all' => $studio_booking_all,
                'studio_booking_read' => $studio_booking_read,
                'studio_booking_write' => $studio_booking_write,
                'studio_booking_create' => $studio_booking_create,
                'studio_booking_delete' => $studio_booking_delete,

                'person_availability_all' => $person_availability_all,
                'person_availability_read' => $person_availability_read,
                'person_availability_write' => $person_availability_write,
                'person_availability_create' => $person_availability_create,
                'person_availability_delete' => $person_availability_delete,

                'revenue_expense_all' => $revenue_expense_all,
                'revenue_expense_read' => $revenue_expense_read,
                'revenue_expense_write' => $revenue_expense_write,
                'revenue_expense_create' => $revenue_expense_create,
                'revenue_expense_delete' => $revenue_expense_delete,

                'repunext_board_all' => $repunext_board_all,
                'repunext_board_read' => $repunext_board_read,
                'repunext_board_write' => $repunext_board_write,
                'repunext_board_create' => $repunext_board_create,
                'repunext_board_delete' => $repunext_board_delete,

                'backlog_all' => $backlog_all,
                'backlog_read' => $backlog_read,
                'backlog_write' => $backlog_write,
                'backlog_create' => $backlog_create,
                'backlog_delete' => $backlog_delete,

                 'ai_all' => $ai_all,
                'ai_read' => $ai_read,
                'ai_write' => $ai_write,
                'ai_create' => $ai_create,
                'ai_delete' => $ai_delete,

                'host_all' => $host_all,
                'host_read' => $host_read,
                'host_write' => $host_write,
                'host_create' => $host_create,
                'host_delete' => $host_delete,

              );
            $input =implode(",", $data);
        }
        $role = Role::create([
            'role_name' => $request->role_name,
            'role' => $input,
            'isdeleted' => "0",
        ]);
        $notification = array(
            'message' => 'Added New Role Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('list.role')->with($notification);
    } // End Function

    public function Updaterolelist(Request $request){
        $id=Auth::user()->id;
        // $input = $request->all();
        $role_id=$request->role_id;
        if (!empty($request->kt_roles_select_all)){
            $input=trim($request->kt_roles_select_all);
        }else{
            $kt_roles_select_all=trim($request->kt_roles_select_all);
            $role_name =trim($request->role_name);
            $user_management_all=trim($request->user_management_all);
            $user_management_read=trim($request->user_management_read);
            $user_management_write=trim($request->user_management_write);
            $user_management_create =trim($request->user_management_create);
            $user_management_delete  =trim($request->user_management_delete);

            $role_management_all=trim($request->role_management_all);
            $role_management_read=trim($request->role_management_read);
            $role_management_write=trim($request->role_management_write);
            $role_management_create=trim($request->role_management_create);
            $role_management_delete=trim($request->role_management_delete);

            $enquiry_all=trim($request->enquiry_all);
            $enquiry_read=trim($request->enquiry_read);
            $enquiry_write=trim($request->enquiry_write);
            $enquiry_create=trim($request->enquiry_create);
            $enquiry_delete=trim($request->enquiry_delete);

            $followup_all=trim($request->followup_all);
            $followup_read=trim($request->followup_read);
            $followup_write=trim($request->followup_write);
            $followup_create=trim($request->followup_create);
            $followup_delete=trim($request->followup_delete);

            $leave_all=trim($request->leave_all);
            $leave_read=trim($request->leave_read);
            $leave_write=trim($request->leave_write);
            $leave_create=trim($request->leave_create);
            $leave_delete=trim($request->leave_delete);

            $service_all=trim($request->service_all);
            $service_read=trim($request->service_read);
            $service_write=trim($request->service_write);
            $service_create=trim($request->service_create);
            $service_delete=trim($request->service_delete);

            $project_all=trim($request->project_all);
            $project_read=trim($request->project_read);
            $project_write=trim($request->project_write);
            $project_create=trim($request->project_create);
            $project_delete=trim($request->project_delete);

            $timesheet_all=trim($request->timesheet_all);
            $timesheet_read=trim($request->timesheet_read);
            $timesheet_write=trim($request->timesheet_write);
            $timesheet_create=trim($request->timesheet_create);
            $timesheet_delete=trim($request->timesheet_delete);

            $task_timesheet_all=trim($request->task_timesheet_all);
            $task_timesheet_read=trim($request->task_timesheet_read);
            $task_timesheet_write=trim($request->task_timesheet_write);
            $task_timesheet_create=trim($request->task_timesheet_create);
            $task_timesheet_delete=trim($request->task_timesheet_delete);

            $host_all=trim($request->host_all);
            $host_read=trim($request->host_read);
            $host_write=trim($request->host_write);
            $host_create=trim($request->host_create);
            $host_delete=trim($request->host_delete);

            $domain_all=trim($request->domain_all);
            $domain_read=trim($request->domain_read);
            $domain_write=trim($request->domain_write);
            $domain_create=trim($request->domain_create);
            $domain_delete=trim($request->domain_delete);

            $subdomain_all=trim($request->subdomain_all);
            $subdomain_read=trim($request->subdomain_read);
            $subdomain_write=trim($request->subdomain_write);
            $subdomain_create=trim($request->subdomain_create);
            $subdomain_delete=trim($request->subdomain_delete);

            $domain_type_all=trim($request->domain_type_all);
            $domain_type_read=trim($request->domain_type_read);
            $domain_type_write=trim($request->domain_type_write);
            $domain_type_create=trim($request->domain_type_create);
            $domain_type_delete=trim($request->domain_type_delete);
            
            $tool_all=trim($request->tool_all);
            $tool_read=trim($request->tool_read);
            $tool_write=trim($request->tool_write);
            $tool_create=trim($request->tool_create);
            $tool_delete=trim($request->tool_delete);

            $toolc_all=trim($request->toolc_all);
            $toolc_read=trim($request->toolc_read);
            $toolc_write=trim($request->toolc_write);
            $toolc_create=trim($request->toolc_create);
            $toolc_delete=trim($request->toolc_delete);

            $timesheet_category_all=trim($request->timesheet_category_all);
            $timesheet_category_read=trim($request->timesheet_category_read);
            $timesheet_category_write=trim($request->timesheet_category_write);
            $timesheet_category_create=trim($request->timesheet_category_create);
            $timesheet_category_delete=trim($request->timesheet_category_delete);

            $goalsheet_all=trim($request->goalsheet_all);
            $goalsheet_read=trim($request->goalsheet_read);
            $goalsheet_write=trim($request->goalsheet_write);
            $goalsheet_create=trim($request->goalsheet_create);
            $goalsheet_delete=trim($request->goalsheet_delete);

            $goalsheet_category_all=trim($request->goalsheet_category_all);
            $goalsheet_category_read=trim($request->goalsheet_category_read);
            $goalsheet_category_write=trim($request->goalsheet_category_write);
            $goalsheet_category_create=trim($request->goalsheet_category_create);
            $goalsheet_category_delete=trim($request->goalsheet_category_delete);

            $sm_all=trim($request->sm_all);
            $sm_read=trim($request->sm_read);
            $sm_write=trim($request->sm_write);
            $sm_create=trim($request->sm_create);
            $sm_delete=trim($request->sm_delete);

            $tool_domain_type_all=trim($request->tool_domain_type_all);
            $tool_domain_type_read=trim($request->tool_domain_type_read);
            $tool_domain_type_write=trim($request->tool_domain_type_write);
            $tool_domain_type_create=trim($request->tool_domain_type_create);
            $tool_domain_type_delete=trim($request->tool_domain_type_delete);

            $tvideo_all=trim($request->tvideo_all);
            $tvideo_read=trim($request->tvideo_read);
            $tvideo_write=trim($request->tvideo_write);
            $tvideo_create=trim($request->tvideo_create);
            $tvideo_delete=trim($request->tvideo_delete);

            $cvideo_all=trim($request->cvideo_all);
            $cvideo_read=trim($request->cvideo_read);
            $cvideo_write=trim($request->cvideo_write);
            $cvideo_create=trim($request->cvideo_create);
            $cvideo_delete=trim($request->cvideo_delete);

            $chat_all=trim($request->chat_all);
            $chat_read=trim($request->chat_read);
            $chat_write=trim($request->chat_write);
            $chat_create=trim($request->chat_create);
            $chat_delete=trim($request->chat_delete);

            $sale_all=trim($request->sale_all);
            $sale_read=trim($request->sale_read);
            $sale_write=trim($request->sale_write);
            $sale_create=trim($request->sale_create);
            $sale_delete=trim($request->sale_delete);

            $studio_booking_all=trim($request->studio_booking_all);
            $studio_booking_read=trim($request->studio_booking_read);
            $studio_booking_write=trim($request->studio_booking_write);
            $studio_booking_create=trim($request->studio_booking_create);
            $studio_booking_delete=trim($request->studio_booking_delete);

            $person_availability_all=trim($request->person_availability_all);
            $person_availability_read=trim($request->person_availability_read);
            $person_availability_write=trim($request->person_availability_write);
            $person_availability_create=trim($request->person_availability_create);
            $person_availability_delete=trim($request->person_availability_delete);

            $revenue_expense_all=trim($request->revenue_expense_all);
            $revenue_expense_read=trim($request->revenue_expense_read);
            $revenue_expense_write=trim($request->revenue_expense_write);
            $revenue_expense_create=trim($request->revenue_expense_create);
            $revenue_expense_delete=trim($request->revenue_expense_delete);

            $repunext_board_all=trim($request->repunext_board_all);
            $repunext_board_read=trim($request->repunext_board_read);
            $repunext_board_write=trim($request->repunext_board_write);
            $repunext_board_create=trim($request->repunext_board_create);
            $repunext_board_delete=trim($request->repunext_board_delete);

            $backlog_all=trim($request->backlog_all);
            $backlog_read=trim($request->backlog_read);
            $backlog_write=trim($request->backlog_write);
            $backlog_create=trim($request->backlog_create);
            $backlog_delete=trim($request->backlog_delete);

            $ai_all=trim($request->ai_all);
            $ai_read=trim($request->ai_read);
            $ai_write=trim($request->ai_write);
            $ai_create=trim($request->ai_create);
            $ai_delete=trim($request->ai_delete);

            $host_all=trim($request->host_all);
            $host_read=trim($request->host_read);
            $host_write=trim($request->host_write);
            $host_create=trim($request->host_create);
            $host_delete=trim($request->host_delete);



            $data = array(

                'user_management_all' => $user_management_all,
                'user_management_read' => $user_management_read,
                'user_management_write' => $user_management_write,  
                'user_management_create' => $user_management_create,
                'user_management_delete' => $user_management_delete,

                'role_management_all' => $role_management_all,
                'role_management_read' => $role_management_read,
                'role_management_write' => $role_management_write,
                'role_management_create' => $role_management_create,
                'role_management_delete' => $role_management_delete,

                'enquiry_all' => $enquiry_all,
                'enquiry_read' => $enquiry_read,
                'enquiry_write' => $enquiry_write,
                'enquiry_create' => $enquiry_create,
                'enquiry_delete' => $enquiry_delete,

                
                'followup_all' => $followup_all,
                'followup_read' => $followup_read,
                'followup_write' => $followup_write,
                'followup_create' => $followup_create,
                'followup_delete' => $followup_delete,

                'leave_all' => $leave_all,
                'leave_read' => $leave_read,
                'leave_write' => $leave_write,
                'leave_create' => $leave_create,
                'leave_delete' => $leave_delete,
                   
                'service_all' => $service_all,
                'service_read' => $service_read,
                'service_write' => $service_write,
                'service_create' => $service_create,
                'service_delete' => $service_delete,

                'project_all' => $project_all,
                'project_read' => $project_read,
                'project_write' => $project_write,
                'project_create' => $project_create,
                'project_delete' => $project_delete,

                
                'timesheet_all' => $timesheet_all,
                'timesheet_read' => $timesheet_read,
                'timesheet_write' => $timesheet_write,
                'timesheet_create' => $timesheet_create,
                'timesheet_delete' => $timesheet_delete,

                'task_timesheet_all' => $task_timesheet_all,
                'task_timesheet_read' => $task_timesheet_read,
                'task_timesheet_write' => $task_timesheet_write,
                'task_timesheet_create' => $task_timesheet_create,
                'task_timesheet_delete' => $task_timesheet_delete,

                'host_all' => $host_all,
                'host_read' => $host_read,
                'host_write' => $host_write,
                'host_create' => $host_create,
                'host_delete' => $host_delete,

                'domain_all' => $domain_all,
                'domain_read' => $domain_read,
                'domain_write' => $domain_write,
                'domain_create' => $domain_create,
                'domain_delete' => $domain_delete,

                'subdomain_all' => $subdomain_all,
                'subdomain_read' => $subdomain_read,
                'subdomain_write' => $subdomain_write,
                'subdomain_create' => $subdomain_create,
                'subdomain_delete' => $subdomain_delete,

                'domain_type_all' => $domain_type_all,
                'domain_type_read' => $domain_type_read,
                'domain_type_write' => $domain_type_write,
                'domain_type_create' => $domain_type_create,
                'domain_type_delete' => $domain_type_delete,

                'tool_all' => $tool_all,
                'tool_read' => $tool_read,
                'tool_write' => $tool_write,
                'tool_create' => $tool_create,
                'tool_delete' => $tool_delete,

                'toolc_all' => $toolc_all,
                'toolc_read' => $toolc_read,
                'toolc_write' => $toolc_write,
                'toolc_create' => $toolc_create,
                'toolc_delete' => $toolc_delete,

                'timesheet_category_all' => $timesheet_category_all,
                'timesheet_category_read' => $timesheet_category_read,
                'timesheet_category_write' => $timesheet_category_write,
                'timesheet_category_create' => $timesheet_category_create,
                'timesheet_category_delete' => $timesheet_category_delete,
 
                'goalsheet_all' => $goalsheet_all,
                'goalsheet_read' => $goalsheet_read,
                'goalsheet_write' => $goalsheet_write,
                'goalsheet_create' => $goalsheet_create,
                'goalsheet_delete' => $goalsheet_delete,
                
                'goalsheet_category_all' => $goalsheet_category_all,
                'goalsheet_category_read' => $goalsheet_category_read,
                'goalsheet_category_write' => $goalsheet_category_write,
                'goalsheet_category_create' => $goalsheet_category_create,
                'goalsheet_category_delete' => $goalsheet_category_delete,
                
                'sm_all' => $sm_all,
                'sm_read' => $sm_read,
                'sm_write' => $sm_write,
                'sm_create' => $sm_create,
                'sm_delete' => $sm_delete,
                
                'tool_domain_type_all' => $tool_domain_type_all,
                'tool_domain_type_read' => $tool_domain_type_read,
                'tool_domain_type_write' => $tool_domain_type_write,
                'tool_domain_type_create' => $tool_domain_type_create,
                'tool_domain_type_delete' => $tool_domain_type_delete,
                
                'tvideo_all' => $tvideo_all,
                'tvideo_read' => $tvideo_read,
                'tvideo_write' => $tvideo_write,
                'tvideo_create' => $tvideo_create,
                'tvideo_delete' => $tvideo_delete,
                
                'cvideo_all' => $cvideo_all,
                'cvideo_read' => $cvideo_read,
                'cvideo_write' => $cvideo_write,
                'cvideo_create' => $cvideo_create,
                'cvideo_delete' => $cvideo_delete,

                'chat_all' => $chat_all,
                'chat_read' => $chat_read,
                'chat_write' => $chat_write,
                'chat_create' => $chat_create,
                'chat_delete' => $chat_delete,

                'sale_all' => $sale_all,
                'sale_read' => $sale_read,
                'sale_write' => $sale_write,
                'sale_create' => $sale_create,
                'sale_delete' => $sale_delete,

                'studio_booking_all' => $studio_booking_all,
                'studio_booking_read' => $studio_booking_read,
                'studio_booking_write' => $studio_booking_write,
                'studio_booking_create' => $studio_booking_create,
                'studio_booking_delete' => $studio_booking_delete,

                'person_availability_all' => $person_availability_all,
                'person_availability_read' => $person_availability_read,
                'person_availability_write' => $person_availability_write,
                'person_availability_create' => $person_availability_create,
                'person_availability_delete' => $person_availability_delete,

                'revenue_expense_all' => $revenue_expense_all,
                'revenue_expense_read' => $revenue_expense_read,
                'revenue_expense_write' => $revenue_expense_write,
                'revenue_expense_create' => $revenue_expense_create,
                'revenue_expense_delete' => $revenue_expense_delete,

                'repunext_board_all' => $repunext_board_all,
                'repunext_board_read' => $repunext_board_read,
                'repunext_board_write' => $repunext_board_write,
                'repunext_board_create' => $repunext_board_create,
                'repunext_board_delete' => $repunext_board_delete,

                'backlog_all' => $backlog_all,
                'backlog_read' => $backlog_read,
                'backlog_write' => $backlog_write,
                'backlog_create' => $backlog_create,
                'backlog_delete' => $backlog_delete,

                'ai_all' => $ai_all,
                'ai_read' => $ai_read,
                'ai_write' => $ai_write,
                'ai_create' => $ai_create,
                'ai_delete' => $ai_delete,

                'host_all' => $host_all,
                'host_read' => $host_read,
                'host_write' => $host_write,
                'host_create' => $host_create,
                'host_delete' => $host_delete,

              );
            $input =implode(",", $data);
        }
        $role=Role::where('id',$role_id);
        $role->update(['role'=>$input]);
        $notification = array(
            'message' => 'Role are Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('list.role')->with($notification);
    } // End Function


    public function Deleterolelist(Request $request){
        $id =$request->id;
        $roleresult=Role::where('id',$id);
        $roleresult->delete();
        $notification = array(
            'message' => 'A role is deleted Successfully',
            'alert-type' => 'warning'
            );
        return redirect()->route('list.role')->with($notification);
    }  // End Function

    public function Deleteuserlist(Request $request){
        $id =$request->id;
        $userresult=User::where('id',$id)->update(['isdeleted' => 1]);
        $notification = array(
            'message' => 'A user is deleted Successfully',
            'alert-type' => 'warning'
            );
        return redirect()->route('list.user')->with($notification);
    }  // End Function

   public function Editrolelist(Request $request){
        $id =$request->id;
        $editrole = DB::table('roles')->get()->where('id',$id);
        return view('admin.role_edit',compact('editrole'));
    }  // End Function

    public function roleview(){
        return view('admin.role_view');
    }  // End Function

    public function UpdateEmail(Request $request){
        $id=Auth::user()->id;
        $editData= DB::table('users')
                    ->where('id',$id)
                    ->first();
        $existing_password = $editData->password;
        $email = $request->email;
        if(Hash::check($request->password, $editData->password)){
            User::where('id', $id)->update(['email' => $email]);
            $notification = array(
                'message' => 'Email Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect('/edit/profile')->with($notification);
        }else{
            $notification = array(
                'message' => 'Wrong Password',
                'alert-type' => 'warning'
            );
            return redirect('/edit/profile')->with($notification);
        }

    }

    public function UpdatePassword(Request $request){
        $id=Auth::user()->id;
        $editData= DB::table('users')
                    ->where('id',$id)
                    ->first();
        $existing_password = $editData->password;
        $current_password = $request->currentpassword;
        $new_password = $request->newpassword;
        $confirm_password = $request->confirmpassword;
        if($new_password == $confirm_password){ 
            if(Hash::check($request->currentpassword, $editData->password)){
                User::where('id', $id)->update(['password' => Hash::make($request->newpassword)]);
                $notification = array(
                    'message' => 'Password Updated Successfully',
                    'alert-type' => 'success'
                );
                return redirect('/edit/profile')->with($notification);
            }else{
                $notification = array(
                    'message' => 'Current Password does not match!!',
                    'alert-type' => 'warning'
                );
                return redirect('/edit/profile')->with($notification);
            }
        }else{
            $notification = array(
                'message' => 'New password and Confirm password does not match!!',
                'alert-type' => 'warning'
            );
            return redirect('/edit/profile')->with($notification);
        }
    }
    public function adduser(){
        $usersdetails   =   DB::table('users')->get()->where('isdeleted',0);
        $roledetails    =   DB::table('roles')->get();
        return view('admin.user_add',compact('usersdetails','roledetails'));
    }
    public function edituser($id) {

        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            return redirect()->route('list.user')->with('error', 'User not found.');
        }

        $roledetails = DB::table('roles')->get();
        return view('admin.user_edit', compact('user', 'roledetails'));
    }
    public function updateuser(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|digits:10',
            'role' => 'required',
            'status' => 'required|integer',
        ]);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => $request->status,
            'updated_at' => now(),
        ];
    
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/profile-images'), $imageName);
            $updateData['profile_image'] = $imageName;
        }
    
        DB::table('users')->where('id', $id)->update($updateData);
        return redirect()->route('list.user')->with('success', 'User updated successfully.');
    }
    
    
    public function userlist(){
        $usersdetails = DB::table('users')->get()->where('isdeleted',0);
        $roledetails = DB::table('roles')->get();
        return view('admin.user_list',compact('usersdetails','roledetails'));
    }  // End Function

    public function Storeuserlist(Request $request){ 
        if ($request->hasFile('profile_image')) {
            $file       = $request->file('profile_image');
            $filename   = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin-images'), $filename);
        } else {
            $filename = 'default.jpg';
        } 
        $userresult = User::create(array_merge($request->all(), 
                                    [   'password' => Hash::make($request->password),
                                        'profile_image' => $filename,
                                        'isdeleted' => 0,
                                        'status' => 0 ])); 
        if($userresult){ 
            $notification = array(  'message'       => 'User Profile is created Successfully',
                                    'alert-type'    => 'success'    );
            return redirect()->route('list.user')->with($notification);
        }
    }
    public function UserUpdate(Request $request)
    {
        $usersdetails           =   User::find($request->id);
        $usersdetails->name     =   $request->name;  
        $usersdetails->email    =   $request->email;
        $usersdetails->phone    =   $request->phone;
        $usersdetails->username =   $request->username;
        $usersdetails->role     =   $request->role;
        if($request->file('profile_image')){ 
            $file       =   $request->file('profile_image');
            $filename   =   date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin-images'),$filename);
            $usersdetails['profile_image']  =   $filename;
        }
        $usersdetails->save();   
        if($usersdetails){
            $notification = array(  'message'    => 'User details Updated Successfully',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.user')->with($notification);
        }else{
            $notification = array(  'message'       => 'Something went wrong, Please try again!!',
                                    'alert-type'    => 'warning' );
            return redirect()->route('list.user')->with($notification);
        }
    }
    public function UserEdit($id)
    {
        $usersdetails   =   User::find($id);
        $roledetails    =   DB::table('roles')->get();
        return view('admin.user_edit', compact('usersdetails','roledetails'));
    }
    public function status(Request $request)
    { 
        $userdetails                 =   User::find($request->id);  
        $userdetails  ->status    =   $request->statusval;
        $userdetails  ->save();     
        return redirect()->route('list.user')->with('success','state has been status successfully');
    }


    public function destroys($id)
    {
        $usersdetails                   =   User::find($id);
        $usersdetails->isdeleted     =   "1";
        $usersdetails->save();     
        return redirect()->route('list.user')->with('success','state has been deleted successfully');
    }
}
