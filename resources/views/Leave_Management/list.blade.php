@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []);?>
<style>.st-drop{ border:1px solid #b9b9b9 !important;}</style>
<style>
     #notification-area {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        text-align: center;
    }
	
    .flight-container {
        position: relative;
        display: inline-block;
        padding: 20px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.5s ease-in-out;
    }

    .flight-icon {
        width: 100px;
        height: 100px;
        display: block;
        margin: 0 auto;
        animation: takeoff 2s ease-in-out forwards;
    }

    .notification-message {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-top: 10px;
    }

    @keyframes takeoff {
        0% {
            transform: translateY(20px) scale(1);
            opacity: 0;
        }
        50% {
            transform: translateY(-10px) scale(1.1);
            opacity: 1;
        }
        100% {
            transform: translateY(-40px) scale(1.2);
            opacity: 0;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>
<!-- Styles for GIF Popup -->
<style>
    .popup-gif {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background: rgba(0, 0, 0, 0.8);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }
    .popup-gif img {
        width: 120px; /* Adjust GIF size */
    }
    .popup-gif .close-btn {
        display: block;
        color: white;
        background: #444;
        padding: 5px 10px;
        border-radius: 5px;
        margin-top: 10px;
        cursor: pointer;
        font-weight: bold;
    }
    .approve-btn, .reject-btn {
        padding: 8px 12px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        margin: 5px;
        border-radius: 5px;
    }
    .approve-btn { background: #28a745; color: white; }
    .reject-btn { background: #dc3545; color: white; }
    .disabled-btn { cursor: not-allowed; opacity: 0.7; }
</style>

<!-- GIF Popup -->
<div id="gifPopup" class="popup-gif">
    <img id="actionGif" src="" alt="Action GIF">
    <div class="close-btn">Close</div>
</div>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container"> 
			<div class="card "style="background-color: #E1EBEE"> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bold fs-3 mb-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
							<path d="M2.5 19h19v2h-19v-2zm18.648-7.382c.82 1.536.465 3.468-.87 4.541-.907.718-2.002.841-3.03.577l-8.659-2.188-2.394 1.692c-.49.346-1.083.57-1.733.642-1.369.149-2.727-.659-3.225-1.926-.572-1.453-.02-3.072 1.298-3.838l1.918-1.105-1.65-4.785c-.155-.45-.002-.95.378-1.25.35-.275.82-.308 1.205-.084l3.76 2.197 7.34-4.562c.423-.263.968-.261 1.39.004.427.268.689.745.688 1.256v1.702l-5.225 3.249 5.842 3.166c.746.404 1.361 1.004 1.758 1.728z"/>
						</svg>
						LEAVE REQUEST
					</span>


						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Leave</span>
					</h3>
					
					<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
							@if(in_array("leave_all",$rolerawdata, TRUE) || in_array("leave_create",$rolerawdata, TRUE)|| in_array("kt_roles_select_all",$rolerawdata, TRUE))
							<a href="{{ route('add.leave') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" >
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
										<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
									</svg>
								</span>Add</button>
							</a>
							@endif

					</div>
				</div>
				<div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0"> 
					<div class="card-title"> 
						<div class="d-flex align-items-center position-relative my-1"> 
							<span class="svg-icon svg-icon-1 position-absolute ms-4">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
									<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
								</svg>
							</span> 
							<input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Report" />
						</div> 
						<div id="kt_ecommerce_report_views_export" class="d-none"></div> 
					</div> 
					@if(in_array("leave_all",$rolerawdata, TRUE) || in_array("leave_create",$rolerawdata, TRUE) || in_array("leave_",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
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
				<ul class="nav nav-tabs mb-3 border-0" id="leaveTabs" role="tablist">
					<li class="nav-item me-8"></li>
					<li class="nav-item" >
						<a class="nav-link active fw-bold px-5 py-3"  id="all-tab" data-bs-toggle    ="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
					</li>
					<li class="nav-item">
						<a class="nav-link fw-bold px-5 py-3 pill"  id="pending-tab" data-bs-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">
						 Pending
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link fw-bold px-5 py-3"  id="approved-tab" data-bs-toggle="tab" href="#approved" role="tab" aria-controls="approved" aria-selected="false">Approved</a>
					</li>
					<li class="nav-item">
						<a class="nav-link fw-bold px-5 py-3"  id="rejected-tab" data-bs-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">Rejected</a>
					</li>
				</ul>
				<div id="notification-area"></div>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
						<div class="card-body pt-0"> 
							<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
								<thead>
									<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted "style="background-color: #002244;">
										<th class="w-8px pe-2"></th>
										<th>#</th>
										<th class="min-w-115px sorting">Username</th>
										<th class="min-w-115px sorting">Leave Type</th>
										<th class="min-w-115px sorting">Start Date - End Date</th>
										<th class="min-w-115px sorting">Total Days</th>
										<th class="min-w-115px sorting">Status</th>
										<th class="min-w-140px sorting">Actions</th> 
									</tr>
								</thead>
								<tbody class="fw-semibold text-gray-600">
									<?php $j = 0; ?>                                     
									@foreach($repn as $repns)
										@if( in_array("kt_roles_select_all", $rolerawdata, TRUE) || in_array("leave_all", $rolerawdata, TRUE) || (Auth::user()->id) == ($repns->name))
										<tr> 
											<td>  </td>
											<td>{{++$j }}</td>
											<td>
												@foreach($user as $users)
													@if($users->id == $repns->name)
														{{ $users->username }}
													@endif
												@endforeach
											</td>
											<td>{{ $repns->leave_type }}</td>
											<td>{{ $repns->startdate }} - {{ $repns->enddate }}</td>						
											<td>{{ $repns->totaldays }}</td>
											<td>{{ $repns->l_status }}</td>
											<td>
												@if(in_array("leave_all",$rolerawdata, TRUE)||in_array("leave_read",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<a href="{{ route('view.leave', $repns->id) }}" class="btn btn-sm btn-warning" style="border-radius: 100px; padding: 8px;">
													<i class="fa fa-eye"></i>
												</a>
												@endif
												@if(in_array("leave_all",$rolerawdata, TRUE)||in_array("leave_write",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<a href="{{ route('edit.leave', $repns->id) }}" class="btn btn-sm btn-info" style="border-radius: 100px; padding: 8px;">
													<i class="fa fa-edit"></i>
												</a>
												@endif
												@if(in_array("leave_all",$rolerawdata, TRUE)||in_array("leave_delete",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<a href="#" onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-sm btn-danger" style="border-radius: 100px; padding: 8px;">
													<i class="fa fa-trash"></i>
												</a>
												@endif
											</td>
										</tr>
										@endif
									@endforeach
								</tbody>
							</table> 
						</div>
					</div>

					<div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
						<div class="card-body pt-0"> 
							<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
								<thead>
									<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted"  style="background-color: #002244;">
										<th class="w-10px pe-2"></th>
										<th>#</th>
										<th class="min-w-115px sorting">Username</th>
										<th class="min-w-115px sorting">Leave Type</th>
										<th class="min-w-115px sorting">Start Date - End Date</th>
										<th class="min-w-115px sorting">Total Days</th>
										<th class="min-w-115px sorting">Status</th>
										<th class="min-w-140px sorting">Actions</th>
									</tr>
								</thead>
								 <div class="fw-semibold text-gray-600">
									<?php $k = 0; ?>
										@foreach($repn as $repns)
										@if( in_array("kt_roles_select_all", $rolerawdata, TRUE) || in_array("leave_all", $rolerawdata, TRUE) || (Auth::user()->id) == ($repns->name))
											@if($repns->l_status == "1")
												<tr>
													<td></td>
													<td>{{ ++$k }}</td>
													<td> 
														@foreach($user as $users)
															@if($users->id == $repns->name)
																{{ $users->username }}
															@endif
														@endforeach
													</td>
													<td>{{ $repns->leave_type }}</td>
													<td>{{ $repns->startdate }} - {{ $repns->enddate }}</td>	
													<td>{{ $repns->totaldays }}</td>
													<td>{{ $repns->l_status }}</td>
													<td>
														@if(in_array("leave_all",$rolerawdata, TRUE)||in_array("leave_read",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
														<a href="{{ route('view.leave', $repns->id) }}" class="btn btn-sm btn-warning" style="border-radius: 100px; padding: 8px;"><i class="fa fa-eye"></i></a>
														@endif
														<!-- <a href="{{ route('edit.leave', $repns->id) }}" class="btn btn-sm btn-info" style="border-radius: 100px; padding: 8px;"><i class="fa fa-edit"></i></a>
														<a href="#" onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-sm btn-danger" style="border-radius: 100px; padding: 8px;"><i class="fa fa-trash"></i></a> -->
													</td>
												</tr>
											@endif
											@endif
										@endforeach
								</tbody>
							</table> 
						</div>
						</div>
						<div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
							<div class="card-body pt-0">
							<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
								<thead>
									<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted "style="background-color: #002244;">
										<th class="w-10px pe-2"></th> 
										<th>#</th>
										<th class="min-w-115px sorting">Username</th>
										<th class="min-w-115px sorting">Leave Type</th>
										<th class="min-w-115px sorting">Start Date - End Date</th>
										<th class="min-w-115px sorting">Reason</th>
										<th class="min-w-115px sorting">Total Days</th>
										<th class="min-w-115px sorting" style="display: none;">Status</th>
										<th class="min-w-140px sorting">Actions</th>
									</tr>
								</thead>
								<tbody class="fw-semibold text-gray-600">
									<?php $j = 0; ?>
									@foreach($repn as $repns)
									@if(in_array("kt_roles_select_all", $rolerawdata, TRUE) || in_array("leave_all", $rolerawdata, TRUE) || (Auth::user()->id) == ($repns->name))
										<tr class="leave-row" data-status="{{ $repns->l_status }}" id="row-{{ $repns->id }}">
											<td></td>
											<td>{{ ++$j }}</td>
											<td>
												@php $matchedUser = $user->firstWhere('id', $repns->name); @endphp
												{{ $matchedUser ? $matchedUser->username : 'Unknown User' }}
											</td>
											<td>{{ $repns->leave_type }}</td>
											<td>{{ $repns->startdate }} - {{ $repns->enddate }}</td>
											<td>{{ $repns->reason }}</td>
											<td>{{ $repns->totaldays }}</td>
											
											<td id="l_status-{{ $repns->id }}" class="status" style="display: none;">{{ $repns->l_status }}</td>
											<td>
												@if(in_array("leave_all",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<!-- Approve Button -->
												<button class="approve-btn btn btn-success btn-sm" data-id="{{ $repns->name }}" data-leave-id="{{ $repns->id }}">
													<i class="fa fa-check"></i> Approve
												</button>
												@endif
												@if(in_array("leave_all",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<!-- Reject Button -->
												<button class="reject-btn btn btn-danger btn-sm w-80" data-id="{{ $repns->name }}" data-leave-id="{{ $repns->id }}">
													<i class="fa fa-times"></i> Reject
												</button>
												@endif
												@if(in_array("leave_all",$rolerawdata, TRUE)||in_array("leave_read",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<!-- View Button -->
												<a href="{{ route('view.leave', $repns->id) }}" class="btn btn-sm btn-warning w-80">
													<i class="fa fa-eye"></i> View
												</a>
												@endif
											</td>
										</tr>
										@endif
									@endforeach
								</tbody>
							</table>
							</div>
						</div>

						<div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
							<div class="card-body pt-0">
								<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
									<thead>
										<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted" style="background-color: #002244;">
										<th class="w-10px pe-2"></th> 
											<th>#</th>
											<th>Username</th>
											<th>Leave Type</th>
											<th>Start Date</th>
											<th>End Date</th>
											<th>Comment</th>
											<th>Total Days</th>
											<th>Status</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody class="fw-semibold text-gray-600">
										<?php $j = 0; ?>
										@foreach($repn as $repns)
										@if( in_array("kt_roles_select_all", $rolerawdata, TRUE) || in_array("leave_all", $rolerawdata, TRUE) || (Auth::user()->id) == ($repns->name))
											@if($repns->l_status == '2')
											<tr>
												<td></td>
												<td>{{ ++$j }}</td>
												<td>
													@foreach($user as $users)
														@if($users->id == $repns->name)
															{{ $users->username }}
														@endif
													@endforeach
												</td>
												<td>{{ $repns->leave_type }}</td>
												<td>{{ $repns->startdate }}</td>
												<td>{{ $repns->enddate }}</td> 
												<td>{{ $repns->reason }}</td>
												<td>{{ $repns->totaldays }}</td>
												<td>{{ $repns->l_status }}</td>
												<td>
													@if(in_array("leave_all",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
													<button class="approve-btn btn btn-success btn-sm" data-id="{{ $repns->name }}" data-leave-id="{{ $repns->id }}">
														<i class="fa fa-check"></i> Approve
													</button>
													@endif	
													@if(in_array("leave_all",$rolerawdata, TRUE)||in_array("leave_read",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
													<a href="{{ route('view.leave', $repns->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i>View</a>
													@endif
												</td>
											</tr>
											@endif
										@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
			</div>
		</div>
	</div>
</div> 
<script>
	$(document).ready(function() {
    // Filter rows based on status when tabs are clicked
    $("#pending-tab").click(function () {
        $("#pending th:nth-child(8), #pending td:nth-child(8)").hide();
        $(".leave-row").each(function () {
            if ($(this).data("status") == 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $("#all-tab, #approved-tab, #rejected-tab").click(function () {
        $("#pending th:nth-child(8), #pending td:nth-child(8)").show();
        $(".leave-row").show();
    });

    // Handle approve/reject button clicks
    $(".approve-btn, .reject-btn").click(function() {
        var button = $(this);
        var userName = button.data("id"); // For sending email
        var leaveId = button.data("leave-id"); // For updating status
        var action = button.hasClass("approve-btn") ? "approve" : "reject";
        var newLStatus = action === "approve" ? 1 : 2; // 1 for approve, 2 for reject

        $.ajax({
            url: "/update-leave-status", // Ensure this route handles status updates in the backend
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: userName,
                leave_id: leaveId,
                action: action,
                l_status: newLStatus // Updating l_status in database
            },
            success: function(response) {
                alert(response.message);

                // Update the status text in UI
                var statusText = action === "approve" ? "Approved" : "Rejected";
                var statusColor = action === "approve" ? "green" : "red";

                $("#t_status-" + leaveId).text(statusText).css({
                    "color": statusColor,
                    "font-weight": "bold"
                });

                button.text(statusText)
                    .prop("disabled", true)
                    .removeClass(action + "-btn")
                    .addClass("disabled-btn")
                    .css({"background": statusColor, "color": "white"});

                // Disable the opposite button based on the action
                if (action === "approve") {
                    $(`button.reject-btn[data-leave-id='${leaveId}']`).prop("disabled", true).css({"background": "#ccc", "color": "#666"});
                } else {
                    $(`button.approve-btn[data-leave-id='${leaveId}']`).prop("disabled", true).css({"background": "#ccc", "color": "#666"});
                }

                // Update row data-status for filtering
                $("#row-" + leaveId).data("status", newLStatus);
            },
            error: function(xhr) {
                console.log("Error Details:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }
        });
    });

    // Set default status text and styling
    $(".status").each(function() {
        if ($(this).text().trim() === "") {
            $(this).text("Pending").css({"color": "orange", "font-weight": "bold"});
        }
    });
});


$(document).ready(function() { 
    function updatePendingCount() {
        var pendingCount = $(".leave-row").filter(function() {
            return $(this).data("status") == 0;
        }).length;
        $("#pending-tab").html(`Pending <span style="background: red; color: white; padding: 2px 6px; border-radius: 10px; font-size: 12px;">${pendingCount}</span>`);
    }
    updatePendingCount();
});


$(document).ready(function() {
    // Filter rows based on status when tabs are clicked
    $("#pending-tab").click(function () {
        $("#pending th:nth-child(8), #pending td:nth-child(8)").hide();
        $(".leave-row").each(function () {
            if ($(this).data("status") == 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $("#all-tab, #approved-tab, #rejected-tab").click(function () {
        $("#pending th:nth-child(8), #pending td:nth-child(8)").show();
        $(".leave-row").show();
    });

    // Handle approve/reject button clicks
    $(".approve-btn, .reject-btn").click(function() {
        var button = $(this);
        var userName = button.data("id"); // For sending email
        var leaveId = button.data("leave-id"); // For updating t_status
        var action = button.hasClass("approve-btn") ? "approve" : "reject";

        $.ajax({
            url: "/send-response-email",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: userName,
                leave_id: leaveId,
                action: action
            },
            success: function(response) {
                alert(response.message);
                var newStatus = action === "approve" ? "1" : "2";
                $("#t_status-" + leaveId).text(newStatus).css({
                    "color": action === "approve" ? "green" : "red",
                    "font-weight": "bold"
                });
                button.text(action === "approve" ? "Approved" : "Rejected")
                    .prop("disabled", true)
                    .removeClass(action + "-btn")
                    .addClass("disabled-btn")
                    .css({"background": action === "approve" ? "green" : "red", "color": "white"});
                $("#row-" + leaveId).data("status", newStatus);
            },
            error: function(xhr) {
                console.log("Error Details:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }
        });
    });

    // Set default status text and styling
    $(".status").each(function() {
        if ($(this).text().trim() === "") {
            $(this).text("Pending").css({"color": "orange", "font-weight": "bold"});
        }
    });
});



	function deleteConfirmation(id)
 	{
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
			let _url = `/leave/destroy/${id}`;
			$.ajax({
				type: 'POST',  
				url: _url,
				data: {_token: token},  
				success: function () {
					swal("Done!", "It was succesfully deleted!", "success");
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