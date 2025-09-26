@extends('admin.admin_master')
@section('admin')

<?php $rolerawdata = session('userRoles', []); ?>
<style>
    .st-drop {
        border: 1px solid #b9b9b9 !important;
    }
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div class="container-xxl" id="kt_content_container">
            <div class="card">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">List</span>
                        <span class="text-muted fw-semibold fs-7">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a> / Sales /  Order
                        </span>
                    </h3>
                    @if(in_array("sale_all",$rolerawdata, TRUE) || in_array("sale_create",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('add.salesorder') }}">
                            <button type="button" class="btn btn-primary">
                                <span class="svg-icon svg-icon-2">
                                    <i class="fa fa-plus"></i>
                                </span>
                                Add
                            </button>
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" class="form-control form-control-solid w-250px ps-14" placeholder="Search SalesOrder">
                        </div>
                    </div>
                    @if(in_array("sale_all",$rolerawdata, TRUE) || in_array("sale_create",$rolerawdata, TRUE) || in_array("sale_write",$rolerawdata, TRUE)  || in_array("sale_read",$rolerawdata, TRUE) || in_array("kt_roles_select_all",$rolerawdata, TRUE))
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <button type="button" class="btn btn-light-primary st-drop" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-file-export"></i>
                            </span>
                            Export Report
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
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
                
                <div class="card-body pt-0"> 
                    <table class="table border align-middle rounded dataTable table-row-dashed fs-6 gy-5" id="kt_ecommerce_report_views_table">
                        <thead> 
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase text-muted bg-light">
                            <th class="w-8px pe-2"> </th>
                            <th style="width: 50px;">#</th>
                            <th style="width: 200px;">Date</th>
                            <th style="width: 200px;">Invoice Number</th>
                            <th style="width: 200px;">Company Name</th>
                            <th style="width: 300px;">Customer Contact</th>
                            <th style="width: 300px;">Amount</th>
                            <th style="width: 150px;">Status</th>
                            <th style="width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($repn as $repns)

                            <tr>
                            <td class="w-8px pe-2"> </td>
                                <td>{{ $repns->id }}</td>
                                <td>{{ $repns->date }}</td>
                                <td>{{ 'RN/D/12/' . str_pad($repns->invoice_number, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $repns->company_name}}</td>
                                <td>{{ $repns->customer_phone_number}}</td>
                                <td>₹{{ number_format($repns->grandtotal_amount) }}</td>
                                <td>
                                <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-0">    
                                    <input class="form-check-input" type="checkbox" onchange="Check(this,{{$repns->id}})" @if($repns->status==1) checked @endif></label>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(in_array("sale_all",$rolerawdata, TRUE)||in_array("sale_read",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
                                        <a href="{{ route('view.salesorder', $repns->id) }}" class="btn btn-warning btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="fa fa-eye" style="margin-left: 3px;"></i>
                                        </a>
                                        @endif
                                        @if(in_array("sale_all",$rolerawdata, TRUE)||in_array("sale_write",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
                                        <a href="{{ route('preview.salesorder', $repns->id) }}" class="btn btn-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="fa fa-file-alt" style="margin-left: 3px;"></i>
                                        </a>
                                        @endif
                                        @if(in_array("sale_all",$rolerawdata, TRUE)||in_array("sale_delete",$rolerawdata, TRUE)||in_array("kt_roles_select_all",$rolerawdata, TRUE))
                                        <button onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="fa fa-trash" style="margin-left: 3px;"></i>
                                        </button>
                                        @endif
                                    </div>
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
			let _url = `/salesorder/destroy/${id}`;
			$.ajax({
				type: 'DELETE',  
				url: _url,
				data: {_token: token},  
				success: function (response) {
					swal("Deleted!", response.success, "success");
					location.reload();  
				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal("Error deleting!", "Please try again", "error");
				}
			}); 
		});
    }
    
    function Check(value,id) {  
		if(value.checked){ var statusval=1; }else{ var statusval=0; }  
		let token = "{{ csrf_token() }}";
			let _url = `/salesorder/status`; 
			$.ajax({
				type: 'POST',  
				url: _url,
				data: {_token: token, id:id, statusval: statusval},  
				success: function (response) {
					Swal.fire({icon: 'success',title: 'The status has been switched',showConfirmButton: false,timer: 1500}); 
				},
				error: function (xhr, ajaxOptions, thrownError) {
					swal("Error Status!", "Please try again", "error");
				}
			}); 
    }; 
    
</script>
@endsection
