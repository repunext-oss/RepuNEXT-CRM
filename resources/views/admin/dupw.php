@extends('admin.admin_master')

@section('admin')
<style>
.professional-table {
    border-collapse: separate;
    border-spacing: 0 10px;
    width: 100%;
}

.professional-table thead {
    background: #f7f9fc;
    border-radius: 8px;
}

.professional-table thead th {
    padding: 14px;
    font-size: 14px;
    color: #4b5675;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none !important; /* removed */
    box-shadow: none !important; /* clean */
}

.professional-table tbody tr {
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease-in-out;
    border-radius: 8px;
}

.professional-table tbody tr:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.professional-table td {
    padding: 15px;
    vertical-align: middle;
    font-size: 13px;
    border: none !important; /* removed */
    box-shadow: none !important; /* clean */
}
.professional-table .badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
}

.toggle-desc {
    font-weight: 500;
    color: #1e40af;
    text-decoration: underline;
    cursor: pointer;
}

.toggle-desc:hover {
    color: #1e3a8a;
}

.task-desc {
    font-size: 12px;
   
}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div id="kt_content_container" class="container-xxl">
        <div class="row">
            <div class="col-xl-4">
                @php
                    $totalGoals = $goals->where('g_isdeleted', '!=', 1)->count();
                    $completedGoals = $goals->where('g_isdeleted', '!=', 1)->where('g_status', 'Completed')->count();
                    $pendingGoals = $goals->where('g_isdeleted', '!=', 1)->where('g_status', 'Pending')->count();
                    $notStartedGoals = $goals->where('g_isdeleted', '!=', 1)->where('g_status', 'New')->count();
                    $progressPercentage = $totalGoals > 0 ? round(($completedGoals / $totalGoals) * 100) : 0;
                @endphp 

                <div class="card p-4 card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 mb-5" style="background-color: #002244;">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalGoals }}
                    <a href="{{ route('add.gtask') }}">+
                    </a>
                    <div class="mt-4 d-flex justify-content gap-2">
                        
                        <span class="text-white opacity-50 pt-1 fw-semibold fs-6">Active Projects</span>
                        
                    </div>
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-50 w-100 mt-auto mb-2">
                            <span>{{ $totalGoals - $completedGoals }} Pending</span>
                            <span>{{ $progressPercentage }}%</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-light-danger rounded">
                            <div class="bg-danger rounded h-8px transition-width"
                                 role="progressbar"
                                 style="width: {{ $progressPercentage }}%;"
                                 aria-valuenow="{{ $progressPercentage }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card mb-5">
                    <div class="card-body pt-4 pb-4">
                        <div class="text-center mb-5">
                          <h6 class="text-gray-800 fs-5" style="font-weight: 700;">Project Status</h6>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-5 text-start">
                            <div>
                                <canvas id="goalStatusChart" width="140" height="140"></canvas>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <div class="d-flex fw-semibold align-items-center mb-2">
                                    <div class="bullet me-3 w-10px h-10px rounded-circle" style="background-color: #002D62;"></div>
                                    <div class="text-gray-700 fs-6">{{ $completedGoals }} Completed</div>
                                </div>
                                <div class="d-flex fw-semibold align-items-center mb-2">
                                    <div class="bullet me-3 w-10px h-10px rounded-circle" style="background-color: #0066b2;"></div>
                                    <div class="text-gray-700 fs-6">{{ $pendingGoals }} Pending</div>
                                </div>
                                <div class="d-flex fw-semibold align-items-center">
                                    <div class="bullet me-3 w-10px h-10px rounded-circle" style="background-color: #4B9CD3;"></div>
                                    <div class="text-gray-700 fs-6">{{ $notStartedGoals }} New</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .user-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
                    background: rgba(255,255,255,0.25);
                }
            </style>

              
            <div class="col-xl-5">
                @php
                    $userGoals = (Auth::user()->role === 'Admin')
                        ? $goals->where('g_isdeleted', '!=', 1)
                        : $goals->where('g_assigned', Auth::id())->where('g_isdeleted', '!=', 1);

                    $pendingCount = $userGoals->where('g_status', 'Pending')->count();
                    $newCount = $userGoals->where('g_status', 'New')->count();
                    $totalPendingNew = $pendingCount + $newCount;
                    $total = $goals->count();

                    $todayAssignedCount = $userGoals->where('created_at', '>=', \Carbon\Carbon::today())->count();
                    $todayPendingNewCount = $userGoals->filter(function ($goal) {
                        return in_array($goal->g_status, ['Pending', 'New']) && \Carbon\Carbon::parse($goal->created_at)->isToday();
                    })->count();

                    //this month task
                    $startOfMonth = Carbon\Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon\Carbon::now()->endOfMonth();

                    $thismonth = $userGoals->filter(function ($goal) use ($startOfMonth, $endOfMonth) {
                        return Carbon\Carbon::parse($goal->created_at)->between($startOfMonth, $endOfMonth);
                    })->count();
                    //this month pending task
                    $thisMonthPendingNew = $userGoals->filter(function ($goal) use ($startOfMonth, $endOfMonth) {
                        return \Carbon\Carbon::parse($goal->created_at)->between($startOfMonth, $endOfMonth)
                            && in_array($goal->g_status, ['Pending', 'New']);
                    })->count();

                    // This week task
                    $startOfWeek = Carbon\Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon\Carbon::now()->endOfWeek();

                    $thisweek = $userGoals->filter(function ($goal) use ($startOfWeek, $endOfWeek) {
                        return Carbon\Carbon::parse($goal->created_at)->between($startOfWeek, $endOfWeek);
                    })->count();

                    $thisWeekPendingNew = $userGoals->filter(function ($goal) use ($startOfWeek, $endOfWeek) {
                        return \Carbon\Carbon::parse($goal->created_at)->between($startOfWeek, $endOfWeek)
                            && in_array($goal->g_status, ['Pending', 'New']);
                    })->count();

                    $totalMinutes = 0;
                @endphp

                <div class="card border-0 shadow-sm mb-6" style="background: linear-gradient(to left,  #0072ff, #25396f);">
                    <div class="card-body text-white p-9">
                        <h1 class="fw-bold mb-1 text-white">My Tasks</h1><br>
                        <p>You have tasks to complete</p>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{ $todayAssignedCount }}</div>
                            <div class="fs-7 text-muted">Today's Task</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisweek}}</div>
                            <div class="fs-7 text-muted">This Week</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thismonth}}</div>
                            <div class="fs-7 text-muted">This Month</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{ $todayPendingNewCount }}</div>
                            <div class="fs-7 text-muted">Today's Pending</div>
                        </div>
                    </div>
                  
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisWeekPendingNew}} </div>
                            <div class="fs-7 text-muted">This Week Pending</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisMonthPendingNew}} </div>
                            <div class="fs-7 text-muted">This Month Pending</div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="col-xl-3">
                <div class="card" >
                  
                        <a href="http://127.0.0.1:8000/leave/create" target="_blank">
                            <img src="{{ asset('backend/assets/media/logos/l2.jpg') }}" class="rounded-2" alt="Leave Image" style="width: 100%; height: 356px"/>
                        </a>
                   
                </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                   @php
                    $supports = (Auth::user()->role === 'Admin')
                        ? $support->where('s_isdeleted', '!=', 1)
                        : $support->where('userid', Auth::id())->where('s_isdeleted', '!=', 1);

                    $Hot = $supports->where('Status', 'Hot')->count();
                    $Warm = $supports->where('Status', 'Warm')->count();
                    $Cold = $supports->where('Status', 'Cold')->count();
                    $Dead = $supports->where('Status', 'Dead')->count();

                    $todayAssignedCount = $supports->where('created_at', '>=', \Carbon\Carbon::today())->count();
               

                    //this month task
                    $startOfMonth = Carbon\Carbon::now()->startOfMonth();
                    $endOfMonth = Carbon\Carbon::now()->endOfMonth();

                    $thismonth = $supports->filter(function ($support) use ($startOfMonth, $endOfMonth) {
                        return Carbon\Carbon::parse($support->created_at)->between($startOfMonth, $endOfMonth);
                    })->count();

                    //this month pending task
                    $thisMonthPendingNew = $supports->filter(function ($support) use ($startOfMonth, $endOfMonth) {
                        return \Carbon\Carbon::parse($support->created_at)->between($startOfMonth, $endOfMonth)
                            && in_array($support->Status, ['Pending', 'New']);
                    })->count();

                    // This week task
                    $startOfWeek = Carbon\Carbon::now()->startOfWeek();
                    $endOfWeek = Carbon\Carbon::now()->endOfWeek();

                    $thisweek = $supports->filter(function ($support) use ($startOfWeek, $endOfWeek) {
                        return Carbon\Carbon::parse($support->created_at)->between($startOfWeek, $endOfWeek);
                    })->count();

                    $thisWeekPendingNew = $supports->filter(function ($support) use ($startOfWeek, $endOfWeek) {
                        return \Carbon\Carbon::parse($support->created_at)->between($startOfWeek, $endOfWeek)
                            && in_array($support->Status, ['Pending', 'New']);
                    })->count();

                 
                @endphp
                
                <div class="card border-0 shadow-sm mb-6" style="background: linear-gradient(to left,  #0072ff, #25396f);">
                    <div class="card-body text-white p-9">
                        <h1 class="fw-bold mb-1 text-white">My Tasks</h1><br>
                        <p>You have tasks to complete</p>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{ $todayAssignedCount }}</div>
                            <div class="fs-7 text-muted">Today's Task</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisweek}}</div>
                            <div class="fs-7 text-muted">This Week</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thismonth}}</div>
                            <div class="fs-7 text-muted">This Month</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{ $todayPendingNewCount }}</div>
                            <div class="fs-7 text-muted">Today's Pending</div>
                        </div>
                    </div>
                  
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisWeekPendingNew}} </div>
                            <div class="fs-7 text-muted">This Week Pending</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-white shadow-sm rounded-4 text-center px-4 py-5 h-100">
                            <div class="fs-1 fw-bold text-primary mb-2">{{$thisMonthPendingNew}} </div>
                            <div class="fs-7 text-muted">This Month Pending</div>
                        </div>
                    </div>
                </div>    
            </div>
            </div>
            <div class="col-xl-4">
            </div>
        </div>            

        <div class="row">
            <div class="col-xl-3">
                <div class="card border-0 shadow-lg rounded-2 p-4 w-100 mb-6" style="max-width: 700px; margin: 0 auto; background: linear-gradient(135deg, #00c6ff, #0072ff,#002244); color: white;">
                   
                        <div class="row g-3 justify-content-center">
                            <div class="card  border-0 bg-transparent">
                                <div class="card-body d-flex flex-column align-items-center text-center">

                                    <!-- Title Section -->
                                    <div class="mb-1">
                                        <h3 class="fw-bold text-white mb-2">Have you tried</h3>
                                        <h6 class="fw-bolder" style="color: #002244;">Our New Smart Invoice Manager?</h6>
                                        <p class="mt-3 mb-0 " style=" color: #e0f7fa;">
                                            Simplify your invoicing workflow with <strong>automation</strong>, <strong>real-time tracking</strong>, and <strong>zero hassle</strong>. 
                                            Designed by <span style="color: #002244;"><a href="https://www.repunext.com/">RepuNEXT</a></span> to make your business smarter and faster!
                                        </p>
                                    </div>

                                    <div class="py-5">
                                        <img src="{{ asset('backend/assets/media/logos/2.svg') }}"
                                            style="max-width: 180px;" alt="Invoice Manager Illustration">
                                    </div>

                                    <div class="pt-3">
                                        <a href="http://127.0.0.1:8000/salesorder/add"
                                        class="btn px-4 py-2 me-2 fw-semibold"
                                        style="background-color: #002244; border: none; color: white;">
                                            🚀 Try Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="card mb-2" style="height: 488px; overflow: hidden;">
                    <div class="card-header position-relative py-4 border-0 bg-light rounded-top shadow-sm">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                            <h3 class="card-title text-dark fw-bold fs-3 mb-0 ps-4">Active Tasks</h3>

                            <form id="dashboardFilterForm" class="d-flex align-items-center gap-10 bg-white border rounded px-3 py-2 shadow-sm justify-content-end" style="border-radius: 12px;">
                                <select name="user_id" id="userSelect" class="form-select-2 form-select-sm border-0" style="min-width: 140px;">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ ($userId == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>

                                <input type="text" name="date_range" id="datePicker" value="{{ $dateRange }}" class="form-control form-control-sm border-0" placeholder="Date or Range" style="min-width: 160px;" />

                                <input type="hidden" id="currentFilter" name="filter" value="{{ $filter }}">

                                <button type="submit" class="btn btn-sm btn-dark rounded px-3">Filter</button>
                            </form>

                            <a href="{{ route('add.ttimecat') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" >
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
										<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
									</svg>
								</span>Add</button>
							</a>

                            <button id="refreshButton" class="btn btn-primary ms-2">↻</button>
                        </div>
                        <ul class="nav nav-pills gap-2 justify-content-center mt-5" role="tablist">
                            @php
                                $filters = ['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'];
                            @endphp
                            @foreach($filters as $key => $label)
                                <li class="nav-item" role="presentation">
                                    <a href="javascript:void(0);" 
                                        class="nav-link px-3 py-2 rounded {{ ($filter === $key && !$dateRange) ? 'active bg-dark text-white' : 'bg-white border text-dark' }}"
                                        data-filter="{{ $key }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Scrollable Content Section -->
                    <div id="dashboard-content" style="height: calc(100% - 135px); overflow-y: auto; padding: 10px;">
                        @include('admin.dashboard_partial')
                    </div>
                </div>
             </div>
        </div>

        
        <div class="row">
            <div class="col-xl-3">
                <div class="card border-0 shadow-lg rounded-4 p-3 w-100" style="max-width: 700px; margin: 0 auto;">
        
                        @foreach($users as $user)
                            @if(!in_array(strtolower($user->role), ['admin', 'cto']))
                                <div class="col-md-12">
                                    <a href="{{ route('list.user') }}" class="text-decoration-none">
                                        <div class="card shadow-sm border-0 rounded-4 p-3 mb-3 user-card" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border:1px solid rgba(255,255,255,0.2); transition: all 0.3s;">
                                            <div class="d-flex justify-content-between">
                                                {{-- Left section --}}
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="overflow-hidden" style="border-radius: 50%; width:50px; height:50px; border: 2px solid #fff;">
                                                        <img src="{{ asset('upload/admin-images/' . $user->profile_image) }}" alt="Profile" style="width:100%; height:100%; object-fit:cover;">
                                                    </div>

                                                    <div class="d-flex flex-column justify-content-center ">
                                                        <span class="fw-bold">{{ $user->name }}</span>
                                                        <small style="font-size: 11px; opacity:0.8;">{{ $user->email }}</small>
                                                        <span style="font-size: 10px; font-weight: bold;">{{ ucfirst($user->role) }}</span>
                                                    </div>
                                                </div>

                                                {{-- Right section --}}
                                                <div class="d-flex flex-column align-items-center justify-content-center">
                                                    @if($user->status == 0)
                                                        <span style="display:inline-block; width:12px; height:12px; background:#00e5e0; border-radius:50%; box-shadow: 0 0 8px #00e5e0;"></span>
                                                    @else
                                                        <span style="display:inline-block; width:12px; height:12px; background:red; border-radius:50%; box-shadow: 0 0 8px red;"></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    
                </div>


            </div>
            <div class="col-xl-9">
                <div class="card shadow-sm " style="max-width: 800px;">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Leave Balance Summary</h5>
                        <div class="d-flex gap-2">
                            <!-- Date inputs are hidden -->
                            <input type="hidden" id="start_date" value=" 2025-01-01">
                            <input type="hidden" id="end_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            <button class="btn btn-sm btn-primary" onclick="showTakenLeaveTable()">
                                <i class="bi bi-filter"></i> Total Taken Leave
                            </button>
                            <button class="btn d-flex align-items-center justify-content-center rounded-3"
                                    style="width: 48px; height: 48px; background-color: #0d0f2b;"
                                    onclick="resetTakenLeaveTable()"
                                    title="Reset Taken Leave">
                                <i class="bi bi-arrow-clockwise text-white fs-5"></i>
                            </button>
                            <button class="btn btn-sm btn-primary" onclick="fetchLeaveBalance()">
                                <i class="bi bi-filter"></i> Check Balance Leave
                            </button>
                           <button class="btn btn-dark d-flex align-items-center justify-content-center rounded-3"
                                    style="width: 48px; height: 48px;"
                                    onclick="resetFilter()"
                                    title="Reset Balance Leave">
                                <i class="bi bi-arrow-clockwise fs-5"></i>
                            </button>
                        </div>
                    </div>
                    <div id="balanceLeaveTableWrapper" style="display: none;">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered mb-0">
                                    <thead class="table-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>User Name</th>
                                            <th>Balance Credit Leave (Days)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="leave-balance-table">
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Please select a date range to view data.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                             <!-- Total Taken Leave Table -->
    <div id="totalTakenLeaveTable" style="display: none;">
    <div class="card shadow-sm p-3 mt-4 rounded" style="background-color: #f8f9fa;">
        <h5 class="mb-3 text-dark">Monthly Leave Taken Summary</h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="text-white text-uppercase text-center" style="background-color:#002244;">
                    <tr>
                        <th class="px-3 py-2">#</th>
                        <th class="px-3 py-2">User Name</th>
                        <th class="px-3 py-2">Year</th>
                        <th class="px-3 py-2">Month</th>
                        <th class="px-3 py-2">Total Leave Taken (Days)</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    @php $i = 1; @endphp
                    @foreach($leaveSummary as $summary)
                        <tr>
                            <td class="px-3 py-2">{{ $i++ }}</td>
                            <td class="px-3 py-2">{{ $summary['user_name'] }}</td>
                            <td class="px-3 py-2">{{ $summary['year'] }}</td>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::create()->month($summary['month'])->format('F') }}</td>
                            <td class="px-3 py-2">
                            @php
                                $days = $summary['total_taken_leave'] / 8;
                            @endphp

                            @if ($days > 0)
                                {{ floor($days) == $days ? intval($days) : number_format($days, 1) }}
                                {{ $days == 1 ? 'Day' : 'Days' }}
                            @else
                                -
                            @endif
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


                        </div>
                    </div>
                </div>
            </div>
            
        </div>
       
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>





