@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []);?>
<style>.st-drop{ border:1px solid #b9b9b9 !important;}
	 .card-body1 {
            width: 1000px;
            height: 300px;
            display: flex;
            justify-content: center; 
        	align-items: center; 
            background: #fff;
            border-radius: 8px;
            /* box-shadow: 0px 4px 25px rgba(0, 0, 0, 0.1); */
            padding: 5px;
            margin-left: 30px; 
        }

#taskTimeChart {
    width: 300px !important; 
    height: 300px !important;
	margin-left: 10px;
	
}
table th, table td {

	   vertical-align: middle;
   }
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
#taskTableBody {
    font-family: 'Poppins', sans-serif;
}


</style>
<style>
	.highlight {
		background-color: white;
		color: darkblue;
		font-weight: bold;
	}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card " style="background-color: #E1EBEE"> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bold fs-3 mb-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M3 6h18M3 12h18M3 18h18"/>
							<circle cx="5" cy="6" r="2"/>
							<circle cx="12" cy="12" r="2"/>
							<circle cx="19" cy="18" r="2"/>
						</svg>
						ROADMAP TO SUCCESS
					</span>

					<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / GoalSheet </span>
					</h3>
				
					<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
						@if(in_array("goalsheet_all", $rolerawdata, TRUE) || in_array("goalsheet_create", $rolerawdata, TRUE) || in_array("kt_roles_select_all", $rolerawdata, TRUE))
							<a href="{{ route('add.gtask') }}">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
									<span class="svg-icon svg-icon-2">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
											<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
										</svg>
									</span>
									Add
								</button>
							</a>
						@endif 
					</div>
				</div>
				<div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0"> 
					<div class="card-title"> 
					<div class="d-flex align-items-center">
						<input type="text" id="searchBox" class="form-control" placeholder="Search Report" style="max-width: 250px;">
					</div>
						<div id="kt_ecommerce_report_views_export" class="d-none"></div> 
					</div> 
					@if(in_array("goalsheet_all",$rolerawdata, TRUE) || in_array("goalsheet_create",$rolerawdata, TRUE) || in_array("goalsheet_write",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
					<div class="card-toolbar flex-row-fluid justify-content-end gap-5"> 
						<button type="button" class="btn btn-light-primary st-drop" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
							<span class="svg-icon svg-icon-2">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
									<path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
									<path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
								</svg>
							</span> Export Report</button> 
						<div id="kt_ecommerce_report_views_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4 " data-kt-menu="true">
							<div class="menu-item px-3">
								<a href="#" class="menu-link px-3" data-kt-ecommerce-export="copy">Copy to clipboard</a>
							</div> 
							<div class="menu-item px-3">
								<a href="#" class="menu-link px-3" data-kt-ecommerce-export="excel">Export as Excel</a>
							</div> 
							<div class="menu-item px-3">
								<a href="#" class="menu-link px-3" data-kt-ecommerce-export="csv">Export as CSV</a>
							</div> 
							<div class="menu-item px-3">
								<a href="#" class="menu-link px-3" data-kt-ecommerce-export="pdf">Export as PDF</a>
							</div> 
						</div> 
					</div> 
					@endif
				</div> 
				<div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
					<div class="calendar-container d-flex">
						<button id="calendar-button" class="btn btn-dark border d-flex align-items-center" style="background-color: rgb(3, 31, 58);">
							<i class="fa fa-calendar-alt me-2"></i> <span id="selected-date">Select date range</span>
						</button>
						<input type="hidden" id="start-date" />
						<input type="hidden" id="end-date" />
					</div>
					<button id="refreshButton" class="btn btn-primary ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 1 0-.908.417A6 6 0 1 0 8 2v1z"/>
                            <path d="M8 1a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 1z"/>
                        </svg>
                    </button>
					
				</div>
				<div class="card-body pt-0"> 
				<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" >
						<thead> 
						<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted" id="taskTableBody" style="background-color: #002244;">
							<th class="w-10px pe-2"></th>
							<th class="">#</th>
							<th class="min-w-115px sorting">Task Name / Category / Deadline</th>
							<th class="min-w-125px sorting">Assigned By / Allocated To</th>
							<th class="min-w-115px sorting">Priority / Status</th>
							<th class="min-w-115px sorting">Task Duration / Completion</th>
							<th class="min-w-115px sorting">Assigned Date / Started At</th>
							<th class="min-w-125px text-center sorting">Actions</th>
						</tr>

						</thead> 
						<tbody class="fw-semibold text-gray-600" id="taskTableBody">
							<?php $j=0; ?>    
							@foreach($repn as $repns)
							@php
								// Timer in seconds
								$timerSeconds = ($repns->timer ?? 0) * 60; 
								$timerHours = floor($timerSeconds / 3600);
								$timerMinutes = floor(($timerSeconds % 3600) / 60);
								$timerRemainingSeconds = $timerSeconds % 60;
								$formattedTimer = sprintf('%02d:%02d:%02d', $timerHours, $timerMinutes, $timerRemainingSeconds);

								// Running time
								$timeTrack = $timeTracking->where('goalid_ref', $repns->id)->first();
								$runningSeconds = $timeTrack->running_time ?? 0; 
								$runningHours = floor($runningSeconds / 3600);
								$runningMinutes = floor(($runningSeconds % 3600) / 60);
								$runningRemainingSeconds = $runningSeconds % 60;
								$formattedRunningTime = sprintf('%02d:%02d:%02d', $runningHours, $runningMinutes, $runningRemainingSeconds);
							@endphp

							<tr class="task-row" 
								data-assigned="{{ \Carbon\Carbon::parse($repns->created_at)->format('Y-m-d') }}"
								data-formatted-time="{{ $formattedTimer }}"
								data-formatted-running-time="{{ $formattedRunningTime }}">

								<td></td>
								<td>{{$j+=1;}}</td> 

								<td>
									{{ $repns->g_taskname}}<br>
									<?php $gcategory = (explode(",",$repns->g_category));?>
									@foreach($gc as $gcs)
										@if(in_array ($gcs->id , $gcategory))
											{{$gcs->gc_name."," }}
										@endif
									@endforeach
									<br>
									
									@php                    
										$deadlineDate = Carbon\Carbon::parse($repns->g_deadline)->startOfDay();
										$currentDate = Carbon\Carbon::now()->startOfDay();
										
										$timeTrackingRecord = $timeTracking->where('goalid_ref', $repns->id)->first() ?? null;
										$updatedAtDate = $timeTrackingRecord ? Carbon\Carbon::parse($timeTrackingRecord->updated_at)->startOfDay() : null;
										
										if (strtolower($repns->g_status) == 'completed' && !$updatedAtDate) {
											// If status is updated to completed and no previous update date, store only the date part
											$updatedAtDate = $currentDate->copy()->startOfDay();
										}
										
										$isDeadlineCrossed = ($deadlineDate->lt($currentDate) && strtolower($repns->g_status) != 'completed') || ($updatedAtDate && $updatedAtDate->gt($deadlineDate));
									@endphp

									<span class="fw-bold {{ $isDeadlineCrossed ? 'text-danger' : '' }}">
										{{ $deadlineDate->toDateString() }}
										
										@if($isDeadlineCrossed)
											<span class="text-danger">(Deadline)</span>
										@endif
																				
									</span>
								</td> 

								<td>
									@php
										$as = explode(",", $repns->g_assignedby ?? ''); 
										$assignedUsers = [];
									@endphp

									@foreach($user as $users)
										@if(in_array((string)$users->id, $as)) {{-- Ensure IDs are treated as strings for comparison --}}
											@php $assignedUsers[] = $users->name; @endphp
										@endif
									@endforeach

									<span style="color: darkblue;">
										{{ implode(", ", $assignedUsers) }}
									</span> /<br>
									
									@php
										$ass = explode(",", $repns->g_assigned ?? ''); 
										$assignedUsers = [];
									@endphp

									@foreach($user as $users)
										@if(in_array((string)$users->id, $ass)) {{-- Ensure IDs are treated as strings for comparison --}}
											@php $assignedUsers[] = $users->name; @endphp
										@endif
									@endforeach

									{{ implode(", ", $assignedUsers) }} 
								</td>

								<td>{{ $repns->g_priority}} -
									<span style="font-weight: bold; 
										color: {{ strtolower($repns->g_status) == 'completed' ? ($runningSeconds > $timerSeconds ? 'red' : 'green') : 'black' }}">
										{{ $repns->g_status }}
										@if(strtolower($repns->g_status) == 'completed' && $runningSeconds > $timerSeconds)
											(Delayed)
										@endif
									</span>
								</td>
								<td>
									{{ $formattedTimer }} -
									<span style="font-weight: bold; {{ $runningSeconds > $timerSeconds ? 'color: red;' : '' }}">
										{{ $formattedRunningTime }}
									</span>
								</td>

								<td>{{ \Carbon\Carbon::parse($repns->created_at)->format('Y-m-d') }} / <br>
									@php
										$startTime = optional($timeTrack)->start_time ?? 'N/A';
									@endphp
									<span style="font-weight: bold; color: {{ $startTime !== 'N/A' ? 'blue' : 'black' }}">
										{{ $startTime }}
									</span>
								</td>

								<td>
									@if(in_array("goalsheet_all",$rolerawdata, TRUE) || in_array("goalsheet_read",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
									<a href="{{route('view.gtask', $repns->id)}}" class="btn btn-sm btn-warning align-self-center" style="border-radius: 100px;padding: 8px 8px 8px 10px;">
										<i class="fa fa-eye" aria-hidden="true"></i>
									</a>  
									@endif
									@if(in_array("goalsheet_all",$rolerawdata, TRUE) || in_array("goalsheet_write",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))      
									<a href="{{route('edit.gtask', $repns->id)}}" class="btn btn-sm btn-info align-self-center" style="border-radius: 104px;padding: 8px 8px 10px 13px;margin: 0px 1px;">
										<i class="fa fa-edit" aria-hidden="true"></i>
									</a>
									@endif
									@if(in_array("goalsheet_all",$rolerawdata, TRUE) || in_array("goalsheet_delete",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
									<a href="#" onclick="deleteConfirmation({{$repns->id}})" data-id="{{ $repns->id }}" class="btn btn-sm crop-delete btn-danger align-self-center" style="border-radius: 100px;padding: 8px 8px 8px 12px;">
										<i class="fa fa-trash" aria-hidden="true"></i>
									</a> 
									@endif 
								</td>
							</tr>   
							@endforeach  
						</tbody>

					</table> 
					<div class="d-flex justify-content-center" id="paginationWrapper">
						{!! $repn->links('pagination::bootstrap-4') !!}
					</div>



				</div> 
				
			</div>
			<div class="card mt-5">
				<div class="card-body1">
					<div class="row mb-4">
						<div class="col-12" >
							<h3>ANALYSIS REPORT</h3>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-12 " style="margin-left:50px">
							<canvas id="taskTimeChart"></canvas>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-12 " style="margin-left:50px">
							<p><span id="notStartedCount"></span></p>
							<p><span id="onTimeCount"></span></p>
							<p><span id="delayCount"></span></p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let refreshButton = document.getElementById("refreshButton");
    let searchBox = document.getElementById("searchBox");
    let calendarButton = document.getElementById("calendar-button");
    let selectedDateDisplay = document.getElementById("selected-date");
    let startDateInput = document.getElementById("start-date");
    let endDateInput = document.getElementById("end-date");

    if (refreshButton) {
        refreshButton.addEventListener("click", function () {
            location.reload();
        });
    }

    if (calendarButton) {
        const picker = flatpickr(calendarButton, {
            mode: "range",
            dateFormat: "Y-m-d",
            allowInput: false,
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const formattedStart = instance.formatDate(selectedDates[0], "Y-m-d");
                    const formattedEnd = instance.formatDate(selectedDates[1], "Y-m-d");

                    selectedDateDisplay.textContent = `${formattedStart} - ${formattedEnd}`;
                    startDateInput.value = formattedStart;
                    endDateInput.value = formattedEnd;
                } else {
                    selectedDateDisplay.textContent = "All Dates"; 
                    startDateInput.value = "";
                    endDateInput.value = "";
                }

                filterAndSearchTasks(startDateInput.value, endDateInput.value, searchBox.value);
            }
        });

        calendarButton.addEventListener("click", function () {
            picker.open();
        });
    }

    if (searchBox) {
        searchBox.addEventListener("keyup", function () {
            filterAndSearchTasks(startDateInput.value, endDateInput.value, searchBox.value);
        });
    }

	function filterAndSearchTasks(startDate, endDate, searchValue) {
		searchValue = searchValue.toLowerCase();
		let rows = document.querySelectorAll(".task-row");
		let paginationWrapper = document.getElementById("paginationWrapper");

		let taskData = {
			"Not Started": 0,
			"Delayed": 0,
			"On Time": 0
		};

		let isFiltering = startDate || endDate || searchValue;

		if (paginationWrapper) {
			paginationWrapper.style.display = isFiltering ? "none" : "flex";
		}

		let visibleRows = 0;

		rows.forEach(row => {
			let assignedDateStr = row.getAttribute("data-assigned");
			let assignedDate = assignedDateStr ? new Date(assignedDateStr) : null;
			let textContent = row.textContent.toLowerCase();
			let formattedTime = row.getAttribute("data-formatted-time") || "00:00:00";
			let formattedRunningTime = row.getAttribute("data-formatted-running-time") || "00:00:00";

			let isWithinDateRange = (!startDate || !endDate) || (assignedDate && assignedDate >= new Date(startDate) && assignedDate <= new Date(endDate));
			let isMatchingSearch = textContent.includes(searchValue);
			
			// let isVisible = searchValue ? isMatchingSearch : isWithinDateRange;
			let isVisible = isWithinDateRange && isMatchingSearch;

			row.style.display = isVisible ? "" : "none";
			if (isVisible) visibleRows++;

			if (isVisible) {
				let taskTimeSeconds = convertTimeToSeconds(formattedTime);
				let runningTimeSeconds = convertTimeToSeconds(formattedRunningTime);

				if (formattedRunningTime === "00:00:00") {
					taskData["Not Started"]++;
				} else if (runningTimeSeconds > taskTimeSeconds) {
					taskData["Delayed"]++;
				} else {
					taskData["On Time"]++;
				}
			}
		});

		// If no visible rows, hide pagination
		if (paginationWrapper) {
			paginationWrapper.style.display = visibleRows > 0 && !isFiltering ? "flex" : "none";
		}

		drawPieChart(taskData);
	}



    function convertTimeToSeconds(timeStr) {
        let [hours, minutes, seconds] = timeStr.split(":").map(Number);
        return (hours * 3600) + (minutes * 60) + seconds;
    }

    function drawPieChart(taskData) {
        let ctx = document.getElementById("taskTimeChart")?.getContext("2d");

        if (!ctx) return;

        if (window.taskTimeChart && window.taskTimeChart.destroy) {
            window.taskTimeChart.destroy();
        }

        window.taskTimeChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: Object.keys(taskData),
                datasets: [{
                    data: Object.values(taskData),
                    backgroundColor: ["#7CB9E8", "#ff0000", "#00308F"],
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "right" },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                let value = tooltipItem.raw;
                                let total = Object.values(taskData).reduce((a, b) => a + b, 0);
                                let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                                return `${tooltipItem.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        document.getElementById("notStartedCount").textContent = `Not Started: ${taskData["Not Started"]}`;
        document.getElementById("onTimeCount").textContent = `On Time: ${taskData["On Time"]}`;
        document.getElementById("delayCount").textContent = `Delayed: ${taskData["Delayed"]}`;
    }

    filterAndSearchTasks("", "", ""); 
});

function deleteConfirmation(id) {
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			}, function (isConfirm) {
				if (!isConfirm) return;    
				
				let token = "{{ csrf_token() }}";
				let _url = `/goal/task/destroy/${id}`; 
				
				$.ajax({
					type: 'POST',  
					url: _url,
					data: {_token: token},  
					success: function () {
						swal("Done!", "It was successfully deleted!", "success");
						location.reload();  
					},
					error: function (xhr, ajaxOptions, thrownError) {
						swal("Error deleting!", "Please try again", "error");
					}
				}); 
			});  
		}

</script>
@endsection