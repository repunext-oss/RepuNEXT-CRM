@extends('admin.admin_master')
@section('admin')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container-xxl" id="kt_content_container">
			<div class="card">
				<div class="card-header border-0 pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bold fs-3 mb-1">PO List</span>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / PO / List</span>
					</h3>
					<div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-kt-initialized="1">
						<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">Add</a>
					</div>
				</div>
				<div class="card-body pt-5 pb-0">
					<table id="PoTable" class="table border rounded gy-5 gs-7 dataTable no-footer" aria-describedby="kt_datatable_example_1_info">
						<thead>
							<tr class="fw-bold text-muted bg-light">
								<th>#</th>
								<th>PO Number</th>    
								<th>Vendor Name</th>
								<th>Contact</th>         
								<th>Status</th>
								<th style="text-align:right;">Actions</th>
							</tr>
						</thead>
						<tbody> 
							<tr><td>3</td>
								<td>e</td>
								<td>e</td>
								<td>e</td>
								<td>e</td>
								<td>e</td>
							</tr>
							<tr><td>3</td>
								<td>e</td>
								<td>e</td>
								<td>e</td>
								<td>e</td>
								<td>e</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready( function () {
		$('#PoTable').DataTable(); 
	} );
</script>
@endsection