<!-- Timesheet -->
<script>
    //timesheet
    $(document).ready(function () {
        flatpickr("#datePicker", {
            mode: "range",
            dateFormat: "Y-m-d"
        });

        $('#dashboardFilterForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('dashboard.data') }}",
                method: 'GET',
                data: $(this).serialize(),
                success: function (response) {
                    $('#dashboard-content').html(response.html);

                    // ✅ Render the bar chart after AJAX
                    if (document.getElementById('categoryChart')) {
                        const ctx = document.getElementById('categoryChart').getContext('2d');
                        const labels = JSON.parse(document.getElementById('categoryChart').getAttribute('data-labels'));
                        const values = JSON.parse(document.getElementById('categoryChart').getAttribute('data-values'));
                        const total = values.reduce((a, b) => a + b, 0);
                        const percentData = values.map(v => ((v / total) * 100).toFixed(2));

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Time Spent (%)',
                                    data: percentData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    borderRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: context => context.parsed.y + '%'
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        ticks: {
                                            callback: value => value + '%'
                                        }
                                    }
                                }
                            }
                        });
                    }
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseJSON || xhr.statusText);
                }
            });
        });

        $('.nav-link').on('click', function (e) {
            e.preventDefault();
            $('.nav-link').removeClass('active bg-dark text-white').addClass('bg-white border text-dark');
            $(this).removeClass('bg-white border text-dark').addClass('active bg-dark text-white');
            $('#currentFilter').val($(this).data('filter'));
            $('#dashboardFilterForm').submit();
        });

        $('#refreshButton').on('click', function () {
            $('#userSelect').val('');
            $('#datePicker').val('');
            $('#currentFilter').val('daily');
            $('.nav-link').removeClass('active bg-dark text-white').addClass('bg-white border text-dark');
            $('.nav-link[data-filter="daily"]').addClass('active bg-dark text-white').removeClass('bg-white border text-dark');
            $('#dashboardFilterForm').submit();
        });

        $(document).on('click', '.toggle-desc', function () {
            const id = $(this).data('id');
            $('#desc-' + id).toggle();
        });

        $(document).on('click', '.toggle-date', function () {
            const dateSlug = $(this).data('date');
            const row = $('#tasks-' + dateSlug);
            const isVisible = row.is(':visible');
            if (!isVisible) {
                row.slideDown(200);
                $(this).text('Hide Tasks');
            } else {
                row.slideUp(200);
                $(this).text('View Tasks');
            }
        });
    });
