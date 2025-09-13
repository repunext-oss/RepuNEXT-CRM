@extends('admin.admin_master')
@section('admin')
<style>
.password-container {
    display: flex;
    align-items: center;
    position: relative;
}

.password-input {
    border: 0px solid #ccc;
    border-radius: 5px;
    padding: 5px 10px;
    width: 150px;
}

.toggle-password {
    margin-left: -30px;
    cursor: pointer;
    color: #333;
}
</style>
<?php $rolerawdata = session('userRoles', []);?>
<style>.st-drop{ border:1px solid #b9b9b9 !important;}</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">SubDomain List</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / SubDomain</span>
					</h3>
					@if(in_array("subdomain_all",$rolerawdata, TRUE) || in_array("subdomain_create",$rolerawdata, TRUE)|| in_array("kt_roles_select_all",$rolerawdata, TRUE))
					<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
							<a href="{{ route('add.sddetail') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" >
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
				</div> 
				<div class="card-body pt-0"> 
					<table class="table border align-middle rounded  dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
						<thead> 
						<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted bg-light">
							<th class="w-8px pe-2"> </th> 
							<th >#</th>
							<th class="min-w-115px sorting">SubDomain Name</th>  
							<th class="min-w-115px sorting">SubDomain Category</th> 
							<th class="min-w-125px sorting">Credentials</th>
							<!-- <th class="min-w-125px sorting">password</th>     -->
							<!-- <th class="min-w-100px sorting">Status</th>    -->
							<th class="min-w-125px sorting">Actions</th> 
						</tr> 
						</thead> 
							
						<tbody class="fw-semibold text-gray-600">
							<?php $j = 0; ?>
							@foreach($repn as $repns)
							<tr>
								<td></td>
								<td>{{ $j += 1 }}</td>
								<td>
									<button class="btn btn-sm btn-light text-black" onclick="showDetails('{{ $repns->subdomain_name }}', '{{ $repns->host_id }}')" class="text-primary text-decoration-underline">
										{{ $repns->subdomain_name }}
									</button>
									<div id="detailsTable_{{ $repns->subdomain_name }}" class="mt-3 d-none">
									<table class="table table-bordered" style="border: 2px solid black;">
									<tbody>
										<tr>
										<th class="bg-success text-center p-1" style="border: 1px solid black;">Hostname:</th>
										<td id="hostname_{{ $repns->subdomain_name }}"class="p-1" style="border: 1px solid black;"></td>
										</tr>
										<tr>
										<th class="bg-success text-center p-1" style="border: 1px solid black;">UN:</th>
										<td id="hostusername_{{ $repns->subdomain_name }}" class="p-1"style="border: 1px solid black;"></td>
										</tr>
										<tr>
										<th class="bg-success text-center p-1" style="border: 1px solid black;">PD:</th>
										<td id="hostpassword_{{ $repns->subdomain_name }}"class="p-1" style="border: 1px solid black;"></td>
										</tr>
									</tbody>
									</table>
									</div>
								</td>
								<td>
									@foreach($type as $types)
										@if($types->id == $repns->type)
											{{ $types->type_name }}
										@endif
									@endforeach
								</td>
								<td>UN: {{ $repns->backend_user }} <br>
									<div class="password-container">
									PD: <input type="password" class="password-input" value="{{ $repns->backend_password }}" readonly>
										<i class="fas fa-eye toggle-password"></i>
									</div>
								</td> 
								<!-- <td>
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" onchange="Check(this, {{ $repns->id }})" 
										@if($repns->state_status == 0) checked @endif>
									</div>
								</td> -->

								<!-- Action Buttons -->
								<td>
									<div class="d-flex gap-2">
										@if(in_array("subdomain_all",$rolerawdata, TRUE) || in_array("subdomain_read",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))										
										<a href="{{ route('view.sddetail', $repns->id) }}" class="btn btn-sm btn-warning">
											<i class="fa fa-eye"></i>
										</a>
										@endif
										@if(in_array("subdomain_all",$rolerawdata, TRUE) || in_array("subdomain_write",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))										
										<a href="{{ route('edit.sddetail', $repns->id) }}" class="btn btn-sm btn-info">
											<i class="fa fa-edit"></i>
										</a>
										@endif
										@if(in_array("subdomain_all",$rolerawdata, TRUE) || in_array("subdomain_delete",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))										
										<a href="#" onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-sm btn-danger">
											<i class="fa fa-trash"></i>
										</a>
										@endif
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>


					</table>

				

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
				let _url = `/project/subdomain/destroy/${id}`;  // Dynamically insert id here
				
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

	function Check(value,id) {  
		if(value.checked){ var statusval=0; }else{ var statusval=1; }  
		let token = "{{ csrf_token() }}";
			let _url = `/project/subdomain/status`; 
			$.ajax({
				type: 'POST',  
				url: _url,
				data: {_token: token, id:id, statusval: statusval},  
				success: function () {
					Swal.fire({icon: 'success',title: 'The status has been switched',showConfirmButton: false,timer: 1500}); 
				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal("Error Status!", "Please try again", "error");
				}
			}); 
    }; 
</script>
   <script>
    function showDetails(domainName, hostId) {
        // Define host details
        var hostDetails = {
            @foreach($host as $hosts)
            "{{ $hosts->id }}": {
                hostname: "{{ $hosts->host_name }}",
                hostusername: "{{ $hosts->host_username }}",
                hostpassword: "{{ $hosts->host_password }}"
            }
            @if(!$loop->last), @endif
            @endforeach
        };

        // Check if the host details exist
        if (hostDetails[hostId]) {
            // Update the dynamic elements for the specific domain name
            document.getElementById("hostname_" + domainName).innerText = hostDetails[hostId].hostname;
            document.getElementById("hostusername_" + domainName).innerText = hostDetails[hostId].hostusername;
            document.getElementById("hostpassword_" + domainName).innerText = hostDetails[hostId].hostpassword;

            // Toggle visibility of the details table
            var table = document.getElementById("detailsTable_" + domainName);
            if (table) {
                table.classList.toggle("d-none");
            } else {
                alert("Details table not found!");
            }
        } else {
            alert("Host details not found!");
        }
	}
    
</script>
<!-- Password Hide And Show -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function (toggleIcon) {
        toggleIcon.addEventListener('click', function () {
            const passwordInput = this.previousElementSibling;
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    });
});
</script>
@endsection