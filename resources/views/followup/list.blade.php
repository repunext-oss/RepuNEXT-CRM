@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []);?>
<style>.st-drop{ border:1px solid #b9b9b9 !important;}
.enquiry-ref-style {
    color: black !important;
    font-weight: bold;
}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
		<div class="card "style="background-color: #E1EBEE"> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bold fs-3 mb-1">FOLLOWUP LIST
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
							<path d="M9 11h10v2H9v-2zm0 4h10v2H9v-2zM3 11.5l1.5-1.5 2.5 2.5-1.5 1.5-2.5-2.5zm0 4l1.5-1.5 2.5 2.5-1.5 1.5-2.5-2.5zM9 7h10v2H9V7zM3 7l1.5-1.5L7 8 5.5 9.5 3 7z"/>
						</svg>
						
					</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Followup List</span>
					</h3>
					@if(in_array("followup_all",$rolerawdata, TRUE) || in_array("followup_create",$rolerawdata, TRUE)|| in_array("kt_roles_select_all",$rolerawdata, TRUE))
					<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
							<a href="{{ route('add.followup') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" >
								<span class="svg-icon svg-icon-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
										<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
									</svg>
							</span>Add</button> 
						</a>
					</div>
					@endif
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
					@if(in_array("followup_all",$rolerawdata, TRUE) || in_array("followup_create",$rolerawdata, TRUE) || in_array("followup_write",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
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
				<div class="container mt-4">
					<ul class="nav nav-tabs mb-3 border-0 justify-content custom-nav-tabs" id="followupTabs" role="tablist">
						<li class="nav-item me-3"></li>
						<li class="nav-item">
							<a class="nav-link active fw-bold px-5 py-3 pill" id="list-tab" data-bs-toggle="tab" href="#list-content" role="tab" aria-controls="list-content" aria-selected="true">
								<i class="fas fa-list text-black"></i> All
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fw-bold px-5 py-3 pill" id="pending-tab" data-bs-toggle="tab" href="#pending-content" role="tab" aria-controls="pending-content" aria-selected="false">
								<i class="fas fa-clock text-black"></i> Pending
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fw-bold px-5 py-3 pill" id="completed-tab" data-bs-toggle="tab" href="#completed-content" role="tab" aria-controls="completed-content" aria-selected="false">
								<i class="fas fa-check-circle text-black"></i> Completed
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link fw-bold px-5 py-3 pill" id="notpicked-tab" data-bs-toggle="tab" href="#notpicked-content" role="tab" aria-controls="notpicked-content" aria-selected="false">
								<i class="fas fa-phone-slash text-black"></i> Not Picked
							</a>
						</li>
					</ul>

					<div class="tab-content" id="followupTabContent">
					<div class="tab-pane fade show active" id="list-content" role="tabpanel" aria-labelledby="list-tab">
						<div class="card-body pt-0">
							<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
								<thead>
									<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted " style="background-color: #002244;">
										<th class="w-10px pe-2"></th>
										<th>#</th>
										<th class="min-w-125px sorting">Enquiry Ref ID</th>
										<th class="min-w-125px sorting">Date</th>
										<th class="min-w-125px sorting">Description</th>
										<th class="min-w-125px sorting">Status</th>
										<th class="min-w-125px sorting">Actions</th>
									</tr>
								</thead>
								<tbody class="fw-semibold text-gray-600">
									<?php $j = 0; ?>
									@foreach($repn as $repns)
										<tr>
											<td></td>
											<td>{{ ++$j }}</td>
											<td class="enquiry-ref-id">
												@foreach($support as $supports)
													@if($supports->id == $repns->Enquiry_ref_id)
														{{ $supports->Name }}
													@endif
												@endforeach
											</td>
											<td class="date-cell">{{ $repns->date }}</td>
											<td>{{ $repns->description }}</td>
											<td>{{ $repns->Status }}</td>
											<td>
												@if(in_array("followup_all", $rolerawdata, TRUE) || in_array("followup_read", $rolerawdata, TRUE) || in_array("kt_roles_select_all", $rolerawdata, TRUE))
												
													<a href="{{route('view.followup', $repns->id)}}" class="btn btn-sm  align-self-center" style="text-transform: none; background-color: #002244; color:white;">
														<i class="fa fa-eye" aria-hidden="true"></i>view
													</a>  
												@endif
												@if(in_array("followup_all", $rolerawdata, TRUE) || in_array("followup_write", $rolerawdata, TRUE) || in_array("kt_roles_select_all", $rolerawdata, TRUE))
													<a href="{{ route('edit.followup', $repns->id) }}" class="btn btn-sm btn-info">
														<i class="fa fa-edit"></i>
													</a>
												@endif
												@if(in_array("followup_all", $rolerawdata, TRUE) || in_array("followup_delete", $rolerawdata, TRUE) || in_array("kt_roles_select_all", $rolerawdata, TRUE))
													<a href="#" onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-sm btn-danger">
														<i class="fa fa-trash"></i>
													</a>
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>		

					<div class="tab-pane fade" id="pending-content" role="tabpanel" aria-labelledby="pending-tab">
						<div class="card-body">
							<h3 class="fw-bold">Pending Followups</h3>
							<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5">
								<thead>
									<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted " style="background-color: #002244;">
									<th class="w-10px pe-2"></th> 
										<th>#</th>
										<th class="min-w-125px sorting">Enquiry Ref ID</th>
										<th class="min-w-125px sorting">Date</th>
										<th class="min-w-125px sorting">Description</th>
										<th class="min-w-125px sorting">Status</th>
										<th class="min-w-125px sorting">Actions</th>
									</tr>
								</thead>
								@php
									$today = now()->toDateString(); 
									$todayRepn = $repn->where('Status', 'Pending')->where('date', $today);
									$otherRepn = $repn->where('Status', 'Pending')->where('date', '!=', $today)->sortBy('date');
									$sortedRepn = $todayRepn->merge($otherRepn);
								@endphp

								<tbody class="fw-semibold text-gray-600">
									@foreach($sortedRepn as $repns)
										<tr>
											<td></td>
											<td>{{ $loop->iteration }}</td>
											<td>
												@foreach($support as $supports) 
													@if($supports->id == $repns->Enquiry_ref_id)
														{{ $supports->Name }}
													@endif
												@endforeach
											</td>
											<td>{{ $repns->date }}</td>
											<td>{{ $repns->description }}</td>
											<td>{{ $repns->Status }}</td>
											<td>
												@if(in_array("followup_all",$rolerawdata, TRUE)||in_array("followup_read",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<a href="{{route('view.followup', $repns->id)}}" class="btn btn-sm  align-self-center" style="text-transform: none; background-color: #002244; color:white;">
														<i class="fa fa-eye" aria-hidden="true"></i>view
													</a>  
												@endif
												@if(in_array("followup_all",$rolerawdata, TRUE)||in_array("followup_write",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<a href="{{ route('edit.followup', $repns->id) }}" class="btn btn-sm btn-info">
													<i class="fa fa-edit"></i>
												</a>
												@endif
												@if(in_array("followup_all",$rolerawdata, TRUE)||in_array("followup_delete",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
												<a href="#" onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-sm btn-danger">
													<i class="fa fa-trash"></i>
												</a>
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>

							</table>
						</div>
					</div>
	
					<div class="tab-pane fade" id="notpicked-content" role="tabpanel" aria-labelledby="notpicked-tab">
						<div class="card-body">
							<h3 class="fw-bold">Not Picked Followups</h3>
							<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5">
								<thead>
									<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted " style="background-color: #002244;">
										<th class="w-10px pe-2"></th>
										<th>#</th>
										<th class="min-w-125px sorting">Enquiry Ref ID</th>
										<th class="min-w-125px sorting">Date</th>
										<th class="min-w-125px sorting">Description</th>
										<th class="min-w-125px sorting">Status</th>
										<th class="min-w-125px sorting">Actions</th>
									</tr>
								</thead>
								<tbody class="fw-semibold text-gray-600">
									@foreach($repn as $repns)
										@if($repns->Status === 'Not Picked')
											<tr>
												<td></td>
												<td>{{ $loop->iteration }}</td>
												<td>
													@foreach($support as $supports)
														@if($supports->id == $repns->Enquiry_ref_id)
															{{ $supports->Name }}
														@endif
													@endforeach
												</td>
												<td>{{ $repns->date }}</td>
												<td>{{ $repns->description }}</td>
												<td>{{ $repns->Status }}</td>
												<td>
													@if(in_array("followup_all", $rolerawdata, TRUE) || in_array("followup_read", $rolerawdata, TRUE) || in_array("kt_roles_select_all", $rolerawdata, TRUE))
													<a href="{{route('view.followup', $repns->id)}}" class="btn btn-sm  align-self-center" style="text-transform: none; background-color: #002244; color:white;">
														<i class="fa fa-eye" aria-hidden="true"></i>view
													</a>  
													@endif
													@if(in_array("followup_all", $rolerawdata, TRUE) || in_array("followup_write", $rolerawdata, TRUE) || in_array("kt_roles_select_all", $rolerawdata, TRUE))
														<a href="{{ route('edit.followup', $repns->id) }}" class="btn btn-sm btn-info">
															<i class="fa fa-edit"></i>
														</a>
													@endif
													@if(in_array("followup_all", $rolerawdata, TRUE) || in_array("followup_delete", $rolerawdata, TRUE) || in_array("kt_roles_select_all", $rolerawdata, TRUE))
														<a href="#" onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-sm btn-danger">
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

			
					<div class="tab-pane fade" id="completed-content" role="tabpanel" aria-labelledby="completed-tab">
						<div class="card-body">
							<h3 class="fw-bold">Completed Followups</h3>
							<table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5">
								<thead>
									<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted" style="background-color: #002244;">
									<th class="w-10px pe-2"></th> 
											<th>#</th>
											<th class="min-w-125px sorting">Enquiry Ref ID</th>
											<th class="min-w-125px sorting">Date</th>
											<th class="min-w-125px sorting">Description</th>
											<th class="min-w-125px sorting">Status</th>
											<th class="min-w-125px sorting">Actions</th>
									</tr> 
								</thead>
								<tbody class="fw-semibold text-gray-600">
									@foreach($repn as $repns)
										@if($repns->Status === 'Completed')
											<tr>
												<td></td>
												<td>{{ $loop->iteration }}</td>
												<td>
													@foreach($support as $supports) 
														@if($supports->id == $repns->Enquiry_ref_id)
															{{ $supports->Name }}
														@endif
													@endforeach
												</td>
												<td>{{ $repns->date }}</td>
												<td>{{ $repns->description }}</td>
												<td>{{ $repns->Status }}</td>
												<td>
													
													@if(in_array("followup_all",$rolerawdata, TRUE)||in_array("followup_read",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
													<a href="{{route('view.followup', $repns->id)}}" class="btn btn-sm  align-self-center" style="text-transform: none; background-color: #002244; color:white;">
														<i class="fa fa-eye" aria-hidden="true"></i>view
													</a>  
													@endif
													<!-- <a href="{{ route('edit.followup', $repns->id) }}" class="btn btn-sm btn-info">
														<i class="fa fa-edit"></i>
													</a>
													<a href="#" onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-sm btn-danger">
														<i class="fa fa-trash"></i>
													</a> -->
												</td>
											</tr>
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
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    let today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
    let dateCells = document.querySelectorAll(".date-cell"); // Select all date cells

    let pendingCount = 0; // Counter for "Pending" follow-ups
    let notPickedCount = 0; // Counter for "Not Picked" follow-ups

    let pendingRefs = []; // Store Enquiry Ref IDs for Pending
    let notPickedRefs = []; // Store Enquiry Ref IDs for Not Picked

    dateCells.forEach(cell => {
        let row = cell.parentElement;
        let enquiryRefId = row.querySelector(".enquiry-ref-id")?.textContent.trim(); // Get Enquiry Ref ID
        let status = row.querySelector("td:nth-child(6)")?.textContent.trim(); // Get Status Column

        if (cell.textContent.trim() === today) {
            if (status === "Pending") {
                pendingCount++;
                pendingRefs.push(`<span class="enquiry-ref-style">${enquiryRefId}</span>`); // Style the ID
            } else if (status === "Not Picked") {
                notPickedCount++;
                notPickedRefs.push(`<span class="enquiry-ref-style">${enquiryRefId}</span>`); // Style the ID
            }
        }
    });

    // Function to update the badge dynamically
    function updateBadge(tabId, count, badgeId) {
        let tab = document.getElementById(tabId);
        let existingBadge = document.getElementById(badgeId);

        if (count > 0) {
            if (!existingBadge) {
                let badge = document.createElement("span");
                badge.className = "badge bg-danger ms-2";
                badge.id = badgeId;
                badge.textContent = count;
                tab.appendChild(badge);
            } else {
                existingBadge.textContent = count; // Update count dynamically
            }
        } else {
            if (existingBadge) existingBadge.remove(); // Remove badge if count is 0
        }
    }

    // Update Pending Tab Badge
    updateBadge("pending-tab", pendingCount, "pending-badge");

    // Update Not Picked Tab Badge
    updateBadge("notpicked-tab", notPickedCount, "notpicked-badge");

    // Show notification inside the list content
    let notificationDiv = document.createElement("div");
    notificationDiv.className = "alert alert-warning mt-3";
    notificationDiv.id = "followup-alert"; // Assign an ID for easy removal
    notificationDiv.innerHTML = `
        ${pendingCount > 0 ? `<strong>🔔 ${pendingCount} Pending Follow-ups Today!</strong><br>Enquiry Ref IDs: ${pendingRefs.join(", ")}<br><br>` : ""}
        ${notPickedCount > 0 ? `<strong>📞 ${notPickedCount} Not Picked Follow-ups Today!</strong><br>Enquiry Ref IDs: ${notPickedRefs.join(", ")}` : ""}
    `;

    if (pendingCount > 0 || notPickedCount > 0) {
        document.getElementById("list-content").prepend(notificationDiv);
    }

    // Remove badge and alert when clicking on the respective tabs
    document.getElementById("pending-tab").addEventListener("click", function () {
        let pendingBadge = document.getElementById("pending-badge");
        if (pendingBadge) pendingBadge.remove();
    });

    document.getElementById("notpicked-tab").addEventListener("click", function () {
        let notPickedBadge = document.getElementById("notpicked-badge");
        if (notPickedBadge) notPickedBadge.remove();
    });
});
</script>

<script>  
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
			let _url = `/followup/destroy/${id}`;

			$.ajax({
				type: 'POST',  
				url: _url,
				data: {_token: token},  
				success: function () {
					swal("Done!", "It was successfully deleted!", "success");
					location.reload();  
				},
				error: function () {
					swal("Error deleting!", "Please try again", "error");
				}
			}); 
		});  
	}
</script>

@endsection