</script>



 <script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('goalStatusChart').getContext('2d');

        const gradient1 = ctx.createLinearGradient(0, 0, 0, 250);
        gradient1.addColorStop(0, '#002D62');
        gradient1.addColorStop(1, '#0072ff');

        const gradient2 = ctx.createLinearGradient(0, 0, 0, 250);
        gradient2.addColorStop(0, '#0066b2');
        gradient2.addColorStop(1, '#4facfe');

        const gradient3 = ctx.createLinearGradient(0, 0, 0, 250);
        gradient3.addColorStop(0, '#4B9CD3');
        gradient3.addColorStop(1, '#25396f');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'New'],
                datasets: [{
                    data: [{{ $completedGoals }}, {{ $pendingGoals }}, {{ $notStartedGoals }}],
                    backgroundColor: [gradient1, gradient2, gradient3],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 12,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#ffffff',
                        titleColor: '#000',
                        bodyColor: '#000',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        titleFont: { weight: 'bold' },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centerText',
                afterDraw: function(chart) {
                    const tooltip = chart.tooltip;
                    if (!tooltip || !tooltip.opacity) {
                        const { width, height } = chart;
                        const ctx = chart.ctx;
                        ctx.restore();
                        ctx.font = "bold 16px Arial";
                        ctx.textAlign = "center";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#25396f";
                        ctx.fillText("Goals", width / 2, height / 2);
                        ctx.save();
                    }
                }
            }]
        });
    });
