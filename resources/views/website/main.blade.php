@extends('admin.admin_master')
@section('admin')
<a href="https://icons8.com/icon/EyIXT8ZB2OnH/visible"></a> <a href="https://icons8.com"></a>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

	<div class="post d-flex flex-column-fluid" id="kt_post">
		<div id="kt_content_container" class="container-xxl">
			<div class="card">
				<div class="card-header border-0 pt-6">
					<h3 class="card-title align-items-start flex-column">
						<a href="/list/">
							<span class="card-label fw-bold fs-3 mb-1"> Website Credentials
							</span>
						</a>
						<span class="text-muted fw-semibold fs-7"><a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a> / websitecredentials
						</span>
					</h3>
					<div class="card-toolbar">
						<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
							<a href="{{ route('website.add') }}"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
									<span class="svg-icon svg-icon-2">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
											<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
										</svg>
									</span>Add</button> </a>
						</div>
					</div>
				</div>
				<div class="card-body border-top pt-0"></br>
					<table id="PoTable" class="table border rounded gy-5 gs-7 dataTable no-footer" aria-describedby="kt_datatable_example_1_info">
						<thead>
							<tr class="fw-bold text-muted bg-light">
								<th>S.No</th>
								<th>Website</th>
								<th>URL</th>
								<th>User Name</th>
								<th>Password</th>
								<th>Completion Date</th>
								<th>Next Renewal Date</th>
								<th>Client Contact 1</th>
								<th>Client Contact 2</th>
								<th>Month</th>
								<th>Action</th>
								<th>View</th>
								<!-- <th style="text-align:right;">Actions</th> -->
							</tr>
						</thead>
						<tbody>
							@foreach($websitecredential as $d)
							<tr>
								<td>{{$d->id}}</td>
								<td>{{$d->Website}}</td>
								<td>{{$d->URL}}</td>
								<td>{{ str_repeat('*', strlen($d->User_Name)) }}</td>
								<td>{{ str_repeat('*', strlen($d->Password)) }}</td>
								<td>{{$d->Completion_Date}}</td>
								<td>{{$d->Next_Renewal_Date}}</td>
								<td>{{$d->Client_Contact1}}</td>
								<td>{{$d->Client_Contact2}}</td>
								<td>{{$d->Month}}</td>
								<td><a href="{{ route('website.edit',['d' => $d]) }}" class="btn btn-danger">Edit</a>


								</td>
								<td><a href="{{ route('website.view',['d'=> $d])}}"><img width="40" height="40" src="https://img.icons8.com/officel/40/preview-pane.png" alt="preview-pane" /></a></td>
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
	$(document).ready(function() {
		$('#emailTable').DataTable({
			dom: 'frtip',
		});
	});

	function onlyNumberKey(evt) {
		var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
			return false;
		return true;
	}

	function onlyAlphaKey(evt) {
		var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		if (ASCIICode > 31 && (ASCIICode < 65 || ASCIICode > 90) && (ASCIICode < 97 || ASCIICode > 122))
			return false;
		return true;
	}
	$(document).ready(function() {
		$('#PoTable').DataTable();
	});
</script>
@endsection