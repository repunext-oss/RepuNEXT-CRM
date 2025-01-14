@extends('admin.admin_master')
@section('admin')
<?php $rolerawdata = session('userRoles', []);?>
<style>.st-drop{ border:1px solid #b9b9b9 !important;}</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card "> 
				<div class="card-header pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">List</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / Project / Type</span>
					</h3>
					<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-kt-initialized="1">
						<a href="{{route('add.ttime')}}" class="btn btn-sm btn-primary" >Add</a>
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
					<div class="card-toolbar flex-row-fluid justify-content-end gap-5"> 
						<!-- <input class="form-control form-control-solid w-100 mw-250px" placeholder="Pick date range" id="kt_ecommerce_report_views_daterangepicker" />
						<div class="w-150px"> 
							<select class="form-select form-select-solid st-drop" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-order-filter="rating">
								<option></option>
								<option value="all">All</option>
								<option value="rating-1">UnPaid</option>
								<option value="rating-2">Paid</option>
							</select> 
						</div>  -->
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
							<th class="min-w-115px sorting">Type Name</th> 
					
							<th class="min-w-115px sorting">Status</th>   
							<th class="min-w-150px sorting">Actions</th> 
						</tr> 
						</thead> 
						<tbody class="fw-semibold text-gray-600">
							<?php $j=0; ?>    
							@foreach($repn as $repns)
							<tr>
								<td></td>
								<td>{{$j+=1;}}</td> 
								<td>{{ $repns->type_name}} </td> 
								
								<td><label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-0">    
								<input class="form-check-input" type="checkbox" onchange="Check(this,{{$repns->id}})" @if($repns->state_status==0) checked @endif></label></td>       
								<td><a href="{{route('view.ttime', $repns->id)}}" class="btn btn-sm btn-warning align-self-center" style="border-radius: 100px;padding: 8px 8px 8px 10px;"><i class="fa fa-eye" aria-hidden="true"></i></a>          
									<a href="{{route('edit.ttime', $repns->id)}}" class="btn btn-sm btn-info align-self-center" style="border-radius: 104px;padding: 8px 8px 10px 13px;margin: 0px 1px;"><i class="fa fa-edit" aria-hidden="true"></i></a>
									<a href="#" onclick="deleteConfirmation({{$repns->id}})" data-id="{{ $repns->id }}" class="btn btn-sm crop-delete btn-danger align-self-center" style="border-radius: 100px;padding: 8px 8px 8px 12px;"><i class="fa fa-trash" aria-hidden="true"></i></a>  
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
				let _url = `/project/types/destroy/${id}`;  // Dynamically insert id here
				
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
			let _url = `/project/types/status`; 
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
@endsection