</script>



<!-- Leave Summary -->
<script>
    function fetchLeaveBalance() {
        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();

        if (!startDate || !endDate) {
            $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-warning">Please select both start and end dates</td></tr>');
            return;
        }

        $('#balanceLeaveTableWrapper').show(); // ✅ Show the table
        $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-primary">Loading data...</td></tr>');

        $.ajax({
            url: "{{ url('/fetch-leave-balance') }}",
            type: "GET",
            data: { start_date: startDate, end_date: endDate },
            dataType: "json",
            success: function(response) {
                let rows = '';

                if (response.status === 'success' && response.data.length > 0) {
                    $.each(response.data, function(index, leave) {
                        let balance = parseFloat(leave.balance_days);
                        let formatted = balance > 0
                            ? (Number.isInteger(balance) ? `${balance} Day${balance > 1 ? 's' : ''}` : `${balance} Days`)
                            : '0';

                        rows += `
                            <tr class="text-center">
                                <td>${index + 1}</td>
                                <td>${leave.user_name}</td>
                                <td>${formatted}</td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="3" class="text-center text-danger">No data available for the selected date range</td></tr>';
                }

                $('#leave-balance-table').html(rows);
            },
            error: function() {
                $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-danger">Error fetching data</td></tr>');
            }
        });
    }

    function resetFilter() {
        $('#start_date').val('2025-01-01');
        $('#end_date').val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}');

        // ✅ Hide the whole balance leave table (including thead)
        $('#balanceLeaveTableWrapper').hide();

        // Optionally clear the rows (not required if hiding the whole wrapper)
        $('#leave-balance-table').html('<tr><td colspan="3" class="text-center text-muted">Please select a date range to view data.</td></tr>');
    }
</script>
<!-- Show taken leave -->
<script>
    function showTakenLeaveTable() {
        document.getElementById('totalTakenLeaveTable').style.display = 'block';
    }

    function resetTakenLeaveTable() {
        document.getElementById('totalTakenLeaveTable').style.display = 'none';
    }
</script>


@endsection
