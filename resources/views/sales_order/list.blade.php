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
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" class="form-control form-control-solid w-250px ps-14" placeholder="Search SalesOrder">
                        </div>
                    </div>
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
                        <a href="{{ route('add.salesorder') }}" class="btn btn-primary">Add</a>
                    </div>
                </div>
                <div class="card-body pt-0"> 
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="kt_ecommerce_report_views_table">
                            <thead> 
                                <tr class="fw-bold text-muted">
                                    <th class="min-w-90px text-start">S.No</th>
                                    <th class="min-w-100px text-start">Date</th>
                                    <th class="min-w-100px text-start">Invoice Number</th>
                                    <th class="min-w-100px text-start">Company Name</th>
                                    <th class="min-w-100px text-start">Customer Phone Number</th>
                                    <th class="min-w-100px text-start">Address</th>
                                    <th class="min-w-100px text-start">GST Number</th>
                                    <th class="min-w-100px text-start">Grand Total Amount</th>
                                    <th class="min-w-100px text-start">Status</th>
                                    <th class="min-w-100px text-start">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($repn as $repns)
                                <tr>
                                    <td class="text-start">{{ $repns->id }}</td>
                                    <td class="text-start">{{ $repns->date }}</td>
                                    <td class="text-start">{{ $repns->invoice_number }}</td>
                                    <td class="text-start">{{ $repns->company_name }}</td>
                                    <td class="text-start">{{ $repns->customer_phone_number }}</td>
                                    <td class="text-start">{{ $repns->address }}</td>
                                    <td class="text-start">{{ $repns->gst_number }}</td>
                                    <td class="text-start">{{ $repns->grandtotal_amount }}</td>
                                    <td class="text-start">
                                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" onchange="Check(this,{{$repns->id}})" @if($repns->status==1) checked @endif>
                                        </div>  
                                    </td>
                                    <td class="text-start">
                                        <a href="{{ route('view.salesorder', $repns->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </a>
                                        <a href="{{ route('preview.salesorder', $repns->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fa fa-file-alt"></i>
                                            </span>
                                        </a>
                                        <button onclick="deleteConfirmation({{ $repns->id }})" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </button>
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